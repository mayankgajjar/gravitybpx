<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller{

	public function __construct(){
		parent::__construct();
	}
	/**
	 * [these function get the lead disposition status from url then add it to CRM]
	 * Authentication Deatils
	 * user :: crm
	 * password :: leadDispo
	 * @return [type] [description]
	 */
	public function disposition(){
		$post = $this->input->post();
		$output = array();
		// authenctication checking
		if($post){
			if( (!isset($post['user']) && $post['user'] != 'crm') && (!isset($post['password']) && $post['password'] != 'leadDispo') ){
				$output['success'] = FALSE;
				$output['html'] = 'Something went wrong.';
				return $this->output
							->set_content_type('application/json')
							->set_output(json_encode($output));
			}
			$this->load->model('vicidial/vstatuses', 'vstatuses');
			$this->load->model('vicidial/vlead_m', 'vlead_m');
			$lead_id = $post['lead_id'];
			$dispo_choice = $post["dispo_choice"];
			$user = $post['user'];
			$leadData = $this->vlead_m->get_by(array('lead_id' => $lead_id), TRUE);
			$despoData = $this->vstatuses->get_by(array('status' => $dispo_choice), TRUE);

		}else{
			$output['success'] = FALSE;
			$output['html'] = 'Something went wrong.';
		}
		return $this->output
					->set_content_type('application/json')
					->set_output(json_encode($output));
	}
}
