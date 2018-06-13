<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leadpeople_m extends My_Model{

    protected $_table_name = 'lead_additional_peole';
    protected $_primary_key = 'people_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'people_id';
    protected $_timestamps = TRUE;   

    public function get_new(){
        $lead = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $lead->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $lead;
    }  
    
}
