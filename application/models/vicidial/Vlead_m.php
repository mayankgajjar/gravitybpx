<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vlead_m extends My_Model{
    protected $_table_name = 'vicidial_list';
    protected $_primary_key = 'lead_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'lead_id';
    protected $_timestamps = FALSE;

    public $rules = array(
        'agency_id' => array(
            'field' => 'agency_id',
            'label' => 'Agency',
            'rules' => 'trim|required'
        ),
        'list_id'  => array(
            'field' => 'list_id',
            'label' => 'List Name',
            'rules' => 'trim|required'
        ),
        'first_name' => array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'trim|required',
        ),
        'last_name' => array(
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'trim|required'
        )
    );

    public function __construct() {
        parent::__construct();
        $this->db = $this->vicidialdb->db;
    }

    public function get_new(){
        $lead = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $lead->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $lead;
    }
}
