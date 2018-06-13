<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Templeadconvert_m extends My_Model {

    protected $_table_name = 'temp_lead_convert';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
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
