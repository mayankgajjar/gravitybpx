<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Acampaigns_m extends My_Model{
    protected $_table_name = 'agency_campaigns';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    protected $_timestamps = TRUE;
    
}
