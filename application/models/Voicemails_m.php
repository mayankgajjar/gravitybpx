<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voicemails_m extends My_Model{
    protected $_table_name = 'voicemails';
    protected $_primary_key = 'voicemail_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'voicemail_id';
    protected $_timestamps = TRUE;   

}
