<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Viciagent
 *
 *
 */
class Viciagent extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('user')->group_name != 'Agent') {
            die("You don't have permission to access this.");
        }
        $this->load->library('vagentapi');
        $this->load->library('vicidialdb');
    }

    public function login() {

        $this->load->model('User_model');
        $this->load->model('vicidial/aphones_m', 'aphones_m');
        $this->load->model('vicidial/vusers_m', 'vusers_m');
        $this->load->model('vicidial/vphones_m', 'vphones_m');
        $group = $this->session->userdata('user')->group_name;
        if ($group == 'Agent') {
            $agent = $this->User_model->getAgentFromUser_id($this->session->userdata('user')->id);
            $vicidialUserId = $agent->vicidial_user_id;
            if ($vicidialUserId > 0) {
                $viciuser = $this->vusers_m->get($vicidialUserId, TRUE);
                $post['VD_login'] = $viciuser->user;
                $post['VD_pass'] = $viciuser->pass;
                $campaigns = $this->vagentapi->getcampaign($post);
                $post['VD_campaign'] = isset($campaigns[1]) ? $campaigns[1] : '';
                $aphone = $this->aphones_m->get_by(array('vicidial_user_id' => $viciuser->user_id), TRUE);
                if ($aphone) {
                    $phone = $this->vphones_m->get($aphone->vicidial_phone_id, TRUE);
                    $post['phone_login'] = $phone->login;
                    $post['phone_pass'] = $phone->pass;
                }
                //$post['phone_login'] = '120';
                //$post['phone_pass'] = 'test';
                if (!$this->session->userdata('vicidata')) {
                    $flag = $this->vagentapi->login($post);
                }

                //dump($this->session->userdata());
            }
        }

        $html = $this->load->view('dialer/webrtc/agent', '', true);
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode(array('content' => $html)));
    }

    /**
     * this function will set the ingroups for agents
     */
    public function setingroup() {
        $this->vagentapi->setIngoups();
    }

    /**
     * this will execute vicidial server agent vdc_db_query file via
     * curl
     * @return [type] [description]
     */
    public function vdc_db_query() {
        $post = $this->input->post();
        if ($post && $post['is_ajax'] == true) {
            unset($post['is_ajax']);
            $output = $this->vagentapi->vdc_db_query($post);
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($output));
        } else {
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(array('error' => true, 'message' => "You don't have permission."));
        }
    }

    public function checkphone() {
        $post = $this->input->post();
        if ($post && $post['is_ajax'] == true) {
            unset($post['is_ajax']);
            $post['source'] = 'test';
            $post['function'] = 'check_phone_number';
            $post['user'] = $this->config->item('vicidial_admin_username');
            $post['pass'] = $this->config->item('vicidial_admin_password');
            $output = $this->vagentapi->nonagentapi($post);
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($output));
        }
    }

    /**
     * check the status of the user
     * @return [type] [description]
     */
    public function checkstatus() {
        $post = $this->input->post();
        if ($post && $post['is_ajax'] == true) {
            unset($post['is_ajax']);
            $post['source'] = 'test';
            $post['function'] = 'agent_status';
            $post['user'] = $this->config->item('vicidial_admin_username');
            $post['pass'] = $this->config->item('vicidial_admin_password');
            $output = $this->vagentapi->nonagentapi($post);
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($output));
        }
    }

    /**
     * change the status of the login user on vicidial
     * @return [type] [description]
     */
    public function changestatus() {
        $post = $this->input->post();
        if ($post && $post['is_ajax'] == true) {
            unset($post['is_ajax']);
            $status = $post['status'];
            $conf_exten = $this->session->userdata('vicidata')['session_id'];
            $user = $this->session->userdata('vicidata')['user'];
            $sql = "UPDATE vicidial_live_agents SET status='{$status}' WHERE conf_exten='{$conf_exten}' AND user='{$user}'";
            $result = $this->vicidialdb->db->query($sql);
            if ($result) {
                $output['success'] = true;
                $output['message'] = "status changes.";
            } else {
                $output['success'] = false;
                $output['message'] = "status not changes.";
            }
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($output));
        }
    }

    public function liveagents() {
        $post = $this->input->post();
        $this->load->model('vicidial/vusers_m', 'vusers_m');
        if ($post && $post['is_ajax'] == true) {
            unset($post['is_ajax']);
            $agencyId = $this->session->userdata('agent')->agency_id;
            $agents = getLiveAgents($agencyId);
            $users = array();
            if ($agents) {
                foreach ($agents as $agent) {
                    $viciId = $agent->vicidial_user_id;
                    if ($viciId > 0) {
                        $user = $this->vusers_m->get($viciId, TRUE);
                        $username = $user->user;
                        $sql = "SELECT * FROM vicidial_live_agents WHERE user='{$username}'";
                        $query = $this->vicidialdb->db->query($sql);
                        $row = $query->row();
                        $users[] = array(
                            'crmagentid' => $agent->id,
                            'username' => $username,
                            'status' => $row ? $row->status : 'offline',
                        );
                    }
                }
            }
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($users));
        }
    }

    public function agentapicall() {
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            $post['user'] = $this->config->item('vicidial_admin_username');
            $post['pass'] = $this->config->item('vicidial_admin_password');
            $post['source'] = 'test';
            $output = $this->vagentapi->agentapi($post);
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($output));
        }
    }

    public function record() {
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            $output = $this->vagentapi->callrecord($post);
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($output));
        }
    }

    public function check_for_conf_calls() {
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            $output = $this->vagentapi->check_for_conf_calls($post);
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));            
        }
    }

    /**
     * manager_send API call
     */
    public function manager_send() {
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            $output = $this->vagentapi->manager_send($post);
            return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($output));
        }
    }
    
    public function getagentchannel(){
        $post = $this->input->post();
        if ($post && $post['is_ajax']) {
            unset($post['is_ajax']);
            $extension = $this->session->userdata('vicidata')['phoneObj']->extension;
            $sql = "SELECT * FROM live_sip_channels WHERE channel like '%{$extension}%'";
            $query = $this->vicidialdb->db->query($sql);
            $row = $query->row_array();
            $output['success'] = true;
            $output['message'] = $row;
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));            
        }
    }
    
    public function setsession(){
        $post = $this->input->post();
        if($post && $post['is_ajax']){
            unset($post['is_ajax']);
            $sessionId = $post['session'];
            $_SESSION['vicidata']['session_id'] = $sessionId;
            $output['success'] = true;
            $output['messsage'] = $this->session->userdata('vicidata');
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));             
        }
    }

}
