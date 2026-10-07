<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_report_model extends CI_Model
{
    /**
     * Total stock value = SUM(stock_qty * avg purchase price) in XAF.
     */
    public function total_stock_value()
    {
        $result = $this->db->query("
            SELECT SUM(i.stock_qty * COALESCE(avg_price.avg_unit_price, 0)) as total_value
            FROM ingredients i
            LEFT JOIN (
                SELECT indredientid, SUM(totalprice) / SUM(quantity) as avg_unit_price
                FROM purchase_details
                GROUP BY indredientid
            ) avg_price ON avg_price.indredientid = i.id
            WHERE i.is_active = 1
        ")->row();

        return $result ? (float) $result->total_value : 0;
    }

    /**
     * Top consumed ingredients this month from stock_movements.
     */
    public function top_consumed($month = null, $year = null, $limit = 10)
    {
        $month = $month ?: date('m');
        $year  = $year ?: date('Y');

        return $this->db->query("
            SELECT i.id, i.ingredient_name, u.uom_short_code,
                   SUM(ABS(sm.quantity_change)) as total_consumed
            FROM stock_movements sm
            JOIN ingredients i ON i.id = sm.ingredient_id
            LEFT JOIN unit_of_measurement u ON u.id = i.uom_id
            WHERE sm.quantity_change < 0
              AND MONTH(sm.created_at) = ?
              AND YEAR(sm.created_at) = ?
            GROUP BY sm.ingredient_id
            ORDER BY total_consumed DESC
            LIMIT ?
        ", [$month, $year, $limit])->result();
    }

    /**
     * Dormant stock: ingredients with no movement in N days.
     */
    public function dormant_stock($days = 30)
    {
        return $this->db->query("
            SELECT i.id, i.ingredient_name, i.stock_qty, u.uom_short_code,
                   (SELECT MAX(sm.created_at) FROM stock_movements sm WHERE sm.ingredient_id = i.id) as last_movement
            FROM ingredients i
            LEFT JOIN unit_of_measurement u ON u.id = i.uom_id
            WHERE i.is_active = 1
              AND i.id NOT IN (
                  SELECT DISTINCT ingredient_id FROM stock_movements
                  WHERE created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
              )
            ORDER BY i.stock_qty DESC
        ", [$days])->result();
    }

    /**
     * Daily consumption over N days for chart.
     */
    public function daily_consumption($days = 30)
    {
        return $this->db->query("
            SELECT DATE(sm.created_at) as day,
                   SUM(ABS(sm.quantity_change)) as consumed
            FROM stock_movements sm
            WHERE sm.quantity_change < 0
              AND sm.created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)
            GROUP BY DATE(sm.created_at)
            ORDER BY day ASC
        ", [$days])->result();
    }

    /**
     * Summary counts.
     */
    public function summary()
    {
        $total = (int) $this->db->where('is_active', 1)->count_all_results('ingredients');
        $below = (int) $this->db->query("SELECT COUNT(*) as cnt FROM ingredients WHERE is_active = 1 AND stock_qty < min_stock AND min_stock > 0")->row()->cnt;

        return [
            'total_ingredients' => $total,
            'below_min'         => $below,
        ];
    }
}
