<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vicidialdb
{
    var $db = NULL;

    function __construct() {
        $CI = &get_instance();
        $this->db = $CI->load->database('vicidial',TRUE);
    }

}