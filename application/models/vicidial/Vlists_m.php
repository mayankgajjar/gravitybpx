<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vlists_m extends My_Model {

    protected $_table_name = 'vicidial_lists';
    protected $_primary_key = 'list_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'list_id';
    protected $_timestamps = FALSE;

    public $rules = array(
        'list_id' => array(
            'field' => 'list_id',
            'label' => 'List ID',
            'rules' => 'trim|required|numeric|callback__unique_list_id'
        ),
        'list_name' => array(
            'field' => 'list_name',
            'label' => 'List Name',
            'rules' => 'trim|required'
        )
    );

    public $default = array(
        'reset_time' => '', 'agent_script_override' => '', 'campaign_cid_override' => '', 'am_message_exten_override' => '', 'drop_inbound_group_override' => '', 'xferconf_a_number' => '',
        'xferconf_b_number' => '', 'xferconf_c_number' => '', 'xferconf_d_number' => '', 'xferconf_e_number' => '', 'web_form_address' => '', 'web_form_address_two' => '', 'inventory_report' => 'Y',
        'expiration_date' => '2099-12-31', 'na_call_url' => '', 'local_call_time' => 'campaign', 'web_form_address_three' => '', 'status_group_id' => ''
    );
    public function __construct() {
        parent::__construct();
        $this->db = $this->vicidialdb->db;
    }

    public function get_new(){
        $lists = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $lists->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $lists;
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
            $id = $this->getLastInserted();
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

    public function getLastInserted() {
	//$this->db->select_max($this->_primary_key);
	//$Q = $this->db->get($this->_table_name);
        $query = $this->db->query("SELECT * FROM {$this->_table_name} order by created DESC limit 1");
	//$query = $Q->result_array();
        $row = $query->row_array();

	return $row[$this->_primary_key];
    }

    public function queryForAgency($where = '', $order = '', $limit = '') {
        $lists = getAgencyLists();
        $sql = "SELECT * FROM {$this->db->protect_identifiers($this->_table_name, TRUE)} ";

        if ($where != '') {
            $sql.= "{$where} AND list_id IN ({$lists})";
        }else{
            $sql.= "WHERE list_id IN ({$lists})";
        }

        if ($order != '')
            $sql.= "{$order}";
        else
            $sql.= " ORDER BY {$this->_primary_key} DESC";

        if ($limit != '')
            $sql.= "{$limit} ";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }

}
