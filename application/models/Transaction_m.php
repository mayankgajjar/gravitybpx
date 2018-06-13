<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_m extends My_Model {

    protected $_table_name = 'agent_billing_transactions';
    protected $_primary_key = 'tran_id';
    protected $_order_by = 'tran_id';
    protected $_timestamps = FALSE;        
}
