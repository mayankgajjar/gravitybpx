<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userlog_m extends My_Model{
    protected $_table_name = 'user_log';
    protected $_primary_key = 'log_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'log_id';
    protected $_timestamps = TRUE;
}