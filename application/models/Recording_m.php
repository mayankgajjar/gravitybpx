<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Recording_m extends My_Model{
    protected $_table_name = 'recording_log';
    protected $_primary_key = 'recording_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'recording_id';
    protected $_timestamps = FALSE;
}
