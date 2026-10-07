<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Batch Library — FIFO batch tracking for ingredient expiry management.
 */
class Batch_lib
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * Add a new batch when purchasing ingredients.
     */
    public function add_batch($ingredient_id, $quantity, $expiry_date, $purchase_detail_id = null, $unit_cost = null, $batch_number = null)
    {
        if (!$this->CI->db->table_exists('ingredient_batches')) {
            return false;
        }

        $data = [
            'ingredient_id'      => $ingredient_id,
            'batch_number'       => $batch_number,
            'quantity_remaining' => $quantity,
            'expiry_date'        => $expiry_date ?: null,
            'purchase_detail_id' => $purchase_detail_id,
            'unit_cost'          => $unit_cost,
            'created_at'         => date('Y-m-d H:i:s'),
        ];

        $this->CI->db->insert('ingredient_batches', $data);
        return $this->CI->db->insert_id();
    }

    /**
     * FIFO deduction: deduct from oldest batches first (by expiry_date).
     *
     * @param int   $ingredient_id
     * @param float $qty  Positive number to deduct
     * @return float  Remaining qty that couldn't be deducted (0 if all deducted)
     */
    public function deduct_fifo($ingredient_id, $qty)
    {
        if (!$this->CI->db->table_exists('ingredient_batches')) {
            return 0;
        }

        $qty = abs($qty);

        // Get batches ordered by expiry date (oldest/soonest first), then by created_at
        $batches = $this->CI->db->select('id, quantity_remaining')
            ->where('ingredient_id', $ingredient_id)
            ->where('quantity_remaining >', 0)
            ->order_by('COALESCE(expiry_date, "9999-12-31")', 'ASC')
            ->order_by('created_at', 'ASC')
            ->get('ingredient_batches')
            ->result();

        $remaining = $qty;

        foreach ($batches as $batch) {
            if ($remaining <= 0) break;

            $deduct = min($remaining, (float) $batch->quantity_remaining);
            $new_qty = (float) $batch->quantity_remaining - $deduct;

            $this->CI->db->where('id', $batch->id)
                ->update('ingredient_batches', ['quantity_remaining' => $new_qty]);

            $remaining -= $deduct;
        }

        return $remaining;
    }
}
