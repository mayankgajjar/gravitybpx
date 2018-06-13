<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leademail_m extends My_Model{
    protected $_table_name = 'lead_email_logs';
    protected $_primary_key = 'email_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'email_id';
    protected $_timestamps = TRUE;
}
