<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vdnc_m extends My_Model{
    protected $_table_name = 'vicidial_dnc';
    protected $_primary_key = 'phone_number';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'phone_number';
    protected $_timestamps = FALSE;

    public function __construct() {
        parent::__construct();
        $this->db = $this->vicidialdb->db;
    }

    public function save($data, $id = NULL) {
        if ($this->_timestamps == TRUE) {
            $now = date('Y-m-d H:i:s');
            $id || $data['created'] = $now;
            $data['modified'] = $now;
        }

        if ($id === NULL) {
            //!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
            $this->db->set($data);
            $this->db->insert($this->_table_name);
            //$id = $this->getLastInserted();
        } else {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $data['list_changedate'] = date('Y-m-d H:i:s');
            $this->db->set($data);
            $this->db->where($this->_primary_key, $id);
            $this->db->update($this->_table_name);
        }
        return $id;
    }
}
