<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require 'Plivo/vendor/autoload.php';

use Plivo\RestAPI;

class Plivo extends RestAPI{
    
    public function __construct($params = array()){
        $auth_id = $params['auth_id'];
        $auth_token  = $params['auth_token'];
        parent::__construct($auth_id, $auth_token, $url = "https://api.plivo.com", $version = "v1");
    }

}
