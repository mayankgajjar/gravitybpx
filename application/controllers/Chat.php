<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chat extends CI_Controller{

	public function __construct(){
		parent::__construct();
	/*	if(!$this->session->userdata('user')){
			die("You do not have permission to access this link.");
		}*/
		//dump($this->session->userdata());
		$this->load->library('vicidialdb');
	}

	private function __curlAction($url, $post){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec ($ch);
		curl_close ($ch);
		if($server_output == false){
			//echo "Curl error". curl_error($ch);
			$data['error'] = TRUE;
			$data['message'] = curl_error($ch);
		}else{
			$data['error'] = FALSE;
			$data['message'] = $server_output;
		}
		return $data;
	}

	public function video(){
		$this->load->view("dialer/webrtc/phone");
	}

	public function login(){
		$this->load->view("dialer/webrtc/vicilogin");
	}

	public function loginpost(){
		$post = $this->input->post();
		if($post && $post['is_ajax'] == true){
			unset($post['is_ajax']);
			$url = $this->config->item('vicidial_agent_url').'vicidial.php';
			$output = $this->__curlAction($url, $post);
            return $this->output
           		 		->set_content_type('application/json')
                		->set_output(json_encode($output));
		}else{
            return $this->output
                    	->set_content_type('application/json')
                    	->set_output(json_encode(array('error' == true,'message' => "You don't have permission to access this.")));
		}
	}

	public function setphonesession(){
		$this->load->library('vicidialdb');
		$this->load->model('vicidial/vphones_m', 'vphones_m');
		$this->load->model('vicidial/vcampaigns_m', 'vcampaigns_m');
		$post = $this->input->post();
		if($post && $post['is_ajax'] == true){
			$phone = $this->vphones_m->get_by(array('login' => $post['phone_login'], 'pass' => $post['phone_pass'], 'active' => 'Y'), TRUE);
			$campaign = $this->vcampaigns_m->get_by(array('campaign_id' => $post['campaign']), TRUE);

			$viciData = array(
				'vicidata' => array(
					'session_name' => $post['session_name'],
					'session_id' => $post['session_id'],
					'user' => $post['user'],
					'pass' => $post['pass'],
					'phone_login' => $post['phone_login'],
					'phone_pass' => $post['phone_pass'],
					'campaign' => $post['campaign'],
					'agent_log_id' => $post['agent_log_id']
				),
				'phone' => $phone,
				'campaign' => $campaign
			);
			$this->session->set_userdata($viciData);
		}
	}

	public function vdc_db_query(){
		$post = $this->input->post();
		if($post && $post['is_ajax'] == true){
			unset($post['is_ajax']);
			$url = $this->config->item('vicidial_agent_url').'vdc_db_query.php';
			$output = $this->__curlAction($url, $post);
			if($post['ACTION'] == 'userLOGout'){
				$this->session->sess_destroy();
			}
            return $this->output
                    	->set_content_type('application/json')
                    	->set_output(json_encode($output));
		}else{
            return $this->output
                    	->set_content_type('application/json')
                    	->set_output(json_encode(array('error' == true,'message' => "You don't have permission to access this.")));
		}
	}
}