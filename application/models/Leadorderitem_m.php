<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Leadorderitem_m extends My_Model {

    protected $_table_name = 'lead_order_item';
    protected $_primary_key = 'order_item_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'order_item_id';
    protected $_timestamps = TRUE;
    public function get_new() {
        $lead = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $lead->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $lead;
    }

}
