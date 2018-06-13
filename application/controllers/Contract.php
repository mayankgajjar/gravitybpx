<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agent') {
                redirect('/Forbidden');
            }
        }
    }

    public function index(){
        // For now display agent page        
        $this->data['title'] = 'Agent | CRM';
        $this->data['pagetitle'] = 'Contract';
        $this->template->load("agent", "contract/index", $this->data);        
    }
}
