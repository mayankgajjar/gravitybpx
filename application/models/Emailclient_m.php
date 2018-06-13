<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emailclient_m extends My_Model{
    protected $_table_name = 'emailclient_send_mail';
    protected $_primary_key = 'send_email_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'send_email_id';
    protected $_timestamps = TRUE;
   

    public function get_new(){
        $task = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $bid->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $task;
    }
    
    function send_new_email($to, $subject, $message, $formname, $cc, $bcc, $attachments, $smtp_data) {
        $data = $smtp_data;
        if($data['smtp_type'] == 'Yes'){
            $smtp = 'smtp';
        } else {
            $smtp = '';
        }
        $password = base64_decode($data['password']);

        $config['protocol'] = $smtp;
        $config['smtp_host'] = $data['host'];
        $config['smtp_port'] = $data['port'];
        $config['smtp_user'] = $data['username'];  //change it
        $config['smtp_pass'] = $password; //change it
        $config['charset'] = 'utf-8';
        $config['newline'] = "\r\n";
        $config['mailtype'] = 'html';
        $config['wordwrap'] = TRUE;
        
        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from($data['username'], $formname); //sender email,seander name
        $this->email->to($to);   //reciever email
        if(isset($cc) && $cc != ''){
            $this->email->cc($cc);
        }
         if(isset($bcc) && $bcc != ''){
            $this->email->bcc($bcc);
        }
        $this->email->subject($subject);
        $this->email->message($message);
        if ($attachments) {
            foreach ($attachments as $attchment) {
                $this->email->attach($attchment);
            }
        }
        if ($this->email->send()) {
            return 1;
        } else {
            return 0;
        }
        
    }
    
    

}
