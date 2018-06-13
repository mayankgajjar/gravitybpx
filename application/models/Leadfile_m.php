<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leadfile_m extends My_Model{

    protected $_table_name = 'lead_files';
    protected $_primary_key = 'file_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'file_id';
    protected $_timestamps = TRUE;   
    
}
