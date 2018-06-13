<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emailtemplate_m extends My_Model{

    protected $_table_name = 'email_templates';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    protected $_timestamps = TRUE;
    public $rules = array(  
        'name' => array(
                'field' => 'name',
                'label' => 'Email Name',
                'rules' => 'trim|required'
        ),
        'subject' => array(
                'field' => 'subject',
                'label' => 'Email Subject',
                'rules' => 'trim|required'
        ),
        'event' => array(
                'field' => 'event',
                'label' => 'Email Event',
                'rules' => 'trim|required'
        ),      
        'body' => array(
                'field' => 'body',
                'label' => 'Email Body',
                'rules' => 'trim|required'
        ),      
    );
    
    public function get_new(){
        $lead = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $lead->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $lead;
    }
    
}
