<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reorder_model extends CI_Model
{
    /**
     * Ingredients below minimum stock with deficit info.
     */
    public function get_below_min()
    {
        return $this->db->query("
            SELECT i.id, i.ingredient_name, i.stock_qty, i.min_stock, i.uom_id,
                   u.uom_short_code,
                   (i.min_stock - i.stock_qty) as deficit
            FROM ingredients i
            LEFT JOIN unit_of_measurement u ON u.id = i.uom_id
            WHERE i.is_active = 1 AND i.stock_qty < i.min_stock AND i.min_stock > 0
            ORDER BY deficit DESC
        ")->result();
    }

    /**
     * Average daily consumption over last N days from stock_movements.
     */
    public function get_avg_consumption($ingredient_id, $days = 30)
    {
        $result = $this->db->query("
            SELECT COALESCE(SUM(ABS(quantity_change)) / ?, 0) as avg_daily
            FROM stock_movements
            WHERE ingredient_id = ?
              AND quantity_change < 0
              AND created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
        ", [$days, $ingredient_id, $days])->row();

        return $result ? (float) $result->avg_daily : 0;
    }

    /**
     * Last supplier and price for an ingredient.
     */
    public function get_last_supplier($ingredient_id)
    {
        return $this->db->query("
            SELECT s.supid, s.supName, pd.price
            FROM purchase_details pd
            JOIN purchaseitem pi ON pd.purchaseid = pi.purID
            JOIN supplier s ON pi.suplierID = s.supid
            WHERE pd.indredientid = ?
            ORDER BY pd.purchasedate DESC
            LIMIT 1
        ", [$ingredient_id])->row();
    }
}
