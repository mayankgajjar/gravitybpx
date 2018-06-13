<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * @author : mjenisha
 */

/**
 * Wrapper to print array in readable format
 * @param array $data
 */
function pr($data) {
    echo "<pre>";
    print_r($data);
}

/**
 * Returns hashed password
 * @param string $password
 * @return string Description
 */
/* function hashPassword($password) {
  $CI = & get_instance();
  $settings = $CI->common_model->viewAll('settings', '');
  $key = "";
  foreach ($settings as $row) {
  if ($row['key'] == 'password-key') {
  $key = $row['value'];
  break;
  }
  }
  return md5(md5($password) . $key);
  } */

/**
 * Returns Slug
 * @param type $text
 * @return string
 */
function slug($text) {
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

    // trim
    $text = trim($text, '-');

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // lowercase
    $text = strtolower($text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

/**
 *  Returns Email Configurations for Mail Function
 */
function getEmailConfig() {
//    $headers = "From: User Management <info@usermgmt.cc>" . "\r\n";
//    $headers .= 'MIME-Version: 1.0' . "\r\n";
//    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $config['protocol'] = 'sendmail';
    $config['mailpath'] = '/usr/sbin/sendmail';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = TRUE;
    $config['smtp_host'] = TRUE;
    $config['smtp_user'] = TRUE;
    $config['smtp_pass'] = TRUE;
    $config['smtp_port'] = TRUE;
    $config['newline'] = "\r\n";

    return $config;
}

/**
 * Returns Pagination Configurations
 * @return boolean
 */
function init_pagination() {
    $config = array();
    $CI = & get_instance();
    $settings = $CI->session->userdata('settings');
    $per_page = "";
    foreach ($settings as $row) {
        if ($row['key'] == 'records-per-page') {
            $per_page = $row['value'];
            break;
        }
    }
    $config['per_page'] = $per_page;
    $config['uri_segment'] = 3;
    //config for bootstrap pagination class integration
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul>';
    $config['first_link'] = FALSE;
    $config['last_link'] = FALSE;
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['prev_link'] = '&laquo';
    $config['prev_tag_open'] = '<li class="prev">';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = '&raquo';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['enable_query_strings'] = TRUE;

    return $config;
}

/**
 * check Admin Login
 */
function check_isvalidated() {
    $ci = & get_instance();
    if (!$ci->session->userdata('admin_logged_in')) {
        $ci->session->set_flashdata('error', "You are not authorized to access this page. Please login first!");
        if (isset($_SERVER['HTTP_REFERER'])) {
            $redirect_to = str_replace(base_url(), '', $_SERVER['HTTP_REFERER']);
        } else {
            $redirect_to = $ci->uri->uri_string();
        }
        redirect('login?redirect=' . base64_encode($redirect_to));
    }
}

/*
 * Function to get all the user roles
 * @return array
 * @author Kirtee Unchadiya (ku)
 */

function userRoles() {
    $roles = array();
    $CI = & get_instance();
    $data = $CI->common_model->viewAll('user_groups', '');
    foreach ($data as $val)
        $roles[$val['role']] = $val['id'];
    return $roles;
}

function encode_url($string, $key = "", $url_safe = TRUE) {
    if ($key == null || $key == "") {
        $key = "agencyvue_encryptionagencyvue";
    }
    $CI = & get_instance();
    $ret = $CI->encrypt->encode($string, $key);

    if ($url_safe) {
        $ret = strtr(
                $ret, array(
            '+' => '.',
            '=' => '-',
            '/' => '~'
                )
        );
    }

    return $ret;
}

function decode_url($string, $key = "") {
    if ($key == null || $key == "") {
        $key = "agencyvue_encryptionagencyvue";
    }
    $CI = & get_instance();
    $string = strtr(
            $string, array(
        '.' => '+',
        '-' => '=',
        '~' => '/'
            )
    );

    return $CI->encrypt->decode($string, $key);
}

if (!function_exists('toMoney')) {

    function toMoney($val, $symbol = '$', $r = 2) {
        $n = $val;
        $c = is_float($n) ? 1 : number_format($n, $r);
        $d = '.';
        $t = ',';
        $sign = ($n < 0) ? '-' : '';
        $i = $n = number_format(abs($n), $r);
        $j = (($j = strlen($i)) > 3) ? $j % 2 : 0;
        return $symbol . $sign . ($j ? substr($i, 0, $j) + $t : '') . preg_replace('/(\d{3})(?=\d)/', "$1" + $t, substr($i, $j));
    }

}

if (!function_exists('get_option')) {

    function get_option($name) {
        $table_name_array = unserialize(TABLE_NAME);
        $CI = & get_instance();
        $CI->load->model('Common_model');
        $condition = "theme_options_name = '$name'";
        $option = $CI->Common_model->getRowByCondition($condition, $table_name_array['theme_options']);
        if (!$option) {
            return '';
        }
        return trim($option['theme_options_values']);
    }

}

if (!function_exists('get_admin_email')) {

    function get_admin_email($name = "email_setting") {
        $table_name_array = unserialize(TABLE_NAME);
        $CI = & get_instance();
        $CI->load->model('Common_model');
        $condition = "theme_options_name = '$name'";
        $option = $CI->Common_model->getRowByCondition($condition, $table_name_array['theme_options']);
        if (!$option) {
            return '';
        }
        $email_setting_config = unserialize($option['theme_options_values']);
        return trim($email_setting_config['admin_email']);
    }

}

function hashPassword($string) {
    return hash('md5', $string . config_item('encryption_key'));
}

function buildTree(Array $data, $parent = 0) {
    $tree = array();
    foreach ($data as $d) {
        if ($d['parent_agency'] == $parent) {
            $children = buildTree($data, $d['id']);
            // set a trivial key
            if (!empty($children)) {
                $d['_children'] = $children;
            }
            $tree[] = $d;
        }
    }
    return $tree;
}

function printTree($tree, $r = 0, $p = null, $check = NULL) {

    foreach ($tree as $i => $t) {

        $dash = ($t['parent_agency'] == 0) ? '' : str_repeat('-', $r) . ' ';
        if ($check == $t['id']) {
            $selected = 'selected="selected"';
        } else {
            $selected = '';
        }
        printf("\t<option value='%d' %s>%s%s</option>\n", $t['id'], $selected, $dash, $t['name']);
        if ($t['parent_agency'] == $p) {
            // reset $r
            $r = 0;
        }
        if (isset($t['_children'])) {
            printTree($t['_children'], ++$r, $t['_children'][0]['parent_agency'], $check);
        } else {
            $r = 0;
        }
    }
}

function printTreeWithEncrypt($tree, $r = 0, $p = null, $check = NULL) {

    foreach ($tree as $i => $t) {
        $dash = ($t['parent_agency'] == 0) ? '' : str_repeat('-', $r) . ' ';
        if ($check == $t['id']) {
            $selected = 'selected="selected"';
        } else {
            $selected = '';
        }
        printf("\t<option value='%s' %s>%s%s</option>\n", encode_url($t['id']), $selected, $dash, $t['name']);
        if ($t['parent_agency'] == $p) {
            // reset $r
            $r = 0;
        }
        if (isset($t['_children'])) {
            printTreeWithEncrypt($t['_children'], ++$r, $t['parent_agency'], $check);
        } else {
            $r = 0;
        }
    }
}

// FORMAT PHONE NUMBERS
function formatPhoneNumber($variableName) {
    // Keep numbers only

    $result = preg_replace("/[^0-9]/", "", $variableName);
    // Remove "1" if it's the first character
    $result = preg_replace("/^1/", "", $variableName);
    // format for 7 digit numbers
    if (strlen($result) == 7)
        $result = preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $variableName);
    // format for 10 digit numbers
    if (strlen($result) == 10) // 10 digit numbers
        $result = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1-$2-$3", $variableName);

    return $result;
}

/*
 *  function to get lead member last increment id from lead_member_auto table
 */
if (!function_exists('getIncrementMemberId')) {

    function getIncrementMemberId() {
        $CI = &get_instance();
        $stmt = "SELECT * FROM lead_member_auto WHERE entity_type = 'lead'";
        $query = $CI->db->query($stmt);
        $row = $query->row_array();
        return $row['increment_last_id'];
    }

}
/*
 *  function to update lead member last increment id from lead_member_auto table
 */
if (!function_exists('updateIncrementMemberId')) {

    function updateIncrementMemberId() {
        $CI = &get_instance();
        $id = getIncrementMemberId();
        $id = $id + 1;
        $stmt = "UPDATE lead_member_auto SET increment_last_id = '{$id}' WHERE entity_type = 'lead'";
        $query = $CI->db->query($stmt);
        if ($query) {
            return true;
        }
    }

}
if (!function_exists('getAgeFromDateOfBirth')) {

    function getAgeFromDateOfBirth($date) {
        $from = new DateTime(date('Y-m-d', strtotime($date)));
        $to = new DateTime('today');
        return $from->diff($to)->y;
    }

}
if (!function_exists('formatMoney')) {

    function formatMoney($number, $cents = 1, $symbol = FALSE) {
        if (is_numeric($number)) {
            if (!$number) {
                $money = ($cents == 2 ? '0.00' : '0');
            } else {
                if (floor($number) == $number) {
                    $money = number_format($number, ($cents == 2 ? 2 : 0));
                } else {
                    $money = number_format(round($number, 2), ($cents == 0 ? 0 : 2));
                }
            }
            if ($symbol == TRUE) {
                return '$' . $money;
            }
            return $money;
        }
    }

}

/**
 * @uses Get Stripe Setting
 * @return Array Stripe Setting Details
 */
if (!function_exists('get_stripe_setting')) {

    function get_stripe_setting() {
        $CI = &get_instance();
        $query = "select theme_options_values from {$CI->db->protect_identifiers('theme_options', TRUE)} WHERE theme_options_name='stripe_setting'";
        $seArray = $CI->db->query($query)->row_array();
        $stripe = unserialize($seArray['theme_options_values']);
        return $stripe;
    }

}

/**
 * @uses Stripe Payment Method For Any Payable amount
 * @param $payable Payable Amount IN USD CENT
 * @param $number Card Number
 * @param $cvc Card CVC
 * @param $exp_month Card Expiration Month
 * @param $exp_year Expiration Year
 * @param $name Card Name Ex. VISA
 * @param $paymentNote Insert some payment note along with || optional
 * @return JSON Payment Gateway Response
 */
if (!function_exists('payable_stripe')) {

    function payable_stripe($payable = null, $number, $cvc, $exp_month, $exp_year, $name, $paymentNote = "") {
        if ($payable == null) {
            exit('Agency FEE NULL || Error');
        }
        $CI = & get_instance();
        $stripeNote = "";
        $stripeSetting = unserialize(get_option('stripe_setting'));
        if ($stripeSetting['stripe_mode'] == "test") {
            $config['stripe_key_test_public'] = $stripeSetting['stripe_key_test_public'];
            $config['stripe_key_test_secret'] = $stripeSetting['stripe_key_test_secret'];
            $config['stripe_test_mode'] = TRUE;
            $config['stripe_verify_ssl'] = FALSE;
        } else {
            exit('LIVE');
            $config['stripe_key_live_public'] = $stripeSetting['stripe_key_live_public'];
            $config['stripe_key_live_secret'] = $stripeSetting['stripe_key_live_secret'];
            $config['stripe_test_mode'] = FALSE;
            $config['stripe_verify_ssl'] = FALSE;
        }
        $CI->load->library('stripe', $config);
        $card_data = array(
            'number' => $number,
            'cvc' => $cvc,
            'exp_month' => $exp_month,
            'exp_year' => $exp_year,
            'name' => $name,
        );
        $tokenData = $CI->stripe->card_token_create($card_data, $payable);
        $tokenData = json_decode($tokenData);
        if (isset($tokenData->id)) {
            $token = $tokenData->id;
            if ($paymentNote != "") {
                $stripeNote = $paymentNote;
            } else {
                $stripeNote = "Test Payment";
            }
            $statusJson = $CI->stripe->main_charge_card($payable, $token, $stripeNote);
            return $statusJson;
        } else {
            return $tokenData;
        }
    }

}
if (!function_exists('getAgentFromAgncyId')) {

    function getAgentFromAgncyId() {
        $CI = &get_instance();
        $query = "select id from {$CI->db->protect_identifiers('agents', TRUE)} WHERE agency_id={$CI->session->userdata('agency')->id}";
        $results = $CI->db->query($query)->result_array();
        $ids[] = $CI->session->userdata('agency')->id;
        foreach ($results as $result) {
            $ids[] = $result['id'];
        }
        return implode(',', $ids);
    }

}
if (!function_exists('getAgentUserIDFromAgncyId')) {

    function getAgentUserIDFromAgncyId() {
        $CI = &get_instance();
        $query = "select user_id from {$CI->db->protect_identifiers('agents', TRUE)} WHERE agency_id={$CI->session->userdata('agency')->id}";
        $results = $CI->db->query($query)->result_array();
        $ids[] = $CI->session->userdata('agency')->id;
        foreach ($results as $result) {
            $ids[] = $result['user_id'];
        }
        return implode(',', $ids);
    }

}

if(!function_exists('formatDate')){
    function formatDate($data,$time=true){
        $date = strtotime($data);
        if($time){
            return date('m/d/Y H:i A',$date);
        }
        return date('m/d/Y',$date);
    }
}

if(!function_exists('convertphoneformat')){
    function convertphoneformat($data){
        $phone = '';
        if($data){
            $phone=preg_replace('/[^0-9\']/', '', $data);
        }
        return $phone;
    }
}
if (!function_exists('sessionTimer')) {

    function sessionTimer() {
        $CI = &get_instance();
        $IdleTime = time() - $CI->session->userdata("user")->login_time;
        if ($IdleTime >= 1800) { //subtract new timestamp from the old one
            echo $IdleTime . 'IN';
            $CI->load->model('LiveAgent_m', 'liveAgent');
            $CI->liveAgent->delete($CI->session->userdata('liveagent')->liveagent);
            $CI->session->sess_destroy();
            $CI->session->set_flashdata('msg', 'Your Session Time Out');
            redirect($CI->config->item('http') . $CI->config->item('main_url') . 'login');
        } else {
            $curtime = time();
            $_SESSION['user']->login_time = $curtime;
        }
    }

}

if (!function_exists('check_user_login')) {

    function check_user_login() {
        $CI = &get_instance();
        $CI->load->model('User_model');
        $user_id = $CI->session->userdata("user")->id;
        $user_token = $CI->session->userdata("user")->user_token;
        $CI->db->where(array("u.id" => $user_id, "u.user_token" => $user_token));
        $result = $CI->db->get('users u');
        $data = $result->row();
        if(!$data){
            redirect($CI->config->item('http') . $CI->config->item('main_url') . 'others/logout');
        }

    }
}

if(!function_exists('getPlivoAuth')){
    function getPlivoAuth(){
        $CI = &get_instance();
        $CI->load->model('Common_model');
        $sql = "SELECT * FROM theme_options WHERE theme_options_name = 'plivo_setting'";
        $query = $CI->db->query($sql);
        $row = $query->row_array();
        $plivoSetting = unserialize($row['theme_options_values']);
        return $plivoSetting;
    }
}

 /* Function For User Log:
    Name    : user_log
    Param 1 : From_id
    Param 2 : To_id
    Param 3 : Feed Type  (0 : Activity , 1 : System)
    Param 4 : Log Type (call,sms,lead etc.)
    Param 5 : Title
    Param 6 : Redirect URL (Optional)
*/

if(!function_exists('user_log')){
    function user_log($from_id,$to_id,$feed_type,$log_type,$title,$log_url=''){
        $CI = &get_instance();
        $CI->load->model('userlog_m');
        $data=array(
            'from_id'  => $from_id,
            'to_id'    => $to_id,
            'feed_type'=> $feed_type,
            'log_type' => $log_type,
            'title'    => $title,
            'log_url'  => $log_url,
            );
        $res=$CI->userlog_m->save($data);
        return $res;
    }
}


/*  For time Ago
*   Param 1 : DateTime
*/
if(!function_exists('time_ago')){
    function time_ago($date) {

        if(empty($date)) {
            return "No date provided";
        }

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");
        $now = time();
        $unix_date = strtotime($date);

        // check validity of date

        if(empty($unix_date)) {
            return "";
        }

        // is it future date or past date
        if($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";
        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }
        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }
        $difference = round($difference);
        if($difference != 1) {
            $periods[$j].= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }
}

if(!function_exists('feed_status')){
    function feed_status($type) {
        $status = '';
        if($type == 'inbound'){
            $status = '<i class="icon-call-in"></i>';
        }elseif($type == 'outbound'){
            $status = '<i class="icon-call-out"></i>';
        }elseif($type == 'voice_mail'){
            $status = '<i class="fa fa-bullhorn"></i>';
        }elseif($type == 'send_sms'){
            $status = '<i class="fa fa-envelope-o"></i>';
        }elseif($type == 'receive_sms'){
            $status = '<i class="icon-envelope-letter"></i>';
        }elseif($type == 'profile'){
            $status = '<i class="fa fa-user"></i>';
        }elseif($type == 'file_upload'){
            $status = '<i class="fa fa-upload"></i>';
        }elseif($type == 'task'){
            $status = '<i class="fa fa-tasks"></i>';
        }elseif($type == 'calendar'){
            $status = '<i class="fa fa-calendar"></i>';
        }elseif($type == 'commission'){
            $status = '<i class="fa fa-money"></i>';
        }else{
            $status = '<i class="fa fa-bell-o"></i>';
        }
        return $status;
    }
}