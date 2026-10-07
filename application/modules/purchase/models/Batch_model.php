<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Batch_model extends CI_Model
{
    /**
     * Get batches expiring within N days.
     */
    public function get_expiring($days = 7)
    {
        return $this->db->query("
            SELECT ib.*, i.ingredient_name, u.uom_short_code,
                   DATEDIFF(ib.expiry_date, CURDATE()) as days_remaining
            FROM ingredient_batches ib
            JOIN ingredients i ON i.id = ib.ingredient_id
            LEFT JOIN unit_of_measurement u ON u.id = i.uom_id
            WHERE ib.quantity_remaining > 0
              AND ib.expiry_date IS NOT NULL
              AND ib.expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ? DAY)
            ORDER BY ib.expiry_date ASC
        ", [$days])->result();
    }

    /**
     * Get already expired batches with remaining quantity.
     */
    public function get_expired()
    {
        return $this->db->query("
            SELECT ib.*, i.ingredient_name, u.uom_short_code,
                   DATEDIFF(CURDATE(), ib.expiry_date) as days_overdue
            FROM ingredient_batches ib
            JOIN ingredients i ON i.id = ib.ingredient_id
            LEFT JOIN unit_of_measurement u ON u.id = i.uom_id
            WHERE ib.quantity_remaining > 0
              AND ib.expiry_date IS NOT NULL
              AND ib.expiry_date < CURDATE()
            ORDER BY ib.expiry_date ASC
        ")->result();
    }

    /**
     * Get all batches for an ingredient.
     */
    public function get_by_ingredient($ingredient_id)
    {
        return $this->db->select('ib.*, DATEDIFF(ib.expiry_date, CURDATE()) as days_remaining')
            ->from('ingredient_batches ib')
            ->where('ib.ingredient_id', $ingredient_id)
            ->where('ib.quantity_remaining >', 0)
            ->order_by('ib.expiry_date', 'ASC')
            ->get()
            ->result();
    }
}
