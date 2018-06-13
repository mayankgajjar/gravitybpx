<?php
/**
 * Description of Category_model
 *
 * @author Meet
 */
class Category_model extends CI_Model
{    
    /**
     * Common View (List) function
     */
    public function viewAllCategoryObject($table, $limit) {
        $query = "SELECT category_name as text,id FROM " . $table . " ORDER BY id ASC " . $limit;
        $list = $this->db->query($query);
        return $list->result();
    }
}