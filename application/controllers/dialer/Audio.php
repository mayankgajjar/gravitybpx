<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audio extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name == 'Agent' || $this->session->userdata("user")->group_name == 'Agency') {
                redirect('/Forbidden');
            }
        }
        $this->data = array(
            "meta_title" => "",
            "title" => "",
            "breadcrumb" => "",
            "formtitle" => "",
            "listtitle" => "",
            "modelname" => "dcalltime_m",
            "formactioncontroller" => "",
            "addactioncontroller" => "",
            "deleteactioncontroller" => "",
            "openparentsli" => "configuration",
            "activeparentsli" => "status_management",
            "deletetitle" => "Status",
            "datatablecontroller" => "statusmanagementcontroller/indexJson",
        );
        $this->load->library('vicidialdb');
        $this->load->model('agency_model');
        $this->load->model('vicidial/aaudio_m','audio_m');
    }
    public function index(){
        $this->data['models'] = TRUE;
        $this->data['meta_title'] = "Audio Store";
        $this->data['title'] = "Audio Store";
        $this->data['breadcrumb'] = "";
        $this->data['listtitle'] = "Audio Store";
        $this->data['addactioncontroller'] = "dialer/voicemail/edit";
        $this->template->load('admin', "dialer/admin/audio/list", $this->data);
    }
    public function sound($var){
        $this->data['files'] = getSoundFileList();
        $this->data['var'] = $var;
        $stmt = "SELECT sounds_web_directory FROM system_settings";
        $res = $this->vicidialdb->db->query($stmt)->row();
        $this->data['sounds_web_directory'] = $res->sounds_web_directory;
        $this->load->view('dialer/admin/audio/sound',$this->data);
    }
    public function uploadfile(){
        if($_FILES['audio']['size'] != 0){
            $upload_dir = "./uploads/audio/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir);
            }
            $filename = time().cleanFileName($_FILES['audio']['name']);
            $config['upload_path']   = $upload_dir;
            $config['allowed_types'] = 'wav';
            $config['file_name']     = $filename;
            $config['overwrite']     = true;
            $config['max_size']	 = '54000000';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('audio')){
                $this->session->set_flashdata('error', $this->upload->display_errors());
                return false;
            }else{
                $this->upload_data['file'] =  $this->upload->data();
                $upload_filename = $this->upload_data['file']['file_name'];
                $vicihost = $this->config->item('vicidial_url').'vicidial/crm/audio.php';
                $access = 'access=CRM';
                $operation = 'operation=upload';
                $filename = 'filename='.$upload_filename;
                $file = 'file='.rawurlencode($this->config->item('base_url').'uploads/audio/'.$upload_filename);
                $url = $vicihost.'?'.$access.'&'.$operation.'&'.$filename.'&'.$file;
                $data = file_get_contents($url);
                $this->audio_m->save(array('audio_name' => $upload_filename ),NULL);
                $this->session->set_flashdata('success', 'File uploaded successfully.');
            }
	}
	else{
            $this->session->set_flashdata('error', "No file selected.");
	}
       redirect('dialer/audio/index');
    }
    public function renamefile(){
        $this->form_validation->set_rules('master_audiofile','Original File','trim|required');
        $this->form_validation->set_rules('new_audiofile','New File','trim|required');
        if($this->form_validation->run() == TRUE){
            $post = $this->input->post();
            $vicihost = $this->config->item('vicidial_url').'vicidial/crm/audio.php';
            $upload_dir = "./uploads/audio/";
            $oldFile = $upload_dir.$post['master_audiofile'].'.wav';
            $checkUrl = $vicihost."?access=CRM&operation=check&filename=".$post['master_audiofile'].'.wav';
            $checkData = file_get_contents($checkUrl);
            $checkData = json_decode($checkData);
            if(file_exists($oldFile) || $checkData->success){
                $newFile = $upload_dir.$post['new_audiofile'].'.wav';
                @copy($oldFile, $newFile);
                $access = 'access=CRM';
                $operation = 'operation=copy';
                $filename = 'filename='.$post['master_audiofile'].'.wav';
                $newname = 'newname='.$post['new_audiofile'].'.wav';
                $url = $vicihost.'?'.$access.'&'.$operation.'&'.$filename.'&'.$newname;
                $url = file_get_contents($url);
                $file = $this->audio_m->get_by(array('audio_name' => $post['master_audiofile'].'.wav' ), TRUE);
                $id = NULL;
//                if($file){
//                    $id = $file->id;
//                }
                $this->audio_m->save(array('audio_name' => $post['new_audiofile'].'.wav'), $id);
                $this->session->set_flashdata('success','File copied successfully');
            }
        }else{
            $this->session->set_flashdata('error', "File doesn't exists");
        }
       redirect('dialer/audio/index');
    }
    public function deletefile(){
        $this->form_validation->set_rules('delete_file', 'Delete File', 'trim|required');
        if($this->form_validation->run() == TRUE){
            $post = $this->input->post();
            $vicihost = $this->config->item('vicidial_url').'vicidial/crm/audio.php';
            $upload_dir = "./uploads/audio/";
            $filePath = $upload_dir.$post['delete_file'].'.wav';
            $checkUrl = $vicihost."?access=CRM&operation=check&filename=".$post['delete_file'].'.wav';
            $checkData = file_get_contents($checkUrl);
            $checkData = json_decode($checkData);
            if(file_exists($filePath) || $checkData->success ){
                @unlink($filePath);
                $access = 'access=CRM';
                $operation = 'operation=delete';
                $filename = 'filename='.$post['delete_file'].'.wav';
                $url = $vicihost.'?'.$access.'&'.$operation.'&'.$filename;
                $url = file_get_contents($url);
                $file = $this->audio_m->get_by(array('audio_name' => $post['delete_file'].'.wav' ), TRUE);
                if($file){
                    $this->audio_m->delete($file->id);
                }
                $this->session->set_flashdata('success','File deleted successfully');
            }
        }else{
             $this->session->set_flashdata('error', "File doesn't exists");
        }
        redirect('dialer/audio/index');
    }
}
