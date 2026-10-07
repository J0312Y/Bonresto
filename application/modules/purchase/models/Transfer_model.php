<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transfer_model extends CI_Model
{
    protected $saas_db;

    public function __construct()
    {
        parent::__construct();
        $this->saas_db = $this->load->database('saas', true);
    }

    /**
     * Get sibling tenants in the same group.
     */
    public function get_siblings($group_id, $current_tenant_id)
    {
        if (empty($group_id) || $group_id == 0) return [];

        return $this->saas_db->select('tenant_id, business_name, db_name')
            ->where('group_id', $group_id)
            ->where('tenant_id !=', $current_tenant_id)
            ->where('status', 'active')
            ->get('saas_tenants')
            ->result();
    }

    /**
     * Create a transfer record in SaaS DB.
     */
    public function create_transfer($from_id, $to_id, $items, $notes, $created_by)
    {
        $this->saas_db->insert('stock_transfers', [
            'from_tenant_id' => $from_id,
            'to_tenant_id'   => $to_id,
            'notes'          => $notes,
            'created_by'     => $created_by,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        $transfer_id = $this->saas_db->insert_id();

        foreach ($items as $item) {
            $this->saas_db->insert('stock_transfer_items', [
                'transfer_id'      => $transfer_id,
                'ingredient_name'  => $item['ingredient_name'],
                'ingredient_id_from' => $item['ingredient_id'],
                'quantity'         => $item['quantity'],
                'unit'             => $item['unit'],
                'unit_cost'        => $item['unit_cost'] ?? null,
            ]);
        }

        return $transfer_id;
    }

    /**
     * Get outgoing transfers for a tenant.
     */
    public function get_outgoing($tenant_id)
    {
        $transfers = $this->saas_db->select('st.*, t.business_name as to_name')
            ->from('stock_transfers st')
            ->join('saas_tenants t', 't.tenant_id = st.to_tenant_id', 'left')
            ->where('st.from_tenant_id', $tenant_id)
            ->order_by('st.created_at', 'DESC')
            ->limit(50)
            ->get()
            ->result();

        return $transfers;
    }

    /**
     * Get incoming transfers for a tenant.
     */
    public function get_incoming($tenant_id)
    {
        $transfers = $this->saas_db->select('st.*, t.business_name as from_name')
            ->from('stock_transfers st')
            ->join('saas_tenants t', 't.tenant_id = st.from_tenant_id', 'left')
            ->where('st.to_tenant_id', $tenant_id)
            ->order_by('st.created_at', 'DESC')
            ->limit(50)
            ->get()
            ->result();

        return $transfers;
    }

    /**
     * Get pending incoming transfers.
     */
    public function get_pending_incoming($tenant_id)
    {
        return $this->saas_db->select('st.*, t.business_name as from_name')
            ->from('stock_transfers st')
            ->join('saas_tenants t', 't.tenant_id = st.from_tenant_id', 'left')
            ->where('st.to_tenant_id', $tenant_id)
            ->where('st.status', 'pending')
            ->order_by('st.created_at', 'DESC')
            ->get()
            ->result();
    }

    /**
     * Get transfer details.
     */
    public function get_transfer($transfer_id)
    {
        return $this->saas_db->where('id', $transfer_id)
            ->get('stock_transfers')
            ->row();
    }

    /**
     * Get items for a transfer.
     */
    public function get_transfer_items($transfer_id)
    {
        return $this->saas_db->where('transfer_id', $transfer_id)
            ->get('stock_transfer_items')
            ->result();
    }

    /**
     * Revendique un transfert encore en attente, de maniere atomique.
     *
     * Le controleur lisait le statut, puis ecrivait bien plus tard. Deux
     * confirmations simultanees du meme transfert passaient donc toutes les
     * deux le controle « pending », et le stock etait credite deux fois pour
     * un seul envoi. La condition est desormais portee DANS l'UPDATE : la
     * premiere requete emporte la ligne, la seconde n'en touche aucune et
     * l'apprend par affected_rows().
     *
     * @return bool true si c'est bien cet appel qui a emporte le transfert.
     */
    public function claim_pending($transfer_id, $confirmed_by)
    {
        $this->saas_db->where('id', (int) $transfer_id)
            ->where('status', 'pending')
            ->update('stock_transfers', [
                'status'       => 'confirmed',
                'confirmed_by' => $confirmed_by,
                'confirmed_at' => date('Y-m-d H:i:s'),
            ]);

        return $this->saas_db->affected_rows() === 1;
    }

    /**
     * Rend un transfert revendique a l'etat « pending ».
     *
     * Utilise quand le credit de stock a echoue apres la revendication : le
     * transfert doit rester confirmable, sans quoi il serait perdu.
     */
    public function release_claim($transfer_id)
    {
        $this->saas_db->where('id', (int) $transfer_id)
            ->update('stock_transfers', [
                'status'       => 'pending',
                'confirmed_by' => null,
                'confirmed_at' => null,
            ]);
    }

    /**
     * Associe une ligne de transfert a l'ingredient local correspondant.
     *
     * Le controleur atteignait `$this->transfer_model->saas_db` directement,
     * or cette propriete est protegee : l'acces tombait dans
     * CI_Model::__get(), qui le renvoyait vers le controleur, lequel n'a pas
     * cette propriete. L'appel se faisait donc sur null — erreur fatale. En
     * pratique confirm() echouait des la premiere ligne reconnue.
     */
    public function map_item_to_local($item_id, $local_ingredient_id)
    {
        $this->saas_db->where('id', (int) $item_id)
            ->update('stock_transfer_items', [
                'ingredient_id_to' => (int) $local_ingredient_id,
            ]);
    }

    /**
     * Supprime un transfert dont le stock n'a finalement pas quitte
     * l'expediteur.
     *
     * Un tel transfert n'a jamais existe : le laisser en « pending »
     * permettrait au destinataire de crediter du stock qui n'a jamais ete
     * debite nulle part. Le statut n'offre pas d'etat terminal adapte
     * — l'enum ne connait que pending, confirmed et rejected — et
     * « rejected » dirait une decision du destinataire qui n'a pas eu lieu.
     */
    public function delete_transfer($transfer_id)
    {
        $this->saas_db->where('transfer_id', (int) $transfer_id)
            ->delete('stock_transfer_items');
        $this->saas_db->where('id', (int) $transfer_id)
            ->delete('stock_transfers');
    }

    /**
     * Update transfer status.
     */
    public function update_status($transfer_id, $status, $confirmed_by = null)
    {
        $data = ['status' => $status];
        if ($confirmed_by) {
            $data['confirmed_by'] = $confirmed_by;
            $data['confirmed_at'] = date('Y-m-d H:i:s');
        }

        $this->saas_db->where('id', $transfer_id)->update('stock_transfers', $data);
    }
}
