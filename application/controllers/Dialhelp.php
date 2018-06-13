<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dialhelp extends CI_Controller{

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agent' && $this->session->userdata("user")->group_name != 'Admin' && $this->session->userdata("user")->group_name != 'Agency') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('leadstore_m');
        $this->load->model('Common_model');
        $table_name_array = unserialize(TABLE_NAME);
        $codition = "theme_options_name = 'plivo_setting'";
        $settings = $this->Common_model->getRowByCondition($codition, $table_name_array['theme_options']);
        $plivo = unserialize($settings['theme_options_values']);
        $this->load->library('plivo', array('auth_id' => $plivo['plivo_auth_id'], 'auth_token' => $plivo['plivo_auth_token']));
    }

    public function searchLead(){
        $post = $this->input->post();
        $output = array();
        if($post && $post['is_ajax'] == true){
            $pnoneNum = $post['phone'];
            $options = array(
                'LIMIT' => array('start' => 0, 'end' => 1),
                'conditions' => "replace(phone,'-','') = '{$pnoneNum}' AND user = {$this->session->userdata('agent')->id}"
            );
            $lead  = $this->leadstore_m->get_relation('', $options);
            if($lead){
                $output['success'] = true;
                $output['lead'] = $lead[0];
            }else{
                $data['agency_id'] = $this->session->userdata('agent')->agency_id;
                $data['user'] = $this->session->userdata('agent')->id;
                $data['owner'] = $this->session->userdata('user')->email_id;
                $data['member_id'] = getIncrementMemberId();
                $data['dispo'] = 'NEW';
                $data['phone'] = $post['phone'];
                $leadId = $this->leadstore_m->save($data, NULL);
                updateIncrementMemberId();
                $options = array(
                    'LIMIT' => array('start' => 0, 'end' => 1),
                    'conditions' => "lead_id = {$leadId}"
                );
                $lead  = $this->leadstore_m->get_relation('', $options);
                $output['success'] = true;
                $output['lead'] = $lead[0];
            }
        }else{
            $output['success'] = false;
            $output['lead'] = NULL;
        }
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
    }

    public function saveLead(){
        $post = $this->input->post();
        $output = array();
        if($post && $post['is_ajax'] == true){
            if(isset($post['name']) && (strlen(trim($post['name'])) > 0 )){
                $name = explode(' ', $post['name']);
                $data['first_name'] = $name[0];
                $data['last_name'] = $name[1];
            }
            $data['email'] = $post['email'];
            $data['city'] = $post['city'];
            $data['state'] = $post['state'];
            $data['postal_code'] = $post['zip'];
            $data['called_count'] = $post['called_count'] + 1;
            $data['notes'] = $post['notes'];
            $data['last_local_call_time'] = date('Y-m-d H:i:s');
            $this->leadstore_m->save($data, $post['lead_id']);
            $output['success'] = TRUE;
        }
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
    }

    public function getLivecall(){
        $post = $this->input->post();
        $output = array();
        if($post && $post['is_ajax'] == true){
            unset($post['is_ajax']);
            $this->load->model('LiveAgent_m', 'liveagent_m');
            $this->load->model('callog_m');
            //$this->session->userdata('liveagent')->liveagent
            $option = array(
                'LIMIT' => array('start' => 0 , 'end' => 1),
                'conditions' => "live_agent_id = {$this->session->userdata('liveagent')->liveagent}"
            );
            $result = $this->liveagent_m->get_relation('', $option);
            $liveAgent = $result[0];
            $output['success'] = false;
            $output['result'] = NULL;
            if($liveAgent['status'] == 'INCALL'){
                $uniqueid = $liveAgent['uniqueid'];
                $option = array(
                    'LIMIT' => array('start' => 0 , 'end' => 1),
                    'conditions' => "unique_id = {$uniqueid}"
                );
                $result = $this->callog_m->get_relation('', $option);
                $log = $result[0];
                $output['success'] = true;
                $output['result'] = array('CallUUID' => $log['CallUUID']);
            }
        }else{
            $output['success'] = false;
            $output['result'] = NULL;
        }
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
    }

    public function updateDispo(){
        $post = $this->input->post();
        if($post && $post['is_ajax']){
            if($post['dispo'] == 'CALLBACK' || $post['dispo'] == 'QUOTED' ){
                $status = 'Opportunity';
            }elseif($post['dispo'] == 'SALE MADE'){
                $status = 'Client';
            }else{
                $status = 'Lead';
            }
            $data = array('dispo' => $post['dispo'], 'status' => $status);
            $data['last_local_call_time'] = date('Y-m-d H:i:s');
            $this->leadstore_m->save($data, $post['lead_id']);
            $output['success'] = TRUE;
        }else{
            $output['success'] = false;
        }
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
    }

    public function record(){
        $post = $this->input->post();
        $output =  array();
        if($post && $post['is_ajax'] == true){
            $this->load->model('recording_m');
            $params = getPlivoAuth();
            $AUTH_ID = $params['plivo_auth_id'];
            $AUTH_TOKEN = $params['plivo_auth_token'];
            if($post['action'] == 'start'){
                $url = 'https://api.plivo.com/v1/Account/' . $AUTH_ID . '/Call/'.$post['call_uuid'].'/Record/';
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
                curl_setopt($ch, CURLOPT_USERPWD, $AUTH_ID . ":" . $AUTH_TOKEN);
                $response = curl_exec($ch);
                curl_close($ch);
                $result = json_decode($response);
                $result->recId = $this->recording_m->save(array('callUUid' => $post['call_uuid'], 'plivo_recording_id' => $result->recording_id, 'recording_url' => $result->url), NULL);
                $output['success'] = true;
                $output['data'] = $result;
            }
            if($post['action'] == 'stop'){
                $url = 'https://api.plivo.com/v1/Account/' . $AUTH_ID . '/Call/'.$post['call_uuid'].'/Record/';
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
                curl_setopt($ch, CURLOPT_USERPWD, $AUTH_ID . ":" . $AUTH_TOKEN);
                $response = curl_exec($ch);
                curl_close($ch);
                $result = json_decode($response);
                //$result['recId'] = $this->recording_m->save(array('callUUid' => $post['call_uuid'], 'plivo_recording_id' => $result['recording_id'], 'recording_url' => $result['url']), NULL);
                $output['success'] = true;
                $output['data'] = $result;
            }
        }else{
            $output['success'] = false;
        }
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
    }

    public function updateLog(){
        $post = $this->input->post();
        $output =  array();
        if($post && $post['is_ajax'] == true){
            $this->load->model('callog_m');
            $callUUID = $post['call_uuid'];
            $option = array(
                'LIMIT' => array('start' => 0 , 'end' => 0),
                'conditions' => "CallUUID = '{$callUUID}'"
            );
            $results = $this->callog_m->get_relation('',$option);
            $log = $results[0];
            $data['lead_id'] = $post['lead_id'];
            $this->callog_m->save($data, $log['unique_id']);
            $output['success'] = true;
        }else{
            $output['success'] = false;
        }
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
    }

    public function transfer(){
        $post = $this->input->post();
        $output = array();
        if($post && $post['is_ajax'] == true){
            unset($post['is_ajax']);
            $params = array(
                //'legs' => 'both',
                'call_uuid' => $post['call_uuid'],
                'aleg_url' => site_url('callback/transfer/'.$post['transfer']),
                'aleg_method' => 'GET',
                //'bleg_url' => site_url('callback/transfer1/'.$post['transfer']),
                //'bleg_method' => 'GET',
            );
            try{
                $output['data'] = $this->plivo->transfer_call($params);
            } catch (Exception $ex) {
                $output['data'] = $ex->getMessage();
            }

            $output['success'] = true;
        }else{
             $output['success'] = false;
        }
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
    }

    public function blindTransfer(){
        $post = $this->input->post();
        $output = array();
        if($post && $post['is_ajax']){
            unset($post['is_ajax']);
            $fromNumber = $post['from'];
            $fNum = $post['fNum'];
            $sNum = $post['sNum'];
            $CallUUID = $post['call_uuid'];
            $p = $this->plivo;
            $plivo_number = $fromNumber;
            $conference = time();
            $params = array(
                'to' => "$fNum<$sNum", # The phon number to be called
                'from' => $plivo_number, # The phone number to be used as the caller id
                'answer_url' => site_url('callback/conference_xml/'.$CallUUID.'/'.$conference), # The URL invoked by Plivo when the outbound call is answered
                'answer_method' => "GET" # The method used to call the answer_url
            );
            $response = $p->make_call($params);
            if($response['status'] == 201){
                $output['success'] = true;
                $output['msg'] = 'Transfer successfully intiated.';
            }else{
                $output['success'] = false;
                $output['msg'] = $response['response']['error'];
            }
        }
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
    }

    public function warmTransfer(){
        $post = $this->input->post();
        $output = array();
        if($post && $post['is_ajax']){
            unset($post['is_ajax']);
            $fromNumber = $post['from'];
            $fNum = $post['fNum'];
            $sNum = $post['sNum'];
            $tNum = $post['tNum'];
            $CallUUID = $post['call_uuid'];
            $p = $this->plivo;
            $plivo_number = $fromNumber;
            $conference = time();
            $params = array(
                'to' => "$tNum<$fNum<$sNum", # The phon number to be called
                'from' => $plivo_number, # The phone number to be used as the caller id
                'answer_url' => site_url('callback/conference_xml/'.$CallUUID.'/'.$conference), # The URL invoked by Plivo when the outbound call is answered
                'answer_method' => "GET" # The method used to call the answer_url
            );
            $response = $p->make_call($params);
            if($response['status'] == 201){
                $output['success'] = true;
                $output['msg'] = 'Transfer successfully intiated.';
            }else{
                $output['success'] = false;
                $output['msg'] = $response['response']['error'];
            }
        }
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
    }

    public function democonference(){
        $p = $this->plivo;

        $plivo_number = "919725405958";

        $params = array(
            'to' => '919662645054<917405173235<sip:gravitybpx170615104909@phone.plivo.com', # The phon number to be called
            'from' => $plivo_number, # The phone number to be used as the caller id
            'answer_url' => "https://gravitybpx.com/welcome/demo", # The URL invoked by Plivo when the outbound call is answered
            'answer_method' => "GET" # The method used to call the answer_url
        );

        $response = $p->make_call($params);
        print_r ($response);
    }
}
