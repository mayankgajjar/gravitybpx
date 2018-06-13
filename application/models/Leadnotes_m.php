<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leadnotes_m extends My_Model{
    protected $_table_name = 'lead_notes';
    protected $_primary_key = 'lead_note_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'lead_note_id';
    protected $_timestamps = TRUE;   

    public function get_new(){
        $leadProduct = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $leadNote->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $leadNote;
    } 
}
