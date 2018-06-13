<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avoicemail extends CI_Controller{
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
        $this->load->model('vicidial/Vvoicemail_m', 'vvoicemail_m');
        $this->load->model('vicidial/vugroup_m', 'vugroup_m');
        $this->load->model('vicidial/agroups_m', 'agroups_m');
        $this->load->model('vicidial/avoicemail_m', 'avoicemail_m');
        $this->load->model('vicidial/aaudio_m', 'audio_m');
        $this->load->model('agency_model');
    }
    public function index(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['meta_title'] = "Voicemail";
        $this->data['title'] = "Voicemail Lists";
        $this->data['breadcrumb'] = "Voicemail";
        $this->data['listtitle'] = "Voicemail Listing";
        $this->data['addactioncontroller'] = "dialer/avoicemail/edit";
        $this->template->load('agency', "dialer/agency/voicemail/list", $this->data);
    }
    public function indexjson(){
        $aColumns = array( 'voicemail_id' , 'fullname', 'active', 'messages', 'old_messages', 'delete_vm_after_email', 'user_group', 'name');
        /*
         * Paging
         */
        $sLimit = "";
        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
        {
                $sLimit = " LIMIT ". $_GET['iDisplayStart'].", ".
                         $_GET['iDisplayLength'];
        }

        /*
         * Ordering
         */
        if ( isset( $_GET['iSortCol_0'] ) )
        {
                $sOrder = "ORDER BY  ";
                for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
                {
                        if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
                        {
                                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                                        ".$_GET['sSortDir_'.$i] .", ";
                        }
                }

                $sOrder = substr_replace( $sOrder, "", -2 );
                if ( $sOrder == "ORDER BY" )
                {
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
        if ( $_GET['sSearch'] != "" )
        {
                $sWhere .= " WHERE (";
                for ( $i=0 ; $i<count($aColumns) ; $i++ )
                {
                        $sWhere .= $aColumns[$i]." LIKE '%". $_GET['sSearch']."%' OR ";
                }
                $sWhere = substr_replace( $sWhere, "", -3 );
                $sWhere .= ') ';
        }


        $rResult = $this->avoicemail_m->queryForAgency($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->avoicemail_m->queryForAgency($sWhere);
        if($aFilterResult){
                $iFilteredTotal = count($aFilterResult);
        }else{
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

        if($segement) :
                 $count = $_GET['iDisplayStart'] + 1;
        endif;
        if($rResult){
            foreach( $rResult as $aRow )
                {
                    $row = array();
                    //$row[] = $count++;
                    $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.encode_url($aRow['voicemail_id']).'"/>';
                    for ( $i=0 ; $i<count($aColumns) ; $i++ )
                        {
                                $row[] = $aRow[ $aColumns[$i] ];

                        }
                        $row[] = '<a href="'.site_url('dialer/avoicemail/edit/'.encode_url($aRow['voicemail_id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/avoicemail/delete/'.encode_url($aRow['voicemail_id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

                        $output['aaData'][] = $row;
                }
        }else{
                $output['aaData'] =  array();
        }
        return $this->output
                    ->set_content_type('application/json')
                     ->set_output(json_encode($output));

    }
    public function edit($id = NULL){
        $this->data['validation'] = TRUE;
        $this->data['models'] = TRUE;
        $this->data['meta_title'] = "Voicemail";
        $this->data['title'] = "Voicemail";
        $this->data['breadcrumb'] = "Voicemail";
        $this->data['groups'] = $this->agroups_m->getAgencyGroup($this->session->userdata('agency')->id);
        $this->data['agencies'] = $this->agency_model->get_nested();

        if($id){
            $id= decode_url($id);
            $this->data['voicemail'] = $this->vvoicemail_m->get_by(array('voicemail_id' => $id),TRUE);
            count($this->data['voicemail']) || $this->data['error'][] = 'Voicemail ID doesn\'t exists';
            $this->data['listtitle'] = "Edit Voicemail ".$this->data['voicemail']->voicemail_id;
            $avoicemail = $this->avoicemail_m->get_by(array('vicidial_voicemail_id' => $id), TRUE );
            $this->data['voicemail'] = (object) array_merge((array) $this->data['voicemail'], (array) $avoicemail);
            $this->data['zones'] = getVoicemailZones();
        }else{
            $this->data['voicemail'] = $this->vvoicemail_m->get_new();
            $this->data['listtitle'] = "Add New Voicemail ";
        }

        $this->form_validation->set_rules($this->vvoicemail_m->rules);
        if($this->form_validation->run() == TRUE){
            if($id){
                $data = $this->vvoicemail_m->array_from_post(array(
                    'voicemail_id', 'pass', 'fullname', 'active', 'email', 'user_group', 'delete_vm_after_email', 'on_login_report', 'voicemail_timezone', 'voicemail_options', 'voicemail_greeting'
                ));

            }else{
                $data = $this->vvoicemail_m->array_from_post(array(
                        'voicemail_id', 'pass', 'fullname', 'active', 'email', 'user_group'
                ));
            }
            $voicemailId = $this->vvoicemail_m->save($data, $id);
            if($voicemailId){
                $avData = array('agency_id' => $this->input->post('agency_id'), 'vicidial_voicemail_id' => $voicemailId);
                $avoicemail = $this->avoicemail_m->get_by(array('vicidial_voicemail_id' => $voicemailId), TRUE );
                $aid = null;
                if($avoicemail){
                    $aid = $avoicemail->id;
                }
                $this->avoicemail_m->save($avData, $aid);
                $this->session->set_flashdata('success', 'Voicemail saved successfully.');
                redirect('dialer/avoicemail/edit/'.  encode_url($voicemailId));
            }
        }
        $this->template->load('agency', "dialer/agency/voicemail/edit", $this->data);
    }
    public function _unique_voicemail_id($campaignId){
        $id = $this->uri->segment(4);
        $id = decode_url($id);
        $this->vicidialdb->db->where('voicemail_id',$this->input->post('voicemail_id'));
        !$id || $this->vicidialdb->db->where(' voicemail_id!=', $id);
        $voicemail = $this->vicidialdb->db->get('vicidial_voicemail')->row();
        if(count($voicemail)){
            $this->form_validation->set_message('_unique_voicemail_id','%s should be unique.');
            return FALSE;
        }
        return TRUE;
    }
    public function delete($id = NULL){
        if($id){
                $id = decode_url($id);
                $this->vvoicemail_m->delete($id);
                $aVoicemail = $this->avoicemail_m->get_by(array('vicidial_voicemail_id' => $id), TRUE);
                if($aVoicemail){
                    $this->avoicemail_m->delete($aVoicemail->id);
                }
                $this->session->set_flashdata('success','Voicemail deleted successfully.');
                redirect('dialer/avoicemail/index');
        }else{
                $this->session->set_flashdata('error','Voicemail record doesn\'t exist.');
                redirect('dialer/avoicemail/index');
        }
    }
    public function massaction(){
        $ids = $this->input->post('id');

        if(empty($ids)){
            $this->session->set_flashdata('error','No Voicemail Records have been selected.');
            redirect('dialer/avoicemail/index');
        }
        $action = $this->input->post('action');
        switch ($action){
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $this->vvoicemail_m->delete($id);
                    $aVoicemail = $this->avoicemail_m->get_by(array('vicidial_voicemail_id' => $id), TRUE);
                    if($aVoicemail){
                        $this->avoicemail_m->delete($aVoicemail->id);
                    }
                }
                $this->session->set_flashdata('success','Voicemail deleted successfully.');
                break;
        }
        redirect('dialer/avoicemail/index');
    }
    public function sound(){
        $this->data['files'] = getSoundFileList();
        $stmt = "SELECT sounds_web_directory FROM system_settings";
        $res = $this->vicidialdb->db->query($stmt)->row();
        $this->data['sounds_web_directory'] = $res->sounds_web_directory;
        $lists = explode(',',getAgencies());
        $lists[] = 0;
        $this->db->where_in('agency_id', $lists);
        $sounds = $this->db->get('agency_audio')->result_array();
        $sounds = array_column($sounds,'agency_id','audio_name');
        $this->data['sounds'] = $sounds;
        $this->load->view('dialer/agency/voicemail/sound',$this->data);
    }
    public function getAgencyGroup(){
        if($post = $this->input->post()){
            $select = '<select name="user_group" class="form-control" id="user_group">';
            $select.= '<option value="">Please Select</option>';
            if(isset($post['id']) && $post['id'] != ''){
                $groups = $this->agroups_m->getAgencyGroup($post['id']);
            }else{
                $groups = $this->vugroup_m->get();
            }
            if(!$groups){
                $groups = array();
            }
            foreach ($groups as $group){
                $selectable = '';
                if( isset($post['group']) && $group->user_group == $post['group']){
                    $selectable = 'selected="selected"';
                }
                $select.= '<option value="'.$group->user_group.'" '.$selectable.'>'.$group->user_group.'-'.$group->group_name.'</option>';
            }
            $select.= '</select>';
            $data['success'] = 'TRUE';
            $data['html'] = $select;
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($data));
        }
    }
}
