<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vstatuses extends My_Model{
    protected $_table_name     = 'vicidial_statuses';
    protected $_primary_key    = 'status';
    protected $_primary_filter = 'strval';
    protected $_order_by       = 'status';
    protected $_timestamps     = FALSE;

    public $rules = array(
        'status' => array(
            'field' => 'status',
            'label' => 'Status',
            'rules' => 'trim|required|callback__unique_status_id'
        ),
        'status_name' => array(
            'field' => 'status_name',
            'label' => 'Description',
            'rules' => 'trim|required'
        )
    );

    public function __construct() {
        parent::__construct();
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
	    $this->db = $CI->vicidialdb->db;
    }

    public function get_new(){
        $status = new stdClass();
        $status->status = $this->input->post('status') ? $this->input->post('status') : '';
        $status->status_name = $this->input->post('status_name') ? $this->input->post('status_name') : '';
        $status->selectable = $this->input->post('selectable') ? $this->input->post('selectable') : 'N';
        $status->human_answered = $this->input->post('human_answered') ? $this->input->post('human_answered') : 'N';
        $status->category = $this->input->post('category') ? $this->input->post('category') : 'UNDEFINED';
        $status->sale = $this->input->post('sale') ? $this->input->post('sale') : 'N';
        $status->dnc = $this->input->post('dnc') ? $this->input->post('dnc') : 'N';
        $status->customer_contact = $this->input->post('customer_contact') ? $this->input->post('customer_contact') : 'N';
        $status->not_interested = $this->input->post('not_interested') ? $this->input->post('not_interested') : 'N';
        $status->unworkable = $this->input->post('unworkable') ? $this->input->post('unworkable') : 'N';
        $status->scheduled_callback = $this->input->post('scheduled_callback') ? $this->input->post('scheduled_callback') : 'N';
        $status->completed = $this->input->post('completed') ? $this->input->post('completed') : 'N';
        $status->min_sec = $this->input->post('min_sec') ? $this->input->post('min_sec') : '0';
        $status->max_sec = $this->input->post('max_sec') ? $this->input->post('max_sec') : '0';
        $status->answering_machine = $this->input->post('answering_machine') ? $this->input->post('answering_machine') : 'N';
        $status->transfer_crm = $this->input->post('transfer_crm') ? $this->input->post('transfer_crm') : 'N';
        return $status;
    }

    public function getLastInserted() {
        $query = $this->db->query("SELECT * FROM {$this->_table_name} order by created DESC limit 1");
        $row = $query->row_array();
        return $row[$this->_primary_key];
    }

    public function save($data, $id = NULL){
        if($this->_timestamps == TRUE){
            $now = date('Y-m-d H:i:s');
            $id || $data['created'] = $now;
            $data['modified'] = $now;
        }

        if( $id === NULL ){
            $this->db->set($data);
            $this->db->insert($this->_table_name);
            $id = $this->getLastInserted();
        }else{
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->set($data);
            $this->db->where($this->_primary_key, $id);
            $this->db->update($this->_table_name);
        }
        return $id;
    }

    public function query($where='',$order='',$limit=''){
        $sql = "SELECT * FROM {$this->db->protect_identifiers($this->_table_name, TRUE)} ";

        if( $where != '' ){
            $sql.= "{$where}";
        }

        if( $order != '' )
            $sql.= "{$order}";
        else
            $sql.= " ORDER BY created DESC";

        if( $limit != '' )
            $sql.= "{$limit} ";

        $query = $this->db->query($sql);

        if( $query->num_rows() > 0 )
            return $query->result_array();
        else
            return false;
    }
}
