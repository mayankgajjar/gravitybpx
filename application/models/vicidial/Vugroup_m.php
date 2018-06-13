<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Vugroup_m extends My_Model {

    protected $_table_name     = 'vicidial_user_groups';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = FALSE;

    public $rules = array(
        'user_group' => array(
            'field' => 'user_group',
            'label' => 'Group Id',
            'rules' => 'trim|required|min_length[2]|max_length[20]'
        ),
        'group_name' => array(
            'field' => 'group_name',
            'label' => 'Group Name',
            'rules' => 'trim|required|min_length[2]|max_length[40]'
        )
    );

    public function __construct() {
        parent::__construct();
	$this->db = $this->vicidialdb->db;
    }

    public function get_new()
    {
        $group = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $group->$colom =  $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $group;
    }
}
