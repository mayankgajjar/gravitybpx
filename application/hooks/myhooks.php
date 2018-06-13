<?php

class MyClass {

    function sessionTime() {
        $this->CI = & get_instance();
        $IdleTime = time() - $this->CI->session->userdata("user")->login_time;
        if ($IdleTime >= 50) { //subtract new timestamp from the old one
            echo $IdleTime . 'IN';
            $this->CI->load->model('LiveAgent_m', 'liveAgent');
            $this->CI->liveAgent->delete($this->CI->session->userdata('liveagent')->liveagent);
            $this->CI->session->sess_destroy();
            $this->CI->session->set_flashdata('msg', 'Your Session Time Out');
            redirect($this->CI->config->item('http') . $this->CI->config->item('main_url') . 'login');
        } else {
            echo $IdleTime . 'OUT';
            $curtime = time();
            $_SESSION['user']->login_time = $curtime;
        }
    }

}
