<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Agent extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Admin') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('agents');
        $params = getPlivoAuth();
        $this->load->library('plivo', array('auth_id' => $params['plivo_auth_id'], 'auth_token' => $params['plivo_auth_token']));
    }

    public function create_endpoint($agentId = NULL){
        $post = $this->input->post();
        if($agentId && $post && $post['is_ajax'] == true){
            // Create an Endpoint
            $agent = $this->agents->get($agentId, TRUE);
            $params = array(
                'username' => strtolower($agent->fname).$agent->id, # The username for the endpoint to be created
                'password' => time(), # The password for your endpoint username
                'alias' => strtolower($agent->fname).$agent->id # Alias for this endpoint
            );
            $result = $this->plivo->create_endpoint($params);
            $response = $result['response'];
            $data['sip_end_point'] = $response['username'];
            $data['sip_end_point_password'] = $params['password'];
            $this->agents->save($data, $agentId);
            $output['success'] = true;
            $output['msg'] = 'Plivo end points have been created for Agent '.$agent->fname.' '.$agent->lname;
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
        }
    }
}
