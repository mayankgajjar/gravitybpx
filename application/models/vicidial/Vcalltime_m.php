<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vcalltime_m extends My_Model {

    protected $_table_name     = 'vicidial_call_times';
    protected $_primary_key    = 'call_time_id';
    protected $_primary_filter = 'string';
    protected $_order_by       = 'call_time_id';
    protected $_timestamps     = FALSE;

    public function __construct() {
        parent::__construct();
	$this->db = $this->vicidialdb->db;
    }
}
