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
			$message = '';
			$this->load->model('vicidial/vstatuses', 'vstatuses');
			$this->load->model('vicidial/vlead_m', 'vlead_m');
			$this->load->model('vicidial/transfer', 'transfer');
			$lead_id = $post['lead_id'];
			$dispo_choice = $post["dispo_choice"];
			$agent = $post['agent'];
			$leadData = $this->vlead_m->get_by(array('lead_id' => $lead_id), TRUE);
			$despoData = $this->vstatuses->get_by(array('status' => $dispo_choice), TRUE);
			$objData = serialize($despoData);
			// $filePath = "notice.txt";
		 	// $fp = fopen($filePath, "w");
		 	// fwrite($fp, $objData);
		 	// fclose($fp);
			if($despoData && $despoData->transfer_crm == 'Y'){
				$data = $this->transfer->array_from_post(array(
					'lead_id', 'dispo_choice', 'agent'
				));
				$this->transfer->save($data);
				$message = sprintf('%s lead added successfully.', $lead_id);
			}
			$output['success'] = TRUE;
			$output['html'] = $message;
		}else{
			$output['success'] = FALSE;
			$output['html'] = 'Something went wrong.';
		}
		return $this->output
					->set_content_type('application/json')
					->set_output(json_encode($output));
	}
}
