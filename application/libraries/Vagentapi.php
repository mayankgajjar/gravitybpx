<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Library used for taking out function to vicidial agent screen.
 */
class Vagentapi {

    private $username;
    private $password;
    public $CI;
    private $_non_agent_uri;
    private $_agent_api_uri;

    public function __construct() {
        $this->CI = &get_instance();
        $this->_non_agent_uri = $this->CI->config->item('vicidial_nontagent_url');
        $this->_agent_api_uri = $this->CI->config->item('vicidial_agent_api_url');
    }

    private function __curl($url, $post) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);

        if ($server_output == false) {
            $data['error'] = true;
            $data['message'] = curl_error($ch);
        } else {
            $data['error'] = false;
            $data['message'] = $server_output;
        }
        curl_close($ch);
        return $data;
    }

    private function __setSessionData($post = null) {
        $this->CI->load->library('vicidialdb');
        $this->CI->load->model('vicidial/vphones_m', 'vphones_m');
        $this->CI->load->model('vicidial/vcampaigns_m', 'vcampaigns_m');
        $this->CI->load->model('vicidial/vlists_m', 'vlists_m');
        if ($post) {
            $phone = $this->CI->vphones_m->get_by(array('login' => $post['phone_login'], 'pass' => $post['phone_pass'], 'active' => 'Y'), TRUE);
            $campaign = $this->CI->vcampaigns_m->get_by(array('campaign_id' => $post['campaign']), TRUE);
            $list = $this->CI->vlists_m->get_by(array('campaign_id' => $post['campaign']), TRUE);
            $sql = "SELECT asterisk_version,web_socket_url FROM servers WHERE server_ip='".$this->CI->config->item('vici_server_ip')."';";
            $query = $this->CI->vicidialdb->db->query($sql);
            $row = $query->row_array();
            $asterisk_version = $row['asterisk_version'];
            $viciData = array(
                'vicidata' => array(
                    'session_name' => $post['session_name'],
                    'session_id' => $post['session_id'],
                    'user' => $post['user'],
                    'pass' => $post['pass'],
                    'phone_login' => $post['phone_login'],
                    'phone_pass' => $post['phone_pass'],
                    'campaign' => $post['campaign'],
                    'agent_log_id' => $post['agent_log_id'],
                    'phoneObj' => $phone,
                    'campaignObj' => $campaign,
                    'listObj' => $list,
                    'asterisk_version' => $asterisk_version
                )
            );
            $this->CI->session->set_userdata($viciData);
        }
    }

    public function setIngoups(){
        $this->CI->load->library('vicidialdb');
        if($this->CI->session->userdata('vicidata')){
            $closer_campaigns = $this->CI->session->userdata('vicidata')['campaignObj']->closer_campaigns;
            $closer_campaigns = preg_replace("/^ | -$/", "", $closer_campaigns);
            $closer_campaigns = preg_replace("/ /", "','", $closer_campaigns);
            $closer_campaigns = "'$closer_campaigns'";

          /*  if (($this->CI->session->userdata('vicidata')['campaignObj']->campaign_allow_inbound == 'Y') && ( $this->CI->session->userdata('vicidata')['campaignObj']->dial_method != 'MANUAL')) {
                 //some code for intialization
            } else {
                $closer_campaigns = "''";
            }*/
            $sql = "SELECT group_id,group_handling from vicidial_inbound_groups where active = 'Y' and group_id IN($closer_campaigns) order by group_id limit 800";
            $ingroups = $this->CI->vicidialdb->db->query($sql)->result();
            $ingroupname = ' ';
            if ($ingroups) {
                foreach($ingroups as $ingroup){
                    $ingroupname .= $ingroup->group_id.' ';
                }
                $ingroupname .= ' -';
            }
            if(isset($ingroupname)){
                $postData = array(
                    'server_ip' => $this->CI->config->item('vici_server_ip'),
                    'session_name' => $this->CI->session->userdata('vicidata')['session_name'],
                    'ACTION' => 'regCLOSER',
                    'format' => 'text',
                    'user' => $this->CI->session->userdata('vicidata')['user'],
                    'pass' => $this->CI->session->userdata('vicidata')['pass'],
                    'comments' => '',
                    'closer_blended' => 0,
                    'campaign' => $this->CI->session->userdata('vicidata')['campaign'],
                    'qm_phone' => $this->CI->session->userdata('vicidata')['phone_login'],
                    'qm_extension' => $this->CI->session->userdata('vicidata')['phoneObj']->extension,
                    'dial_method' => $this->CI->session->userdata('vicidata')['campaignObj']->dial_method ,
                    'closer_choice' => $ingroupname,
                );
                $result = $this->vdc_db_query($postData);
                //$this->__log($postData);
                //$this->__log($result);
            }
        }
    }

    private function __log($string = ''){
        $my_file = FCPATH.'application'.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'agentlog.txt';
        $handle = fopen($my_file, 'a') or die('Cannot open file:  '.$my_file);
        $var_str = var_export($string, true);
        $data = $var_str;
        fwrite($handle, $data);
        fclose($handle);
    }
    /**
     * login function used to login on vicidial agent login panel and
     * get the session id and session name
     *
     */
    public function login($post = null) {
        $this->CI->load->helper('dom');
        $return = array();
        if ($post) {
            $url = $this->CI->config->item('vicidial_agent_url') . 'vicidial.php';
            $output = $this->__curl($url, $post);
            //$this->__log($output);
            if ($output['error'] == false) {
                $html = new simple_html_dom();
                $data = $html->load($output['message']);
                // get the session value from vicidial agent scrren
                $elesesName = $data->getElementById('crmses');
                $elsesesId = $data->getElementById('crmid');
                $elelogId = $data->getElementById('crmlogid');
                if ($elsesesId && $elesesName && $elelogId) {
                    $sessionName = $elesesName->attr['value'];
                    $sessionId = $elsesesId->attr['value'];
                    $agentLogId = $elelogId->attr['value'];
                    $return['session_id'] = $sessionId;
                    $return['session_name'] = $sessionName;
                    $return['agent_log_id'] = $agentLogId;
                    $return['phone_login'] = $post['phone_login'];
                    $return['phone_pass'] = $post['phone_pass'];
                    $return['user'] = $post['VD_login'];
                    $return['pass'] = $post['VD_pass'];
                    $return['campaign'] = $post['VD_campaign'];
                    $this->__setSessionData($return);
                    return true;
                }
                return false;
            }
        } else {
            return array('error' == true, 'message' => "You don't have permission to access this.");
        }
    }

    public function vdc_db_query($post = null) {
        if ($post) {
            $url = $this->CI->config->item('vicidial_agent_url') . 'vdc_db_query.php';
            $output = $this->__curl($url, $post);
            if ($post['ACTION'] == 'userLOGout') {
               $this->CI->session->unset_userdata('vicidata');
            }
            return $output;
        } else {
            return array('error' == true, 'message' => "You don't have permission to access this.");
        }
    }
    /**
     * get the login campaign of agent
     * @param type $post
     * @return array
     */
    public function getcampaign($post = null){
        $this->CI->load->helper('dom');
        if($post){
            $data = array(
                'ACTION' => 'LogiNCamPaigns',
                'user' => $post['VD_login'],
                'pass' => $post['VD_pass'],
                'format' => 'text'
            );
            $camps = $this->vdc_db_query($data);
            $html = new simple_html_dom();
            $data = $html->load($camps['message']);
            $element = $data->getElementById('VD_campaign');
            $rCampaigns = array();
            foreach($element->children as $child){
               $rCampaigns[]= $child->attr['value'];
            }
            return $rCampaigns;
        }
    }
    /**
     * logout from vicidial dial agent sccreen a
     */
    public function logout(){
        if($this->CI->session->userdata('vicidata')){
            $postData = array(
                'server_ip' => $this->CI->config->item('vici_server_ip'),
                'session_name' => $this->CI->session->userdata('vicidata')['session_name'],
                'ACTION' => 'userLOGout',
                'format'=>  'text',
                'user' => $this->CI->session->userdata('vicidata')['user'],
                'pass' => $this->CI->session->userdata('vicidata')['pass'],
                'campaign' => $this->CI->session->userdata('vicidata')['campaign'],
                'conf_exten' => $this->CI->session->userdata('vicidata')['session_id'],
                'extension' =>  $this->CI->session->userdata('vicidata')['phoneObj']->extension,
                'protocol' => 'SIP',
                'agent_log_id' => $this->CI->session->userdata('vicidata')['agent_log_id'],
                'no_delete_sessions' => 1,
                'phone_ip' => '',
                'enable_sipsak_messages' => $this->CI->session->userdata('vicidata')['phoneObj']->enable_sipsak_messages,
                'LogouTKicKAlL' => 1,
                'ext_context' => $this->CI->session->userdata('vicidata')['phoneObj']->ext_context,
                'qm_extension' => $this->CI->session->userdata('vicidata')['phoneObj']->extension,
                'stage' =>  'NORMAL',
                'pause_trigger' => '',
                'dial_method' => $this->CI->session->userdata('vicidata')['campaignObj']->dial_method,
            );
            $result = $this->vdc_db_query($postData);
            //$this->__log($result);
        }
    }
    /**
     * call to vicidial non agent API
     * @param type $data
     * @return array
     */
    public function nonagentapi($data){
       return $this->__curl($this->_non_agent_uri, $data);
    }
    /**
     * call to vicidial agent API
     * @param type $data
     * @return array
     */
    public function agentapi($data){
        //$this->__log($data);
        return $this->__curl($this->_agent_api_uri, $data);
    }

    public function callrecord($data){
        $url = $this->CI->config->item('vicidial_agent_url').'manager_send.php';
        return $this->__curl($url, $data);
    }

    public function check_for_conf_calls($data){
        $url = $this->CI->config->item('vicidial_agent_url').'conf_exten_check.php';
        return $this->__curl($url, $data);
    }

    public function manager_send($data){
        $url = $this->CI->config->item('vicidial_agent_url').'manager_send.php';
        return $this->__curl($url, $data);
    }
}
