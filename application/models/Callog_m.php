<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Callog_m extends My_Model {

    protected $_table_name = 'call_log';
    protected $_primary_key = 'unique_id';
    protected $_order_by = 'unique_id';
    protected $_timestamps = FALSE;

}
