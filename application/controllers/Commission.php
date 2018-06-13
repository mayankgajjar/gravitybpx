<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commission extends CI_Controller{
    
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
        $this->data['amcharts'] = true;
        $this->data['title'] = 'Agent | Commissions';
        $this->data['pagetitle'] = 'Commissions';
        $this->template->load("agent", "commissions/index", $this->data);        
    }
}
