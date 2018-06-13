<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vcategories_m extends My_Model {
    protected $_table_name     = 'vicidial_status_categories';
    protected $_primary_key    = 'vsc_id';
    protected $_primary_filter = 'string';
    protected $_order_by       = 'vsc_id';
    protected $_timestamps     = FALSE;

    public function __construct() {
        parent::__construct();
        $CI = &get_instance();
        $CI->load->library('vicidialdb');
	$this->db = $CI->vicidialdb->db;
    }
}
