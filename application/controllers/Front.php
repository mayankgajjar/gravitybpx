<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    
    public function index(){
    	if ($this->session->userdata("user")) {
            if ($this->session->userdata('user')->group_name == 'Admin') {
                redirect('admin');
            } else if ($this->session->userdata('user')->group_name == 'Agency') {
                redirect('agency');
            } else if ($this->session->userdata('user')->group_name == 'Agent') {
                redirect('agent');
            } else if ($this->session->userdata('user')->group_name == 'Vendor') {
                redirect('vendor');
            }else{
	        	redirect('home');
	        	exit;	
        	}
        }
        else{
        	redirect('home');
        	exit;	
        }
        
    }
}