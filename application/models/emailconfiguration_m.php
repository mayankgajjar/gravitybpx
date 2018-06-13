<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class emailconfiguration_m extends My_Model{
    protected $_table_name = 'email_configuration';
    protected $_primary_key = 'configuration_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'configuration_id';
    protected $_timestamps = TRUE;
    
    public $rules = array(
        'username' => array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'trim|required'
        ),
        'password' => array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        ),
        'port' => array(
                'field' => 'port',
                'label'	=> 'Port',
                'rules' => 'trim|required'
        ),
        'host' => array(
                'field' => 'host',
                'label'	=> 'Host',
                'rules' => 'trim|required'
        ),
    );

    public function get_new(){
        $task = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $bid->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $task;
    }

}
