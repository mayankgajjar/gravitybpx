<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quote extends CI_Controller{
    
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
        $this->data['title'] = 'Agent | Quote';
        $this->data['pagetitle'] = 'Start New Quote';
        $this->template->load("agent", "quote/index", $this->data);        
    }
    
    public function product(){
        $this->data['title'] = 'Agent | Quote';
        $this->data['pagetitle'] = '';
        $this->template->load("agent", "quote/product", $this->data);          
    }
}
