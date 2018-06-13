<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leadimport extends CI_Controller{

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agent') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('leadstore_m');
    }

    public function index(){
    }

    public function csv_upload($type = 'lead'){
        $this->data['title'] = 'Agent | CRM ' . ucfirst($type) . ' | Bulk Upload';
        $this->data['pagetitle'] = ucfirst($type) . ' Bulk Upload';
        $this->data['validation'] = TRUE;
        $this->data['listtitle'] = 'Mapping ' . ucfirst($type) .' Data';
        $this->data['status'] = ucfirst($type);
        $this->form_validation->set_rules('lead_file', 'Load Lead File', 'callback_image_upload');
        if ($this->form_validation->run() == TRUE) {
            $file = "./uploads/leads/" . $this->_upload_filename;
            if(file_exists($file)){
               $handle = fopen($file, "r");
                    $key = 0;
                     while (($lead_data = fgetcsv($handle, 10000, ",")) !== FALSE)
                     {
                        if($key == 0){
                            $this->data['lead_header'] = $lead_data;
                        }
                        break;
                    }
                    $this->session->set_userdata('file_name',$file);
                    $this->data['fields'] = $this->lead_store_fields();
                    $this->template->load("agent", "crm/csv_map", $this->data);
            }
            else{
                $this->session->set_flashdata('error', 'File Not Exist');
                redirect('crm/loadbulk/'.$status);
            }
        }
        else
        {
            $this->session->set_flashdata('error', 'Invalid file, Please choose CSV file only.');
            redirect('crm/loadbulk/'.$status);
        }
    }

    public function lead_store_fields(){
        $data=array(
                'member_id'             => 'Member Id',
                'first_name'            => 'First Name',
                'middle_name'           => 'Middle Name',
                'last_name'             => 'Last Name',
                'gender'                => 'Gender',
                'date_of_birth'         => 'Date Of Birth',
                'height'                => 'Height',
                'weight'                => 'Weight',
                'address'               => 'Address',
                'address1'              => 'Address 1',
                'state'                 => 'State',
                'postal_code'           => 'Postal Code',
                'city'                  => 'City',
                'phone'                 => 'Phone',
                'cellphone'             => 'Cellphone',
                'work_phone'            => 'Work Phone',
                'email'                 => 'Email',
                'mothers_maiden_name'   => 'Mothers Maiden Name',
                'license_number'        => 'License Number',
                'occupation'            => 'Occupation',
                'notes'                 => 'Notes',
                );
        return $data;
    }


    function image_upload() {
        if ($_FILES['lead_file']['size'] != 0) {
            $upload_dir = "./uploads/leads/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir);
            }
            $config['upload_path'] = $upload_dir;
            $config['allowed_types'] = 'csv';
            $config['file_name'] = $_FILES['lead_file']['name'];
            $config['overwrite'] = true;
            $config['max_size'] = '512000000000';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('lead_file')) {
                $this->form_validation->set_message('image_upload', $this->upload->display_errors());
                return false;
            } else {
                $this->upload_data['file'] = $this->upload->data();
                $this->_data = $this->upload->data();
                $this->_upload_filename = $this->_data['file_name'];
                $this->_upload_extension = $this->upload_data['file']['file_ext'];
                return true;
            }
        } else {
            $this->form_validation->set_message('image_upload', "No file selected");
            return false;
        }
    }

    public function csv_mapping(){

        if(isset($_POST['submit'])){ 
            $file = $this->session->userdata('file_name');
            $data = [];
            if(file_exists($file)){
               $handle = fopen($file, "r");
                $key = 0;
                $total = 0;
                $eRecords = 0;
                $type = strtolower($this->input->post('status'));
                switch ($type) {
                    case 'lead':
                        $status = 'Lead';
                        $dispo = 'NEW';
                        break;
                    case 'opportunity':
                        $status = 'Opportunity';
                        $dispo = 'QUOTED';
                        break;
                    case 'client':
                        $status = 'Client';
                        $dispo = 'SALE MADE';
                        break;
                }
                $fields = $this->input->post('fields');
                 
                 while (($lead_data = fgetcsv($handle, 10000, ",")) !== FALSE){
                     
                    if($key != 0){
                        foreach($fields as $k=>$field){
                            if($k == 'date_of_birth'){
                                if($lead_data[$field]){
                                    $data[$k] = date('Y-m-d', strtotime($lead_data[$field]));
                                }else{
                                    $data[$k] = '';
                                }
                            }elseif($k == 'height'){
                                $data[$k] .= '"';
                                $data[$k] = substr_replace($lead_data[$field], "'", 1, 0);
                            }elseif($k == 'phone'){
                                $data[$k] = preg_replace('/[^0-9\']/', '', $lead_data[$field]);
                            }else{
                                $data[$k] = $lead_data[$field];
                            }
                        }
                        $data['status'] = $status;
                        $data['agency_id'] = $this->session->userdata('agent')->agency_id;
                        $data['user'] = $this->session->userdata('agent')->id;
                        $data['owner'] = $this->session->userdata('user')->email_id;
                        $data['dispo'] = $dispo;
                        $data['created'] = date("Y-m-d H:i:s");
                        $data['modified'] = date("Y-m-d H:i:s");
                        
                        $leadId = NULL;
                        if (isset($data['member_id']) && strlen($data['member_id']) > 0 && is_numeric($data['member_id'])) {
                            $leadData = $this->leadstore_m->get_by(array('member_id' => $data['member_id']), TRUE);
                            if ($leadData) {
                                $leadId = $leadData->lead_id;
                            }
                        } else {
                            $data['member_id'] = getIncrementMemberId();
                        }
                        
                        $check_validate = $this->check_validations($data);
                        if(!is_array($check_validate)){
                            if ((strlen($data['first_name']) <= 0) || (strlen($data['last_name']) <= 0) || (strlen($data['phone']) <= 0 ) || (!is_numeric($data['phone']))) {
                                $eRecords++;
                            }else{
                                $lead = $this->leadstore_m->save($data, $leadId);
                                if ($lead) {
                                    if ($leadId == NULL) {
                                        updateIncrementMemberId();
                                    }
                                    $total++;
                                }
                            }
                        } else {
                            $eRecords++;
                        }
                    }
                    $key++;
                }
                
                fclose($handle);
            }
            if($type == 'opportunity'){
                $msg = 'opportunities';
            }else{
                $msg = $type."s";
            }
            if ($total > 0) {
                if($eRecords > 0){
                    $this->session->set_flashdata('success', $total . " {$msg} are uploaded. <BR>".$eRecords. " {$type} are not uploaded.Because some required  fields are empty OR phone or email are not unique.");
                }else{
                    $this->session->set_flashdata('success', $total . " {$msg} are uploaded.");
                }
            }
            else if ($eRecords > 0) {
                $this->session->set_flashdata('error', $eRecords . " {$msg} are not uploaded. Because some required  fields are empty OR phone or email are not unique.");
            }
            @unlink($file);
            redirect('crm/loadbulk/' . $type);
        }

    }
    
    public function check_validations($data){
        $_POST = $data; 
        $this->form_validation->set_rules('phone', 'Phone Number', 'callback_checkPhone');
        $this->form_validation->set_rules('email', 'Email Address', 'callback_checkEmail');
        if ($this->form_validation->run() !== FALSE) {
            return TRUE;
        } else {

            //--- get last error 
            $error = $this->form_validation->error_array();
            $error = array_slice($error, 0, 1);

            //--- restore posted form 
            $this->form_validation = new CI_Form_validation();
            return array('error' => current($error));
        }
    }
    
    public function checkPhone($phone) {
        $con_arr = array('phone' => $phone , 'user' => $this->session->userdata('agent')->id);
        $query = $this->db->where($con_arr)->get('lead_store_mst');
        if ($query->num_rows() != 0) {
            return FALSE;
        } else {
            return True;
        }
    }
    
    public function checkEmail($email) {
        $con_arr = array('email' => $email , 'user' => $this->session->userdata('agent')->id);
        $query = $this->db->where($con_arr)->get('lead_store_mst');
        if ($query->num_rows() != 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }


}
