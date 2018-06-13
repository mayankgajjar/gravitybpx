<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class setting extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
        if(!$this->session->userdata("user"))
        {
            redirect('login');
        }
        else
        {
            if($this->session->userdata("user")->group_name == 'Agent' || $this->session->userdata("user")->group_name == 'Agency')
            {
                redirect('/Forbidden');
            }
        }
		$this->data = array(
				"meta_title" => "System Setting",
				"title" => "System Setting",
				"breadcrumb" => "Setting",
				"formtitle" => "System Setting",
				"listtitle" => "Setting",
				"modelname" => "dsetting_m",
				"formactioncontroller" => "",
				"addactioncontroller" => "",
				"deleteactioncontroller" => "",
				"openparentsli" => "configuration",
				//"activeparentsli" => "status_management",
				//"deletetitle" => "Status",
				"datatablecontroller" => "statusmanagementcontroller/indexJson",
				);
		$this->load->model('dsetting_m');
	}

	public function index()
	{
		$post = $this->input->post();
		if($post){
			$this->_svae_option($post);
		}		

		$this->template->load("admin","dialer/admin/setting/edit",$this->data);
	}

	private function _svae_option($post = array(), $redirect = 'index')
	{
		foreach ($post as $key => $value) {
				$option = $this->dsetting_m->get_by(array('name' => $key),TRUE);
				$id = NULL;
				if($option){
					$id = $option->id;
				}
				$this->dsetting_m->save(array('name' => $key, 'value' => $value),$id);
		}
		$this->session->set_flashdata('success','Settings saved successfully.');
		redirect('dialer/setting/'.$redirect);
	}
}
