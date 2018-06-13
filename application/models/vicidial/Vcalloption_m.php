<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vcalloption_m extends My_Model{
    protected $_table_name = 'vicidial_call_menu_options';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'int';
    protected $_order_by = 'id';
    protected $_timestamps = FALSE;

    public function __construct() {
        parent::__construct();
        $this->db = $this->vicidialdb->db;
    }
}
