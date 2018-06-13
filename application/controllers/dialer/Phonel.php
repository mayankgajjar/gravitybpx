<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Phonel extends CI_Controller{

	public function __consruct(){
		parent::__consruct();
        if (!$this->session->userdata("user")) {
         	die('You do not have access to this url.');
        }
		$this->load->model('phonelog');
	}

	public function addlog(){
		$this->load->model('phonelog');
		$post = $this->input->post();
		if($post && $post['ajax'] == TRUE){
			$data = $this->phonelog->array_from_post(array(
				'phone_number', 'type', 'extension', 'agent_id', 'vicidial_user'
			));
			$id = $this->phonelog->save($data, null);
		}
	}

	public function addmanualdiallead(){
		$post = $this->input->post();
		if($post && $post['ajax'] == TRUE){
			$data = $post['phone_number'];
			
		}
	}
}