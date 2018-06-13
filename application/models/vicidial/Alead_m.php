<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alead_m extends My_Model{
    protected $_table_name = 'agency_lead';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    protected $_timestamps = FALSE;
}
