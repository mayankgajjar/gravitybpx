<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agent extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata("user")){
            redirect('login');
        }else{
            if($this->session->userdata("user")->group_name != 'Agent'){
                redirect('/Forbidden');
            }
        }
        $this->load->library('vicidialdb');
        $this->load->model('vicidial/vusers_m','vusers_m');
        $this->load->model('vicidial/aphones_m','aphones_m');
        $this->load->model('vicidial/vphones_m','vphones_m');
    }

    public function user(){
        $this->data['breadcrumb'] = 'Dialer Login';
        $this->data['title'] = 'Agent Dialer Login Detail';
        $this->data['listtitle'] = 'Login Details';
        $this->data['validation'] = TRUE;
        $agentId = $this->session->userdata('agent')->vicidial_user_id;
        if($agentId > 0){
            $this->data['user'] = $this->vusers_m->get_by(array('user_id' => $agentId),TRUE);
        }
        count($this->data['user']) || $this->data['error'][] = 'Agent not found in dialer.';
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|callback__unique_email');
        $this->form_validation->set_rules('pass', 'Password', 'trim|required|callback__check_special_char['.$this->input->post('pass').']');
        $this->form_validation->set_rules('full_name', 'Name', 'trim|required');
        if ( $this->form_validation->run() == TRUE){
            $data = $this->vusers_m->array_from_post(array(
                'email', 'pass', 'full_name'
            ));
            $agentId = $this->vusers_m->save($data,$agentId);
            if($agentId){
                $this->session->set_flashdata('success','Record saved successfully.');
            }else{
                $this->session->set_flashdata('error','Something went wrong.');
            }
            redirect('dialer/agent/user');
        }
        $this->template->load('agent','dialer/agent/user',$this->data);
    }

    public function phone(){
        $this->data['breadcrumb'] = 'Phone Login';
        $this->data['title'] = 'Agent Phone Login Detail';
        $this->data['listtitle'] = 'Login Details';
        $this->data['validation'] = TRUE;
        $agentId = $this->session->userdata('agent')->vicidial_user_id;
        if($agentId > 0){
            $this->data['user'] = $this->vusers_m->get_by(array('user_id' => $agentId),TRUE);
            $aPhone = $this->aphones_m->get_by(array('vicidial_user_id' => $agentId), TRUE);
            $phoneId = $aPhone->vicidial_phone_id;
            $this->data['phone'] = $this->vphones_m->get_by(array('id' => $phoneId),TRUE);
        }
        count($this->data['phone']) || $this->data['error'][] = 'Agent not found in dialer.';
        $this->form_validation->set_rules('pass', 'Password', 'trim|required|callback__check_special_char['.$this->input->post('pass').']');
        $this->form_validation->set_rules('pass', 'Password', 'trim|required|callback__check_special_char['.$this->input->post('conf_secret').']');
        if( $this->form_validation->run() == TRUE){
           $data = $this->vphones_m->array_from_post(array(
               'fullname', 'conf_secret', 'outbound_cid'
           ));
           $pId = $this->vphones_m->save($data,$phoneId);
           if($pId){
               $this->session->set_flashdata('success','Phone saved successfully.');
               redirect('dialer/agent/phone');
           }
        }

        $this->template->load('agent','dialer/agent/phone',$this->data);
    }

    public function _check_special_char($pass){
        $password = $pass;
        $illegal = "#!$%^&*()+=-[]';,./{}|:<>?~";

        if (strpbrk($password, $illegal)) {
            $this->form_validation->set_message('_check_special_char','%s should not have special character.');
            return FALSE;
        }
        return TRUE;
    }
    public function _unique_email($email){
        $id = $this->session->userdata('agent')->vicidial_user_id;;
        $this->vicidialdb->db->where('email',$this->input->post('email'));
        !$id || $this->vicidialdb->db->where(' user_id!=', $id);
        $user = $this->vicidialdb->db->get('vicidial_users')->result();
        if(count($user)){
            $this->form_validation->set_message('_unique_email','%s should be unique.');
            return FALSE;
        }
        return TRUE;
    }
}
