<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rawlead_m extends My_Model {

    protected $_table_name = 'raw_lead_mst';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    protected $_timestamps = TRUE;
    public $rules = array(
        'first_name' => array(
            'field' => 'first_name',
            'label' => 'First Name',
            'rules' => 'trim|required'
        ),
        'last_name' => array(
            'field' => 'last_name',
            'label' => 'Last Name',
            'rules' => 'trim|required'
        ),
        'phone' => array(
            'field' => 'phone',
            'label' => 'Phone Number',
            'rules' => 'trim|numeric|required',
        ),
        'email' => array(
            'field' => 'email',
            'label' => 'Email ID',
            'rules' => 'trim|valid_email'
        ),
        'state' => array(
            'field' => 'state',
            'label' => 'State',
            'rules' => 'trim'
        ),
        'city' => array(
            'field' => 'city',
            'label' => 'City',
            'rules' => 'trim'
        ),
        'zip' => array(
            'field' => 'zip',
            'label' => 'Zip Code',
            'rules' => 'trim'
        ),
    );

    public function get_new() {
        $lead = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $lead->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $lead;
    }

    public function bulk_upload($data){
        return $this->db->insert_batch('raw_lead_mst',$data);

    }

}
