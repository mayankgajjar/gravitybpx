<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Alists extends CI_Controller {
    private $_upload_filename;
    private $_upload_extension;
    private $_data;
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agency') {
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
        $this->load->model('vicidial/vusers_m', 'vusers_m');
        $this->load->model('vicidial/vlists_m', 'vlists_m');
        $this->load->model('vicidial/vlead_m', 'vlead_m');
        $this->load->model('vicidial/vdnc_m', 'vdnc_m');
        $this->load->model('vicidial/vcampaigns_m', 'vcampaigns_m');
        $this->load->model('vicidial/acampaigns_m', 'acampaigns_m');
        $this->load->model('vicidial/vcstatuses_m', 'vcstatuses_m');
        $this->load->model('vicidial/vcategories_m', 'vcategories_m');
        $this->load->model('vicidial/alists_m', 'alists_m');
        $this->load->model('vicidial/alead_m', 'alead_m');
    }
    public function index() {
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['meta_title'] = "Lists";
        $this->data['title'] = "Lists";
        $this->data['breadcrumb'] = "Lists";
        $this->data['listtitle'] = "Lists Listing";
        $this->data['addactioncontroller'] = "dialer/alists/edit";
        $this->template->load('agency', "dialer/agency/lists/list", $this->data);
    }
    public function indexJson() {
        $aColumns = array('list_id', 'list_name', 'list_description', 'reset_time', 'leads_count', 'local_call_time', 'active', 'list_lastcalldate', 'campaign_id', 'agency');
        /*
         * Paging
         */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = " LIMIT " . $_GET['iDisplayStart'] . ", " .
                    $_GET['iDisplayLength'];
        }

        /*
         * Ordering
         */
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
                                            " . $_GET['sSortDir_' . $i] . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";
        if ($_GET['sSearch'] != "") {
            $sWhere .= "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                if($aColumns[$i] != 'leads_count' && $aColumns[$i] != 'agency' ){
                    $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
                }
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }


        $rResult = $this->vlists_m->queryForAgency($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->vlists_m->queryForAgency($sWhere);
        if ($aFilterResult) {
            $iFilteredTotal = count($aFilterResult);
        } else {
            $iFilteredTotal = 0;
        }
        $iTotal = count($aFilterResult);

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );


        $segement = $_GET['iDisplayStart'];
        $count = 1;

        if ($segement) :
            $count = $_GET['iDisplayStart'] + 1;
        endif;

        if ($rResult) {
            foreach ($rResult as $aRow) {
                $row = array();
                //$row[] = $count++;
                $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="' . encode_url($aRow['list_id']) . '"/>';
                for ($i = 0; $i < count($aColumns); $i++) {
                    if($aColumns[$i] == 'leads_count'){
                        $this->vicidialdb->db->where('list_id', $aRow['list_id']);
                        $result = $this->vicidialdb->db->get('vicidial_list');
                        $row[] = $result->num_rows();
                    }elseif($aColumns[$i] == 'agency'){
                        $this->db->where('vicidial_list_id', $aRow['list_id']);
                        $single = $this->db->get('agency_lists')->row();
                        if($single){
                            $agency_id = $single->agency_id;
                            $this->db->where('id', $agency_id);
                            $agency = $this->db->get('agencies')->row();
                            $row[] = '<a target="_blank" href="'.site_url('agency/manage_agency/agency_info/'.$agency->id).'">'.$agency->name.'</a>';
                        }else{
                            $row[] = '';
                        }
                    }else{
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }
                }

                $row[] = '<a href="' . site_url('dialer/alists/edit/' . encode_url($aRow['list_id'])) . '"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="' . site_url('dialer/alists/delete/' . encode_url($aRow['list_id'])) . '"><i class="fa fa-trash" aria-hidden="true"></i></i>';

                $output['aaData'][] = $row;
            }
        } else {
            $output['aaData'] = array();
        }

        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }
    public function edit($id = NULL) {
        $this->data['validation'] = TRUE;
        $this->data['datepicker'] = TRUE;
        $this->data['meta_title'] = "Lists";
        $this->data['title'] = "Lists";
        $this->data['breadcrumb'] = "Lists";
        $this->data['campaigns'] = $this->vcampaigns_m->get();
        $this->data['agencies'] = $this->agency_model->get_nested();

        if ($id) {
            $id = decode_url($id);
            $this->data['list'] = $this->vlists_m->get_by(array('list_id' => $id), TRUE);
            count($this->data['list']) || $this->data['errors'][] = 'List could not be found';
            $this->data['alist'] = $this->alists_m->get_by(array('vicidial_list_id' => $id), TRUE);
            $this->data['listtitle'] = "Edit List " . $this->data['list']->list_id;
        } else {
            $this->data['listtitle'] = "Add A New List";
            $this->data['list'] = $this->vlists_m->get_new();
        }
        $this->form_validation->set_rules($this->vlists_m->rules);
        if ($this->form_validation->run() == TRUE) {
            $data = $this->vlists_m->array_from_post(array('list_id', 'list_name', 'list_description', 'campaign_id', 'active', 'time_zone_setting'));
//            if ($id) {
//                $data = $this->vlists_m->array_from_post(array('list_id', 'list_name', 'list_description', 'campaign_id', 'active', 'reset_time', 'expiration_date', 'local_call_time', 'agent_script_override', 'campaign_cid_override', 'am_message_exten_override', 'drop_inbound_group_override', 'web_form_address', 'na_call_url', 'xferconf_a_number', 'xferconf_b_number', 'xferconf_c_number', 'xferconf_d_number', 'xferconf_e_number', 'inventory_report', 'time_zone_setting'));
//            }
            $data['campaign_id'] = decode_url($data['campaign_id']);
            $default = $this->vlists_m->default;
            $newData = array_merge($data, $default);
            $listId = $this->vlists_m->save($newData, $id);
            if ($listId) {
                $alist = $this->alists_m->get_by(array('vicidial_list_id' => $listId), TRUE);
                if($alist){
                    $alistId = $alist->id;
                }
                $data = array(
                    'agency_id' => $this->input->post('agency_id'), 'campaign_id' =>  $data['campaign_id'], 'vicidial_list_id' => $listId
                );
                $this->alists_m->save($data, $alistId);
                $this->session->set_flashdata('success', 'List saved successfully.');
                redirect('dialer/alists/edit/' . encode_url($listId));
            }
        }
        $this->template->load('agency', "dialer/agency/lists/edit", $this->data);
    }
    public function delete($id = NULL) {
        if ($id) {
            $id = decode_url($id);
            $this->vlists_m->delete($id);
            $alist = $this->alists_m->get_by(array('vicidial_list_id' => $id),TRUE);
            if($alist){
                $this->alists_m->delete($alist->id);
            }
            $this->session->set_flashdata('success', 'List deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'List doesn\'t exist.');
        }
        redirect('dialer/alists/index');
    }
    public function massaction() {
        $ids = $this->input->post('id');

        if (empty($ids)) {
            $this->session->set_flashdata('error', 'No List Records have been selected.');
            redirect('dialer/lists/index');
        }
        $action = $this->input->post('action');
        switch ($action) {
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $this->vlists_m->delete($id);
                    $alist = $this->alists_m->get_by(array('vicidial_list_id' => $id),TRUE);
                    if($alist){
                        $this->alists_m->delete($alist->id);
                    }
                }
                $this->session->set_flashdata('success', 'List deleted successfully.');
                break;
        }
        redirect('dialer/alists/index');
    }
    public function addlead($id = NULL) {
        $this->data['validation'] = TRUE;
        $this->data['datepicker'] = TRUE;
        $this->data['meta_title'] = "Lead Record Modification";
        $this->data['title'] = "Lead Record Modification";
        $this->data['breadcrumb'] = "Lead";

        $this->data['countries'] = $this->db->get('country')->result();
        $this->data['states'] = $this->db->get('state')->result();
        $this->data['agencies'] = $this->agency_model->get_nested();
        if($id){
            $id = decode_url($id);
            $this->data['lead'] = $this->vlead_m->get_by(array('lead_id' => $id),TRUE);
            count($this->data['lead']) || $this->data['error'][] = 'No lead Fuond.';
            $this->data['alead'] = $this->alead_m->get_by(array('vicidial_lead_id' => $id), TRUE);
            if($this->data['alead']){
                $aleadId = $this->data['alead']->id;
            }
            $stmt="SELECT uniqueid,lead_id,list_id,campaign_id,call_date,start_epoch,end_epoch,length_in_sec,status,phone_code,phone_number,user,comments,processed,user_group,term_reason,alt_dial from vicidial_log where lead_id='" . $id . "' order by uniqueid desc limit 500;";
            $this->data['call_logs'] = $this->vicidialdb->db->query($stmt)->result();
            $stmt="SELECT closecallid,lead_id,list_id,campaign_id,call_date,start_epoch,end_epoch,length_in_sec,status,phone_code,phone_number,user,comments,processed,queue_seconds,user_group,xfercallid,term_reason,uniqueid,agent_only from vicidial_closer_log where lead_id='" .$id. "' order by closecallid desc limit 500;";
            $this->data['closer_logs'] = $this->vicidialdb->db->query($stmt)->result();
            $stmt="SELECT agent_log_id,user,server_ip,event_time,lead_id,campaign_id,pause_epoch,pause_sec,wait_epoch,wait_sec,talk_epoch,talk_sec,dispo_epoch,dispo_sec,status,user_group,comments,sub_status from vicidial_agent_log where lead_id='" . $id . "' order by agent_log_id desc limit 500;";
            $this->data['agent_logs'] = $this->vicidialdb->db->query($stmt)->result();
            $stmt="SELECT campaign_id,event_date,menu_id,menu_action from vicidial_outbound_ivr_log where lead_id='" . $id . "' order by uniqueid,event_date,menu_action desc limit 500;";
            $this->data['ivr_logs'] = $this->vicidialdb->db->query($stmt)->result();
            $this->data['listtitle'] = "Modify Lead";
        }else{
            $this->data['listtitle'] = "Add New Lead";
            $this->data['lead'] = $this->vlead_m->get_new();
            $this->data['alead'] = new stdClass();
            $aleadId = NULL;
        }
        $this->form_validation->set_rules($this->vlead_m->rules);
        if($this->form_validation->run() == TRUE){
            $data = $this->vlead_m->array_from_post(array(
                'list_id', 'title', 'first_name', 'middle_initial', 'last_name', 'address1', 'address2', 'address3', 'country_code', 'state', 'city', 'postal_code', 'province', 'date_of_birth', 'phone_number', 'phone_code', 'alt_phone', 'email', 'security_phrase', 'vendor_lead_code', 'rank', 'owner', 'comments'
            ));
            $data['status'] = 'NEW';
            $lookup = lookup_gmt($data['phone_code'], $data['postal_code']);
            $data['gmt_offset_now'] = $lookup->GMT_offset;
            if($id){
                $data['status'] = $this->input->post('status');
            }
            $data['date_of_birth'] = date('Y-m-d H:i:s' ,strtotime($data['date_of_birth']));
            $data['entry_date'] = date('Y-m-d H:i:s');
            $agecy =  $this->agency_model->getAgencyInfo($this->input->post('agency_id'));
            $vuser = $this->vusers_m->get_by(array('user_id' => $agecy->vicidial_user_id), TRUE);
            $data['user'] = $vuser->user;
            $lead_id = $this->vlead_m->save($data);
            if($lead_id){
                $leadData = array(
                    'agency_id' => $this->input->post('agency_id'), 'vicidial_lead_id' => $lead_id, 'list_id' => $data['list_id']
                );
                $alead = $this->alead_m->get_by(array('vicidial_lead_id' => $lead_id),TRUE);
                if($alead){
                    $aleadId = $alead->id;
                }
                $this->alead_m->save($leadData, $aleadId);
                $this->session->set_flashdata('success','Lead added successfully');
                redirect('dialer/alists/addlead/'.  encode_url($lead_id));
            }
        }

        $this->template->load('agency', "dialer/agency/lead/add", $this->data);
    }
    public function getlist(){
        $post = $this->input->post();
        if($post){
            $html = '';
            $alists = $this->alists_m->get_by(array('agency_id' => $post['agency']));
            $html.= '<select name="list_id" class="form-control">';
            foreach($alists as $alist){
                $vlist = $this->vlists_m->get_by(array('list_id' => $alist->vicidial_list_id), TRUE);
                if($vlist){
                    $selected = '';
                    if( isset($post['list']) && $post['list'] == $vlist->list_id){
                        $selected = 'selected="selected"';
                    }
                    $html.= '<option value="'.$vlist->list_id.'" '.$selected.'>'.$vlist->list_id.' - '.$vlist->list_name.'</option>';
                }
            }
            $html.= '</select>';
            $data['success'] = TRUE;
            $data['result'] = $html;
            return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));

        }else{
            $data['success'] = FALSE;
            $data['html'] = '<input type="text" name="city" class="form-control" />';
            return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }
    }
    public function getcity(){
        $post = $this->input->post();
        if($post){
            $this->db->where('state_id', $post['state']);
            $cities = $this->db->get('city')->result();
            $html = '<select class="form-control" name="city">';
            $html.= '<option value="">Please Select</option>';
            foreach($cities as $city){
                $selected = '';
                if( isset($post['city']) && (ucwords($city->name) == ucwords($post['city']))){
                    $selected = 'selected="selected"';
                }
                $html.= '<option value="'.ucwords($city->name).'" '.$selected.'>'.$city->name.'</option>';
            }
            $html.= '</select>';
            $data['success'] = TRUE;
            $data['result'] = $html;
            return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }else{
            $data['success'] = FALSE;
            $data['html'] = '<input type="text" name="city" class="form-control" />';
            return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($data));
        }
    }
    public function getCampaigns(){
        $post = $this->input->post();
        if( $post && $post['id'] > 0){
            $query = "select * from {$this->db->protect_identifiers('agencies',TRUE)} WHERE id=".$post['id'];
            $results = $this->db->query($query)->row_array();
            /*if($results['parent_agency'] > 0){
                $ids[] = $results['parent_agency'];
            }*/
            $ids[] = $post['id'];
            $this->db->where_in('agency_id',$ids);
            $campaaigns = $this->db->get('agency_campaigns')->result();
            $campaignId = array();
            foreach($campaaigns as $campaign){
                $campaignId[] = $campaign->vicidial_campaign_id;
            }
            if(count($campaignId) <= 0){
                $data['success'] = 'FALSE';
                $this->data['campaigns'] = array();
                $string = $this->load->view('dialer/agency/lists/campaign',$this->data,TRUE);
                $data['html'] = $string;
                return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
            }
            $this->vicidialdb->db->where_in('campaign_id', $campaignId);
            $this->data['campaigns'] = $this->vicidialdb->db->get('vicidial_campaigns')->result();
            $this->data['cId'] = $this->input->post('campaign');
            $string = $this->load->view('dialer/agency/lists/campaign',$this->data,TRUE);
            $data['success'] = 'TRUE';
            $data['html'] = $string;
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
        }else{
                $data['success'] = 'FALSE';
                $this->data['campaigns'] = array();
                $string = $this->load->view('dialer/agency/lists/campaign',$this->data,TRUE);
                $data['html'] = $string;
                return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
        }
        exit;
    }
    public function loadlead(){
        $this->data['validation'] = TRUE;
        $this->data['datepicker'] = TRUE;
        $this->data['meta_title'] = "Load Leads";
        $this->data['title'] = "Load Leads";
        $this->data['listtitle'] = "Load Bulk Leads";
        $this->data['breadcrumb'] = "Lead";
        $this->data['campaigns'] = $this->vcampaigns_m->get();
        $this->data['agencies'] = $this->agency_model->get_nested();
        $this->form_validation->set_rules('lead_file', 'Load Lead File', 'callback_image_upload');
        $this->form_validation->set_rules('agency_id', 'Agency Name', 'trim|required');
        $this->form_validation->set_rules('list_id', 'List Name', 'trim|required');
        if($this->form_validation->run() == TRUE){
            $file = "./uploads/leads/".$this->_upload_filename;
            if(file_exists($file)){
                $handle = fopen($file, 'r');
                $row = 1;
                $i = 1;
                $total = 0;
                $headers = array();
                while (!feof($handle)){
                    $buffer=rtrim(fgets($handle, 4096));
                    $buffer=stripslashes($buffer);
                    if (strlen($buffer)>0){
                        $row = explode(',', preg_replace('/[\'\"]/i', '', $buffer));
                        if( $i == 1){
                            $headers = $row;
                            $i++;
                            continue;
                        }
                        $data = array_combine($headers,$row);
                        $data['list_id'] = $this->input->post('list_id');
                        $data['entry_date'] = date('Y-m-d H:i:s');
                        $lookup = lookup_gmt($data['phone_code'], $data['postal_code']);
                        $data['gmt_offset_now'] = $lookup->GMT_offset;
                        $data['date_of_birth'] = date('Y-m-d H:i:s' ,strtotime($data['date_of_birth']));
                        $data['status'] = 'NEW';
                        $this->db->where('id', $this->input->post('agency_id'));
                        $agency = $this->db->get('agencies')->row();
                        $vuser = $this->vusers_m->get_by(array('user_id' => $agency->vicidial_user_id), TRUE);
                        $data['user'] = $vuser->user;
                        $leadId = $this->vlead_m->save($data);
                        if($leadId){
                            $adata = array(
                                'agency_id' => $this->input->post('agency_id'), 'vicidial_lead_id' => $leadId, 'list_id' => $this->input->post('list_id')
                            );
                            $this->alead_m->save($adata);
                            $total++;
                        }
                        $i++;
                    }
                }
                fclose($handle);
            }
            $this->session->set_flashdata('success',$total.' leads are uploaded.');
            redirect('dialer/alists/loadlead');
        }

        $this->template->load('agency','dialer/agency/lead/loadlead',$this->data);
    }
    function image_upload(){
        if($_FILES['lead_file']['size'] != 0){
            $upload_dir = "./uploads/leads/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir);
            }
            $config['upload_path']   = $upload_dir;
            $config['allowed_types'] = 'csv';
            $config['file_name']     = $_FILES['lead_file']['name'];
            $config['overwrite']     = true;
            $config['max_size']	 = '512000000000';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('lead_file')){
                $this->form_validation->set_message('image_upload', $this->upload->display_errors());
                return false;
            }else{
                $this->upload_data['file'] =  $this->upload->data();
                $this->_data =  $this->upload->data();
                $this->_upload_filename = $_FILES['lead_file']['name'];
                $this->_upload_extension = $this->upload_data['file']['file_ext'];
                return true;
            }
	}
	else{
            $this->form_validation->set_message('image_upload', "No file selected");
            return false;
	}
    }
    function _unique_list_id(){
        $id = $this->uri->segment(4);
        $id = decode_url($id);
        $this->vicidialdb->db->where('list_id',$this->input->post('list_id'));
        !$id || $this->vicidialdb->db->where(' list_id!=', $id);
        $lists = $this->vicidialdb->db->get('vicidial_lists')->result();
        if(count($lists)){
                $this->form_validation->set_message('_unique_list_id','%s should be unique.');
                return FALSE;
        }
        return TRUE;
    }
    public function searchlead(){
        $this->data['validation'] = TRUE;
        $this->data['meta_title'] = "Lead Search";
        $this->data['title'] = "Lead Search";
        $this->data['breadcrumb'] = "Lead Search";
        $this->data['listtitle'] = "Lead Search";
        $this->template->load('agency','dialer/agency/lead/search',$this->data);
    }
    public function searchleadpost(){
        $post = $this->input->post();
        $SQLctA = 0;
        $SQLctB = 0;
        $SQLctC = 0;
        $andA = '';
        if($post){
           $vl_table = 'vicidial_list';
           $vicidial_list_fields = 'lead_id,entry_date,modify_date,status,user,vendor_lead_code,source_id,list_id,gmt_offset_now,called_since_last_reset,phone_code,phone_number,title,first_name,middle_initial,last_name,address1,address2,address3,city,state,province,postal_code,country_code,gender,date_of_birth,alt_phone,email,security_phrase,comments,called_count,last_local_call_time,rank,owner';
           if(isset($post['vendor_id']) && $post['vendor_id'] != ''){
		$stmt="SELECT $vicidial_list_fields from $vl_table where vendor_lead_code=" . $this->vicidialdb->db->escape($post['vendor_id']) . "";
           }elseif(isset($post['phone']) && $post['phone'] != '' ){
               if(isset($post['alt_phone_search']) && $post['alt_phone_search'] == 'Y' ){
                    $stmt="SELECT $vicidial_list_fields from $vl_table where phone_number=" . $this->vicidialdb->db->escape($post['phone']) . " or alt_phone=" . $this->vicidialdb->db->escape($post['phone']) . " or address3=" . $this->vicidialdb->db->escape($post['phone']) . "";
               }else{
                    $stmt="SELECT $vicidial_list_fields from $vl_table where phone_number=" . $this->vicidialdb->db->escape($post['phone']) . "";
               } //if(isset($post['alt_phone_search']) && $post['alt_phone_search'] == 'Y' )
           }elseif(isset($post['lead_id']) && $post['lead_id'] != ''){ //elseif(isset($post['phone']) && $post['phone'] != '' )
                $stmt="SELECT $vicidial_list_fields from $vl_table where lead_id=" . $this->vicidialdb->db->escape($post['lead_id']) . "";
           }elseif ((strlen($post['status'])>0) or (strlen($post['list_id'])>0) or (strlen($post['user'])>0) or (strlen($post['owner'])>0)) { //isset($post['lead_id']) && $post['lead_id'] != ''
                $statusSQL = '';
                $list_idSQL = '';
                $userSQL = '';
                $ownerSQL = '';
                if (strlen($post['status'])>0){
                    $statusSQL = "status=" . $this->vicidialdb->db->escape($post['status']) . ""; $SQLctA++;
                }
                if (strlen($post['list_id'])>0){
                    if ($SQLctA > 0) {$andA = 'and';}
                        $list_idSQL = "$andA list_id=" . $this->vicidialdb->db->escape($post['list_id']) . ""; $SQLctB++;
                    }
                if (strlen($post['user'])>0){
                    if ( ($SQLctA > 0) or ($SQLctB > 0) ) {$andB = 'and';}
                        $userSQL = "$andB user=" . $this->vicidialdb->db->escape($post['user']) . ""; $SQLctC++;
                    }
                if (strlen($post['owner'])>0){
                    if ( ($SQLctA > 0) or ($SQLctB > 0) or ($SQLctC > 0) ) {$andC = 'and';}
                        $ownerSQL = "$andC owner=" . $this->vicidialdb->db->escape($post['owner']) . "";
                    }
                $stmt="SELECT $vicidial_list_fields from $vl_table where $statusSQL $list_idSQL $userSQL $ownerSQL ";
           }elseif ((strlen($post['first_name'])>0) or (strlen($post['last_name'])>0)) {  //elseif ((strlen($post['status'])>0) or (strlen($post['list_id'])>0) or (strlen($post['user'])>0) or (strlen($post['owner'])>0))
                $first_nameSQL = '';
                $last_nameSQL = '';
                if (strlen($post['first_name'])>0){
                    $first_nameSQL = "first_name=" . $this->vicidialdb->db->escape($post['first_name']) . ""; $SQLctA++;
                }if (strlen($post['last_name'])>0){
                    if ($SQLctA > 0) {$andA = 'and';}
                    $last_nameSQL = "$andA last_name=" . $this->vicidialdb->db->escape($post['last_name']) . "";
                }
                $stmt="SELECT $vicidial_list_fields from $vl_table where $first_nameSQL $last_nameSQL ";
           }elseif( isset($post['email']) && strlen($post['email'] > 0) ) {
                $stmt="SELECT $vicidial_list_fields from $vl_table where email=" . $this->vicidialdb->db->escape($post['email']) . "";
           }else{ //$stmt="SELECT $vicidial_list_fields from $vl_table where $first_nameSQL $last_nameSQL $LOGallowed_listsSQL"
               $this->session->set_flashdata('error','You must search for something! Go back and search for something');
               redirect('dialer/alists/searchlead');
           }
            $lists = getAgencyLists();
            $stmt.=' AND list_id IN ('.$lists.') limit 0,1000';
            $query = $this->vicidialdb->db->query($stmt);
            $results = $query->result() ;
            $query->free_result();
            $this->data['datatable'] = TRUE;
            $this->data['meta_title'] = "Lead Search Result";
            $this->data['title'] = "Lead Search Result";
            $this->data['breadcrumb'] = "Search";
            $this->data['listtitle'] = "Leads";
            $this->data['results'] = $results;
            $this->template->load('agency','dialer/agency/lead/result',$this->data);
        }else{
            $this->session->set_flashdata('error','You must search for something! Go back and search for something');
            redirect('dialer/alists/searchlead');
        }
    }
}
