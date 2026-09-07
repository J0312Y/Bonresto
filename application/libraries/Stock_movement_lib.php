<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Stock Movement Library
 * Centralized audit trail for all stock mutations (purchases, production, waste, adjustments).
 */
class Stock_movement_lib {

    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * Record a stock movement after a stock_qty update.
     *
     * @param int    $ingredient_id
     * @param string $movement_type  enum value (purchase, production, adjustment, etc.)
     * @param float  $quantity_change Positive for additions, negative for deductions
     * @param int|null $reference_id  ID of the source record
     * @param string|null $reference_type Table/entity name
     * @param float|null  $unit_cost  Cost per unit at time of movement
     * @param string|null $notes
     * @param string|null $adjustment_reason  Only for type='adjustment'
     * @return int|false  Insert ID or false on failure
     */
    public function record($ingredient_id, $movement_type, $quantity_change, $reference_id = null, $reference_type = null, $unit_cost = null, $notes = null, $adjustment_reason = null)
    {
        // Audit F-18 : ces sorties silencieuses laissaient des trous dans la
        // piste d'audit alors que le stock, lui, avait bouge. Elles restent des
        // sorties — creer la table ici serait pire — mais elles sont tracees.
        if (!$this->CI->db->table_exists('stock_movements')) {
            log_message('error', 'Stock_movement_lib : table stock_movements absente, '
                . 'mouvement non trace (ingredient ' . (int) $ingredient_id . ').');
            return false;
        }

        // Get the current stock_qty AFTER the update already happened
        $ingredient = $this->CI->db->select('stock_qty')
            ->where('id', $ingredient_id)
            ->get('ingredients')
            ->row();

        if (!$ingredient) {
            log_message('error', 'Stock_movement_lib : ingredient ' . (int) $ingredient_id
                . ' introuvable, mouvement non trace.');
            return false;
        }

        $data = [
            'ingredient_id'     => $ingredient_id,
            'movement_type'     => $movement_type,
            'quantity_change'   => $quantity_change,
            'quantity_after'    => $ingredient->stock_qty,
            'reference_id'      => $reference_id,
            'reference_type'    => $reference_type,
            'unit_cost'         => $unit_cost,
            'notes'             => $notes,
            'adjustment_reason' => $adjustment_reason,
            'created_by'        => $this->_get_user_id(),
            'created_at'        => date('Y-m-d H:i:s'),
        ];

        $this->CI->db->insert('stock_movements', $data);
        return $this->CI->db->insert_id();
    }

    /**
     * Record multiple movements in batch (e.g. production deducting several ingredients).
     *
     * @param array $movements Array of associative arrays with keys:
     *   ingredient_id, movement_type, quantity_change, reference_id, reference_type, unit_cost, notes
     */
    public function record_batch(array $movements)
    {
        // Audit F-18 : les retours de record() etaient ignores. La piste d'audit
        // pouvait donc comporter des trous sans qu'aucune alerte ne soit levee,
        // alors meme que le stock avait bouge. On remonte desormais l'echec :
        // il revient a l'appelant d'annuler sa transaction.
        $tout_trace = true;

        foreach ($movements as $m) {
            $id = $this->record(
                $m['ingredient_id'],
                $m['movement_type'],
                $m['quantity_change'],
                $m['reference_id'] ?? null,
                $m['reference_type'] ?? null,
                $m['unit_cost'] ?? null,
                $m['notes'] ?? null,
                $m['adjustment_reason'] ?? null
            );

            if ($id === false) {
                $tout_trace = false;
            }
        }

        return $tout_trace;
    }

    /**
     * Get movement history for an ingredient.
     *
     * @param int   $ingredient_id
     * @param array $filters  Optional: movement_type, date_from, date_to, limit, offset
     * @return array
     */
    public function get_movements($ingredient_id, array $filters = [])
    {
        $this->CI->db->where('ingredient_id', $ingredient_id);

        if (!empty($filters['movement_type'])) {
            $this->CI->db->where('movement_type', $filters['movement_type']);
        }
        if (!empty($filters['date_from'])) {
            $this->CI->db->where('created_at >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->CI->db->where('created_at <=', $filters['date_to'] . ' 23:59:59');
        }

        $limit  = isset($filters['limit']) ? (int) $filters['limit'] : 50;
        $offset = isset($filters['offset']) ? (int) $filters['offset'] : 0;

        $this->CI->db->order_by('created_at', 'DESC');
        $this->CI->db->limit($limit, $offset);

        return $this->CI->db->get('stock_movements')->result_array();
    }

    /**
     * Count total movements for pagination.
     */
    public function count_movements($ingredient_id, array $filters = [])
    {
        $this->CI->db->where('ingredient_id', $ingredient_id);

        if (!empty($filters['movement_type'])) {
            $this->CI->db->where('movement_type', $filters['movement_type']);
        }
        if (!empty($filters['date_from'])) {
            $this->CI->db->where('created_at >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->CI->db->where('created_at <=', $filters['date_to'] . ' 23:59:59');
        }

        return $this->CI->db->count_all_results('stock_movements');
    }

    /**
     * Get all movements (all ingredients) with filters — for adjustment history.
     */
    public function get_all_movements(array $filters = [])
    {
        $this->CI->db->select('sm.*, i.ingredient_name, u.uom_short_code');
        $this->CI->db->from('stock_movements sm');
        $this->CI->db->join('ingredients i', 'i.id = sm.ingredient_id', 'left');
        $this->CI->db->join('unit_of_measurement u', 'u.id = i.uom_id', 'left');

        if (!empty($filters['movement_type'])) {
            $this->CI->db->where('sm.movement_type', $filters['movement_type']);
        }
        if (!empty($filters['date_from'])) {
            $this->CI->db->where('sm.created_at >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->CI->db->where('sm.created_at <=', $filters['date_to'] . ' 23:59:59');
        }

        $limit  = isset($filters['limit']) ? (int) $filters['limit'] : 50;
        $offset = isset($filters['offset']) ? (int) $filters['offset'] : 0;

        $this->CI->db->order_by('sm.created_at', 'DESC');
        $this->CI->db->limit($limit, $offset);

        return $this->CI->db->get()->result_array();
    }

    /**
     * Get the current user ID from session.
     */
    private function _get_user_id()
    {
        return $this->CI->session->userdata('user_id') ?: 0;
    }
}
