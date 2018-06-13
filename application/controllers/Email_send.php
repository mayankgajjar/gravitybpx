<?php
/**
 * Description of Mail_send
 *
 * @author Meet
 */
class Email_send extends CI_Controller
{
	public $data = array();
    public function __construct() 
    {
        parent::__construct();
        if(!$this->session->userdata("user"))
        {
            redirect('login');
        }
    }
        
	public function email_send_function($operation = "add")
    {
        $table_name_array = unserialize (TABLE_NAME);
        $this->load->model('Agency_model');
        $this->load->model('Common_model');         
        if($operation == "add")
        {                                                                   
            if($this->input->post())
            {                                
                $post = $this->input->post();
                $this->form_validation->set_rules('select_send_email_type', 'Send Email Type', 'trim|required');
                $this->form_validation->set_rules('parent_agency', 'Parent Agency', 'trim|required');
                //$this->form_validation->set_rules('email_from', 'From', 'trim|required');
                $this->form_validation->set_rules('email_to', 'To', 'trim|required');
                $this->form_validation->set_rules('email_subject', 'Subject', 'trim|required');
                $this->form_validation->set_rules('email_body', 'Body', 'trim|required');                
                if ($this->form_validation->run() == TRUE)
                {                                                                                                                                                                            
                    $email_setting_data = get_option('email_setting');
                    $email_setting_config = unserialize($email_setting_data);
                    $register_link['email_sender_id'] = $this->session->userdata("user")->id;
                    $register_link['sender_type'] = $post['select_send_email_type'];
                    $register_link['parent_id'] = $post['parent_agency'];
                    if($post['agent_type'] == "")
                    {
                        $register_link['agent_type_id'] = 0;
                    }                    
                    else
                    {
                        $register_link['agent_type_id'] = $post['agent_type'];
                    }
                    $register_link['email_from'] = $email_setting_config['sender_email'];
                    $register_link['email_to'] = $post['email_to'];
                    $register_link['email_subject'] = $post['email_subject'];
                    $register_link['email_body'] = $post['email_body'];
                    $register_link['token'] = $post['token'];
                    $register_link['request_time'] = $_SERVER["REQUEST_TIME"];
                    $register_link['is_active'] = 1;
                    $register_link['created_at'] = date('Y-m-d H:i:s');
                    $register_link['modified_at'] = date('Y-m-d H:i:s');
                    $this->db->trans_begin();
                    $this->Common_model->add($register_link,$table_name_array['register_link']);                    
                    if ($this->db->trans_status() === FALSE)
                    {
                        $this->db->trans_rollback();
                        $this->form_validation->set_error_delimiters('<div class="error_fields">','</div>');
                        $this->session->set_flashdata('error_server_register_link',validation_errors());                        
                        $this->data['title'] = 'Email Send';    
                        if($this->session->userdata('user')->group_name == 'Admin')
                        {
                            $this->data['agency'] = $this->Agency_model->getAll();
                            $this->template->load("admin","email/email_send",$this->data);
                        }
                        else if($this->session->userdata('user')->group_name == 'Agency')
                        {                    
                            $this->data['agency'] = $this->Agency_model->getAllSubAgencyByParentAgency($this->session->userdata('agency')->id);                   
                            $this->template->load("agency","email/email_send",$this->data);                            
                        }
                        $this->session->set_flashdata('error','Your mail has not been sent successfully');
                    }
                    else
                    {
                        $this->load->model('Email_model');
                        $client_email = $this->input->post('email_to');
                        //$admin_email = get_admin_email();
                        $subject = $this->input->post('email_subject');                                
                        $message = $this->input->post('email_body');
                        $this->Email_model->mail_send($subject,$client_email,$message);
                        //$this->Email_model->mail_send($subject,$admin_email,$message);
                        $this->session->set_flashdata('success','Your mail has been sent successfully');
                        $this->db->trans_commit();
                    }                  
                    redirect('email_send/email_send_function');                                                                                                  
                }                                                                                                                                         
            }
            else
            {
                $this->data['title'] = 'Email Send';                
                //$codition = "theme_options_name = 'notifications_setting'";
                //$this->data['notifications_setting_data'] = $this->Common_model->getRowByCondition($codition,$table_name_array['theme_options']);
                //$this->data['notifications_type'] = $this->Common_model->getArrayByCondition(1,'is_active',$table_name_array['notifications_type'],'');                           
                if($this->session->userdata('user')->group_name == 'Admin')
                {
                    $this->data['agency'] = $this->Agency_model->getAll();
                    $this->template->load("admin","email/email_send",$this->data);
                }
                else if($this->session->userdata('user')->group_name == 'Agency')
                {                    
                    $this->data['agency'] = $this->Agency_model->getAllSubAgencyByParentAgency($this->session->userdata('agency')->id);                   
                    $this->template->load("agency","email/email_send",$this->data);
                }
                /*else if($this->session->userdata('user')->group_name == 'Agent')
                {
                    $this->template->load("agent","email/email_send",$this->data);
                }*/               
            }                                   
        } 
    }

    public function encode_value($value)
    {
        echo encode_url($value);
        die;
    }
    public function decode_value($value)
    {
        echo decode_url($value);
        die;
    } 
}
