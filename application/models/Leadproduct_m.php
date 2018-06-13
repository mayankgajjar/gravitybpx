<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leadproduct_m extends My_Model{
    protected $_table_name = 'lead_products';
    protected $_primary_key = 'lead_product_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'lead_product_id';
    protected $_timestamps = TRUE;   

    public function get_new(){
        $leadProduct = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $leadProduct->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $leadProduct;
    } 
}
