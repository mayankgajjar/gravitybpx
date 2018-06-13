<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vinagent_m extends My_Model{
    protected $_table_name = 'vicidial_inbound_group_agents';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    protected $_timestamps = FALSE;

    public function __construct() {
        parent::__construct();
        $this->db = $this->vicidialdb->db;
    }

    public function get_by_array($where){
        $this->db->where($where);
        return $this->db->get($this->_table_name)->result_array();
    }
}
