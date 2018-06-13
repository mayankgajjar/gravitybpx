<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aremote extends CI_Controller{
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
        $this->load->model('vicidial/vremote_m','vremote_m');
        $this->load->model('vicidial/aremote_m','aremote_m');
        $this->load->model('vicidial/vregroup_m','vregroup_m');
        $this->load->model('vicidial/aregroup_m','aregroup_m');
    }
    public function index(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['meta_title'] = "Remote Agents";
        $this->data['title'] = "Remote Agents";
        $this->data['breadcrumb'] = "Remote Agents";
        $this->data['listtitle'] = "Remote Agents Listing";
        $this->data['addactioncontroller'] = "dialer/reomote/edit";
        $this->template->load('agency', "dialer/agency/remote/list", $this->data);
    }
    public function indexjson(){
        $aColumns = array( 'remote_agent_id' , 'user_start', 'number_of_lines', 'server_ip', 'conf_exten', 'extension_group', 'status', 'campaign_id', 'name');
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


        $rResult = $this->aremote_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->aremote_m->query($sWhere);
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
                    for ( $i=0 ; $i<count($aColumns) ; $i++ )
                        {
                            if($aColumns[$i] == 'remote_agent_id'){
                                $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.encode_url($aRow['remote_agent_id']).'"/>';
                            }else{
                                $row[] = $aRow[ $aColumns[$i] ];
                            }

                        }
                        $row[] = '<a href="'.site_url('dialer/aremote/edit/'.encode_url($aRow['remote_agent_id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/aremote/delete/'.encode_url($aRow['remote_agent_id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

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
        $this->data['meta_title'] = "Remote Agent";
        $this->data['title'] = "Remote Agent";
        $this->data['breadcrumb'] = "Remote Agent";
        $this->data['agencies'] = $this->agency_model->get_nested();
        $rules = $this->vremote_m->rules;
        if($id){
            $id = decode_url($id);
            $this->data['ragent'] = $this->vremote_m->get_by(array('remote_agent_id' => $id),TRUE);
            count($this->data['ragent']) || $this->data['error'][] = "Remote agent record doen't exist.";
            $aragent = $this->aremote_m->get_by(array('vicidial_remote_id' => $id), TRUE);
            $this->data['listtitle'] = "Edit Remote Agent ".$this->data['ragent']->user_start;
            if($aragent){
                $this->data['ragent'] = (object) array_merge((array) $this->data['ragent'], (array) $aragent);
            }else{
                $this->data['ragent']->agency_id = 0;
            }
        }else{
            $this->data['listtitle'] = "Add New Remote Agent";
            $this->data['ragent'] = $this->vremote_m->get_new();
            $this->data['ragent']->agency_id = $this->input->post('agency_id') ? $this->input->post('agency_id') : '';
        }
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run() == TRUE){
            $dataDefault = $this->vremote_m->default;
            $pData = $this->vremote_m->array_from_post(array(
                'user_start', 'number_of_lines', 'conf_exten', 'extension_group', 'status', 'campaign_id', 'on_hook_agent', 'on_hook_ring_time', 'campaign_id'
            ));
            $data = array_merge($dataDefault, $pData);
            if(strlen($data['campaign_id']) > 0){
                $data['campaign_id'] = decode_url($data['campaign_id']);
            }
            if(count($this->input->post('closer_campaigns')) > 0){
                $data['closer_campaigns'] = implode(' - ', $this->input->post('closer_campaigns'));
                $data['closer_campaigns'] .= ' -';
            }
            $remoteId = $this->vremote_m->save($data, $id);
            if($remoteId){
                $aData = array('vicidial_remote_id' => $remoteId , 'agency_id' => decode_url($this->input->post('agency_id')));
                $arId  = NULL;
                $ar = $this->aremote_m->get_by(array('vicidial_remote_id' => $remoteId), TRUE);
                if($ar){
                    $arId  = $ar->id;
                }
                $this->aremote_m->save($aData, $arId);
                $this->session->set_flashdata('success','Remote Agent saved successfully.');
                redirect('dialer/aremote/edit/'.  encode_url($remoteId));
            }
        }
        $this->template->load('agency', "dialer/agency/remote/edit", $this->data);
    }
    function _unique_remote_id(){
        $id = $this->uri->segment(4);
        $user_start = $this->input->post('user_start');
        $this->vicidialdb->db->where('user_start',$this->input->post('user_start'));
        !$id || $this->vicidialdb->db->where(' user_start!=', $user_start);
        $lists = $this->vicidialdb->db->get('vicidial_remote_agents')->result();
        $this->vicidialdb->db->last_query();
        if(count($lists)){
                $this->form_validation->set_message('_unique_remote_id','%s should be unique.');
                return FALSE;
        }
        return TRUE;
    }
    public function delete($id = NULL){
        if($id){
                $id = decode_url($id);
                $this->vremote_m->delete($id);
                $aRemote = $this->aremote_m->get_by(array('vicidial_remote_id' => $id), TRUE);
                if($aRemote){
                    $this->aremote_m->delete($aRemote->id);
                }
                $this->session->set_flashdata('success','Remote agent deleted successfully.');
                redirect('dialer/aremote/index');
        }else{
                $this->session->set_flashdata('error','Remote agent record doesn\'t exist.');
                redirect('dialer/aremote/index');
        }
    }
    public function massaction(){
        $ids = $this->input->post('id');

        if(empty($ids)){
            $this->session->set_flashdata('error','No Extension Group records have been selected.');
            redirect('dialer/aremote/index');
        }
        $action = $this->input->post('action');
        switch ($action){
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $this->vremote_m->delete($id);
                    $aRemote = $this->aremote_m->get_by(array('vicidial_remote_id' => $id), TRUE);
                    if($aRemote){
                        $this->aremote_m->delete($aRemote->id);
                    }
                }
                $this->session->set_flashdata('success','Remote agents deleted successfully.');
                break;
        }
        redirect('dialer/aremote/index');
    }
    public function groupindex(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['meta_title'] = "Extension Group";
        $this->data['title'] = "Extension Group";
        $this->data['breadcrumb'] = "Extension Group";
        $this->data['listtitle'] = "Extension Group";
        $this->data['addactioncontroller'] = "dialer/reomote/groupedit";
        $this->template->load('agency', "dialer/agency/remote/group/list", $this->data);
    }
    public function groupindexjson(){
        $aColumns = array( 'extension_id' , 'extension_group_id', 'extension', 'rank', 'campaign_groups', 'call_count_today', 'last_call_time', 'last_callerid', 'name');
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


        $rResult = $this->aregroup_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->aregroup_m->query($sWhere);
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
                    for ( $i=0 ; $i<count($aColumns) ; $i++ )
                        {
                            if($aColumns[$i] == 'extension_id'){
                                $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.encode_url($aRow['extension_id']).'"/>';
                            }else{
                                $row[] = $aRow[ $aColumns[$i] ];
                            }

                        }
                        $row[] = '<a href="'.site_url('dialer/aremote/groupedit/'.encode_url($aRow['extension_id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/aremote/groupdelete/'.encode_url($aRow['extension_id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

                        $output['aaData'][] = $row;
                }
        }else{
                $output['aaData'] =  array();
        }
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));

    }
    public function groupedit($id = NULL){
        $this->data['validation'] = TRUE;
        $this->data['models'] = TRUE;
        $this->data['meta_title'] = "Extension Group";
        $this->data['title'] = "Extension Group";
        $this->data['breadcrumb'] = "Extension Group";
        $this->data['agencies'] = $this->agency_model->get_nested();
        $rules = $this->vregroup_m->rules;
        if($id){
            $id = decode_url($id);
            $this->data['rgroup'] = $this->vregroup_m->get_by(array('extension_id' => $id), TRUE);
            count($this->data['rgroup']) || $this->data['error'][] = "Extension group doesn't exist.";
            $aGroup = $this->aregroup_m->get_by(array('vicidial_extension_id' => $id), TRUE);
            if($aGroup){
                $this->data['rgroup'] = (object) array_merge((array) $this->data['rgroup'], (array) $aGroup);
            }else{
                $this->data['rgroup']->agency_id = $this->input->post('agency_id') ? $this->input->post('agency_id') : 0;
            }
            $this->data['listtitle'] = "Edit Extension Group ". $this->data['rgroup']->extension_group_id;
        }else{
            $this->data['listtitle'] = "Add New Extension Group";
            $this->data['rgroup'] = $this->vregroup_m->get_new();
            $this->data['rgroup']->agency_id = $this->input->post('agency_id') ? $this->input->post('agency_id') : 0;
        }
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run() == TRUE){
            $default = $this->vregroup_m->default;
            $pData = $this->vregroup_m->array_from_post(array(
                'extension_group_id', 'extension', 'rank', 'campaign_groups'
            ));
            $data = array_merge($default, $pData);
            $gId = $this->vregroup_m->save($data, $id);
            if($gId){
                $aData = array('vicidial_extension_id' => $gId,'agency_id'=>  decode_url($this->input->post('agency_id')));
                $aId = NULL;
                $aGroup = $this->aregroup_m->get_by(array('vicidial_extension_id' => $gId), TRUE);
                if($aGroup){
                    $aId = $aGroup->id;
                }
                $this->aregroup_m->save($aData,$aId);
                $this->session->set_flashdata('success','Extension group saved successfully.');
                redirect('dialer/aremote/groupedit/'.  encode_url($gId));
            }
        }
        $this->template->load('agency', "dialer/agency/remote/group/edit", $this->data);
    }
    function _unique_group_id(){
        $id = $this->uri->segment(4);
        $this->vicidialdb->db->where('extension_group_id',$this->input->post('extension_group_id'));
        !$id || $this->vicidialdb->db->where(' extension_group_id!=', $this->input->post('extension_group_id'));
        $lists = $this->vicidialdb->db->get('vicidial_extension_groups')->result();
        if(count($lists)){
                $this->form_validation->set_message('_unique_group_id','%s should be unique.');
                return FALSE;
        }
        return TRUE;
    }
    public function groupdelete($id = NULL){
        if($id){
            $id = decode_url($id);
            $this->vregroup_m->delete($id);
            $aExt = $this->aregroup_m->get_by(array('vicidial_extension_id' => $id), TRUE);
            if($aExt){
                $this->aregroup_m->delete($aExt->id);
            }
            $this->session->set_flashdata('success','Extension group deleted successfully.');
            redirect('dialer/aremote/groupindex');
        }else{
            $this->session->set_flashdata('error','Extension group record doesn\'t exist.');
            redirect('dialer/aremote/groupindex');
        }
    }
    public function groupmassaction(){
        $ids = $this->input->post('id');

        if(empty($ids)){
            $this->session->set_flashdata('error','No Extension Group records have been selected.');
            redirect('dialer/aremote/groupindex');
        }
        $action = $this->input->post('action');
        switch ($action){
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $this->vregroup_m->delete($id);
                    $aExt = $this->aregroup_m->get_by(array('vicidial_extension_id' => $id), TRUE);
                    if($aExt){
                        $this->aregroup_m->delete($aExt->id);
                    }
                }
                $this->session->set_flashdata('success','Extension groups deleted successfully.');
                break;
        }
        redirect('dialer/aremote/groupindex');
    }
}