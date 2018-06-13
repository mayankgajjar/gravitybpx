<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rawleadfilter_m extends My_Model {

    protected $_table_name = 'lead_saved_filter';
    protected $_primary_key = 'filter_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'filter_id';
    protected $_timestamps = TRUE;
}
