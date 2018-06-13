<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ainbound extends CI_Controller{
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
        $this->load->model('vicidial/indid_m','indid_m');
        $this->load->model('vicidial/ainded_m','ainded_m');
        $this->load->model('vicidial/vugroup_m','vugroup_m');
        $this->load->model('vicidial/vclassmenu_m', 'vclassmenu_m');
        $this->load->model('vicidial/acallmenu_m', 'acallmenu_m');
        $this->load->model('vicidial/vcalloption_m','vcalloption_m');
        $this->load->model('vicidial/vingroup_m', 'vingroup_m');
        $this->load->model('vicidial/aingroup_m', 'aingroup_m');
        $this->load->model('vicidial/agroups_m', 'agroups_m');
    }
    public function groupindex(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['meta_title'] = "In-Groups";
        $this->data['title'] = "In-Groups";
        $this->data['breadcrumb'] = "In-Groups";
        $this->data['listtitle'] = "In-Groups Listing";
        $this->data['addactioncontroller'] = "dialer/ainbound/groupedit";
        $this->template->load("agency","dialer/agency/inbound/group/list",$this->data);
    }
    public function groupindexjson(){
        $aColumns = array( 'group_id' , 'group_name', 'queue_priority', 'active', 'user_group','call_time_id', 'group_color', 'name' );
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


        $rResult = $this->aingroup_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->aingroup_m->query($sWhere);
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
            foreach( $rResult as $aRow ){
                    $row = array();
                    $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.encode_url($aRow['group_id']).'"/>';
                    for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                        if($aColumns[$i] == 'group_color' ){
                            $row[] = '<span style="background:'.$aRow['group_color'].';width:50px;height:20px;display: inline-block;"></span>';
                        }else{
                            $row[] = $aRow[ $aColumns[$i] ];
                        }
                    }
                    $row[] = '<a href="'.site_url('dialer/ainbound/groupedit/'.encode_url($aRow['group_id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/ainbound/groupdelete/'.encode_url($aRow['group_id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

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
        $this->data['model'] = TRUE;
        $this->data['colorpicker'] = TRUE;
        $this->data['meta_title'] = "In-Group";
        $this->data['agencies'] = $this->agency_model->get_nested($this->session->userdata('agency')->id);
        $this->data['groups'] = $this->agroups_m->query();
        $rules = $this->vingroup_m->rules;
        if($id){
            $id = decode_url($id);
            $this->data['ingroup'] = $this->vingroup_m->get($id, TRUE);
            count($this->data['ingroup']) || $this->data['error'][] = "Inbound group doesn't exists.";
            $ainGroup = $this->aingroup_m->get_By(array('vicidial_ingroup_id' => $id),TRUE);
            if(!$ainGroup){
                $ainGroup = new stdClass();
                $ainGroup->agency_id = 0;
            }
            $this->data['ingroup'] = (object) array_merge((array) $this->data['ingroup'], (array) $ainGroup);
            $this->data['title'] = "Edit In-Group ". $this->data['ingroup']->group_id;
            $this->data['listtitle'] = "In-Group";
            $this->data['breadcrumb'] = "In-Group";
        }else{
            $this->data['title'] = "Add New In-Group";
            $this->data['listtitle'] = "In-Group";
            $this->data['breadcrumb'] = "In-Group";
            $this->data['ingroup'] = $this->vingroup_m->get_new();
        }
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run() == TRUE){
            $default = $this->vingroup_m->default;
            $postData = $this->vingroup_m->array_from_post(array(
                'group_id', 'group_name', 'group_color', 'active', 'user_group', 'next_agent_call', 'ingroup_script', 'get_call_launch', 'drop_call_seconds', 'drop_action', 'voicemail_ext', 'call_time_id', 'after_hours_action', 'after_hours_message_filename', 'after_hours_exten', 'no_agent_no_queue', 'welcome_message_filename', 'play_welcome_message', 'onhold_prompt_filename', 'prompt_interval','after_hours_voicemail' , 'no_agent_action'
            ));
            /* no_agent_action_value logic start here */
            if ($this->input->post("no_agent_action_value")){
                $no_agent_action_value = $this->input->post("no_agent_action_value");
            }
            if ($postData['no_agent_action'] == "INGROUP"){
                if (($this->input->post("IGgroup_id_no_agent_action"))){
                    $IGgroup_id = $this->input->post("IGgroup_id_no_agent_action");
                }
                if (($this->input->post("IGhandle_method_no_agent_action"))){
                    $IGhandle_method = $this->input->post("IGhandle_method_no_agent_action");
                }
                if (($this->input->post("IGsearch_method_no_agent_action"))){
                    $IGsearch_method = $this->input->post("IGsearch_method_no_agent_action");
                }
                if (($this->input->post("IGlist_id_no_agent_action"))){
                    $IGlist_id = $this->input->post("IGlist_id_no_agent_action");
                }
                if (($this->input->post("IGcampaign_id_no_agent_action"))){
                    $IGcampaign_id=$this->input->post("IGcampaign_id_no_agent_action");
                }
                if (($this->input->post("IGphone_code_no_agent_action"))){
                    $IGphone_code = $this->input->post("IGphone_code_no_agent_action");
                }
                if (strlen($IGhandle_method)<1){
                    if (($this->input->post("IGhandle_method_"))){
                        $IGhandle_method=$this->input->post("IGhandle_method_");
                    }
                }
                if (strlen($IGsearch_method)<1){
                   if (($this->input->post("IGsearch_method_"))){
                       $IGsearch_method = $this->input->post("IGsearch_method_");
                   }
                }
                if (strlen($IGlist_id)<1){
                    if (($this->input->post("IGlist_id_"))){
                        $IGlist_id = $this->input->post("IGlist_id_");
                    }
                }
                if (strlen($IGcampaign_id)<1){
                    if (($this->input->post("IGcampaign_id_"))){
                        $IGcampaign_id = $this->input->post("IGcampaign_id_");
                    }
                }
                if (strlen($IGphone_code)<1){
                    if (($this->input->post("IGphone_code_"))){
                        $IGphone_code = $this->input->post("IGphone_code_");
                    }
                }
                $no_agent_action_value = "$IGgroup_id,$IGhandle_method,$IGsearch_method,$IGlist_id,$IGcampaign_id,$IGphone_code";
            }
            if ($postData['no_agent_action'] == "EXTENSION"){
                if (($this->input->post("EXextension_no_agent_action"))){
                    $EXextension = $this->input->post("EXextension_no_agent_action");
                }
                if (($this->input->post("EXcontext_no_agent_action"))){
                    $EXcontext = $this->input->post("EXcontext_no_agent_action");
                }
                $no_agent_action_value = "$EXextension,$EXcontext";
            }
            $no_agent_action_value = preg_replace('/[^-\/\|\_\#\*\,\.\_0-9a-zA-Z]/','',$no_agent_action_value);
            $postData['no_agent_action_value'] = $no_agent_action_value;
            /* */
            $data = array_merge($default, $postData);
            $ingroupId = $this->vingroup_m->save($data, $id);
            if($ingroupId){
                $aData = array('vicidial_ingroup_id' => $ingroupId, 'agency_id' => decode_url($this->input->post('agency_id')));
                $aInGroup = $this->aingroup_m->get_by(array('vicidial_ingroup_id' => $ingroupId), TRUE);
                $aIgId = NULL;
                if($aInGroup){
                    $aIgId = $aInGroup->id;
                }
                $this->aingroup_m->save($aData, $aIgId);
                $this->session->set_flashdata('success', 'Inbound group saved successfully.');
                redirect(site_url('dialer/ainbound/groupedit/'.encode_url($ingroupId)));
            }
        }
        $this->template->load('agency','dialer/agency/inbound/group/edit',$this->data);
    }
    public function groupdelete($id = NULL) {
        if($id) {
            $id = decode_url($id);
            $this->vingroup_m->delete($id);
            $aGroup = $this->aingroup_m->get_by(array('vicidial_ingroup_id' => $id), TRUE);
            if ($aGroup) {
                $this->aingroup_m->delete($aGroup->id);
            }
            $this->session->set_flashdata('success', 'Inbound Group deleted successfully.');
        }else{
            $this->session->set_flashdata('error', 'Inbound Group record doesn\'t exist.');
        }
        redirect('dialer/ainbound/groupindex');
    }
    public function groupmassaction(){
        $ids = $this->input->post('id');

        if(empty($ids)){
            $this->session->set_flashdata('error','No In-Groups Records have been selected.');
            redirect('dialer/ainbound/groupindex');
        }
        $action = $this->input->post('action');
        switch ($action){
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $this->vingroup_m->delete($id);
                    $aGroup = $this->aingroup_m->get_by(array('vicidial_ingroup_id' => $id), TRUE);
                    if ($aGroup) {
                        $this->aingroup_m->delete($aGroup->id);
                    }
                }
                $this->session->set_flashdata('success','Inbound Groups deleted successfully.');
                break;
        }
        redirect('dialer/ainbound/groupindex');
    }
    public function _check_ingroup_string(){
        $string =  $this->input->post('group_id');
        if(strpos($string, " ")){
            $this->form_validation->set_message('_check_ingroup_string','%s should have no spaces or punctuation.');
            return FALSE;
        }
        return TRUE;
    }
    public function _unique_ingroup_id($campaignId){
        $id = $this->uri->segment(4);
        $id = decode_url($id);
        $this->vicidialdb->db->where('group_id',$this->input->post('group_id'));
        !$id || $this->vicidialdb->db->where(' group_id!=', $id);
        $filter = $this->vicidialdb->db->get('vicidial_inbound_groups')->row();
        if(count($filter)){
            $this->form_validation->set_message('_unique_ingroup_id','%s should be unique.');
            return FALSE;
        }
        return TRUE;
    }
    public function didindex(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['meta_title'] = "Dids";
        $this->data['title'] = "Dids";
        $this->data['breadcrumb'] = "Dids";
        $this->data['listtitle'] = "Inbound DID Listing";
        $this->data['addactioncontroller'] = "dialer/ainbound/didedit";
        $this->template->load("agency","dialer/agency/inbound/did/list",$this->data);
    }
    public function didindexjson(){
        $aColumns = array( 'did_id' , 'did_pattern', 'did_description', 'did_carrier_description', 'did_active', 'user_group', 'did_route', 'record_call', 'name');
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


        $rResult = $this->ainded_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->ainded_m->query($sWhere);
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
            foreach( $rResult as $aRow ){
                    $row = array();
                    for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                        if($aColumns[$i] == 'did_id'){
                            $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.encode_url($aRow['did_id']).'"/>';
                        }else{
                            $row[] = $aRow[ $aColumns[$i] ];
                        }
                    }
                    $row[] = '<a href="'.site_url('dialer/ainbound/didedit/'.encode_url($aRow['did_id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/ainbound/diddelete/'.encode_url($aRow['did_id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

                    $output['aaData'][] = $row;
                }
        }else{
            $output['aaData'] =  array();
        }
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
    }
    public function didedit($id = NULL){
        $this->data['validation'] = TRUE;
        $this->data['model'] = TRUE;
        $this->data['meta_title'] = "Inbound DID";
        $this->data['agencies'] = $this->agency_model->get_nested($this->session->userdata('agency')->id);
        $this->data['groups'] = $this->agroups_m->query();
        $this->data['callmenues'] = $this->vclassmenu_m->get();
        if($id){
            $id = decode_url($id);
            $this->data['did'] = $this->indid_m->get_by(array('did_id' => $id), TRUE);
            count($this->data['did']) || $this->data['error'][] = 'DID not found';
            $adid = $this->ainded_m->get_by(array('vicidial_did_id' => $id), TRUE);
            $this->data['did'] = (object) array_merge((array) $this->data['did'], (array) $adid);
            $this->data['title'] = "Edit DID ".$this->data['did']->did_pattern;
            $this->data['listtitle'] = "DID";
            $this->data['breadcrumb'] = "DID";
        }else{
            $this->data['title'] = "Add New DID";
            $this->data['listtitle'] = "DID";
            $this->data['breadcrumb'] = "DID";
            $this->data['did'] = $this->indid_m->get_new();
            $this->data['did']->did_route = 'EXTEN';
            $this->data['did']->extension = '9998811112';
            $this->data['did']->user_unavailable_action = 'VOICEMAIL';
            $this->data['did']->user_route_settings_ingroup = 'AGENTDIRECT';
        }
        $this->form_validation->set_rules($this->indid_m->rules);
        if($this->form_validation->run() == TRUE){
            $data = $this->indid_m->array_from_post(array(
                'did_pattern', 'did_description', 'user_group', 'did_active', 'did_route', 'extension', 'voicemail_ext', 'phone', 'menu_id', 'user', 'user_route_settings_ingroup', 'group_id'
            ));
            $defaultData = $this->indid_m->default;
            $mergeData = array_merge($data, $defaultData);
            $did = $this->indid_m->save($mergeData,$id);
            if($did){
                $adid = $this->ainded_m->get_by(array('vicidial_did_id' => $did), TRUE);
                $adidId = NULL;
                if($adid){
                    $adidId = $adid->id;
                }
                $aData = array('vicidial_did_id' => $did, 'agency_id' => decode_url($this->input->post('agency_id')));
                $this->ainded_m->save($aData, $adidId);
                $this->session->set_flashdata('success','Inbound DID saved successfully');
                redirect('dialer/ainbound/didedit/'.  encode_url($did));
            }
        }
        $this->template->load("agency","dialer/agency/inbound/did/edit",$this->data);
    }
    public function diddelete($id = NULL) {
        if($id) {
            $id = decode_url($id);
            $this->indid_m->delete($id);
            $aDid = $this->ainded_m->get_by(array('vicidial_did_id' => $id), TRUE);
            if ($aDid) {
                $this->ainded_m->delete($aDid->id);
            }
            $this->session->set_flashdata('success', 'Inbound DID deleted successfully.');
        }else{
            $this->session->set_flashdata('error', 'DID record doesn\'t exist.');
        }
        redirect('dialer/ainbound/didindex');
    }
    public function didmassaction(){
        $ids = $this->input->post('id');

        if(empty($ids)){
            $this->session->set_flashdata('error','No DID Records have been selected.');
            redirect('dialer/inbound/didindex');
        }
        $action = $this->input->post('action');
        switch ($action){
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $this->indid_m->delete($id);
                    $aDid = $this->ainded_m->get_by(array('vicidial_did_id' => $id), TRUE);
                    if ($aDid) {
                        $this->ainded_m->delete($aDid->id);
                    }
                }
                $this->session->set_flashdata('success','Inbound DIDs deleted successfully.');
                break;
        }
        redirect('dialer/ainbound/didindex');
    }
    public function menuindex(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['meta_title'] = "Call Menus";
        $this->data['title'] = "Call Menus";
        $this->data['breadcrumb'] = "Call Menus";
        $this->data['listtitle'] = "Call Menus Listing";
        $this->data['addactioncontroller'] = "dialer/ainbound/menuedit";
        $this->template->load("agency","dialer/agency/inbound/menu/list",$this->data);
    }
    public function menuindexjson(){
        $aColumns = array( 'menu_id' , 'menu_name', 'user_group', 'menu_prompt', 'menu_timeout', 'name', 'options' );
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
                for ( $i=0 ; $i<intval( $_GET['iSortingCols']  ) ; $i++ )
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
                    if($aColumns[$i] != 'options'){
                        $sWhere .= $aColumns[$i]." LIKE '%". $_GET['sSearch']."%' OR ";
                    }
                }
                $sWhere = substr_replace( $sWhere, "", -3 );
                $sWhere .= ') ';
        }


        $rResult = $this->acallmenu_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->acallmenu_m->query($sWhere);
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
            foreach( $rResult as $aRow ){
                    $row = array();
                    $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.encode_url($aRow['menu_id']).'"/>';
                    for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                        if($aColumns[$i] == 'options'){
                            $stmt="SELECT count(*) as count from vicidial_call_menu_options where menu_id='{$aRow['menu_id']}'";
                            $row[] = $this->vicidialdb->db->query($stmt)->row()->count;
                        }else{
                            $row[] = $aRow[ $aColumns[$i] ];
                        }
                    }
                    $row[] = '<a href="'.site_url('dialer/ainbound/menuedit/'.encode_url($aRow['menu_id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/ainbound/menudelete/'.encode_url($aRow['menu_id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

                    $output['aaData'][] = $row;
                }
        }else{
            $output['aaData'] =  array();
        }
        return $this->output
                    ->set_content_type('application/json')
                     ->set_output(json_encode($output));
    }
    public function menuedit($id = NULL){
        $this->data['validation'] = TRUE;
        $this->data['model'] = TRUE;
        $this->data['meta_title'] = "Inbound Call Menus";
        $this->data['agencies'] = $this->agency_model->get_nested($this->session->userdata('agency')->id);
        $this->data['groups'] = $this->agroups_m->query();
        $this->data['inboundGroups'] = getInboundGroups();
        if($id){
            $id = decode_url($id);
            $this->data['menu'] = $this->vclassmenu_m->get_by(array('menu_id' => $id), TRUE);
            count($this->data['menu']) || $this->data['error'][] = 'Call Menu not found';
            $acallmenu = $this->acallmenu_m->get_by(array('vicidial_menu_id' => $id), TRUE);
            $this->data['menu'] = (object) array_merge((array) $this->data['menu'], (array) $acallmenu);
            $this->data['title'] = "Edit Call Menu ".$this->data['menu']->menu_id;
            $this->data['options'] = $this->vcalloption_m->get_by(array('menu_id' => $id));
            $this->data['listtitle'] = "Call Menu";
            $this->data['breadcrumb'] = "Call Menu";
        }else{
            $this->data['title'] = "Add New Call Menu";
            $this->data['listtitle'] = "Call Menu";
            $this->data['breadcrumb'] = "Call Menu";
            $this->data['menu'] = $this->vclassmenu_m->get_new();
            $this->data['menu']->menu_timeout_prompt = 'NONE';
            $this->data['menu']->menu_invalid_prompt = 'NONE';
            $this->data['menu']->menu_timeout = '10';
            $this->data['menu']->menu_repeat = '0';
        }
        $this->form_validation->set_rules($this->vclassmenu_m->rules);
        if($this->form_validation->run() == TRUE){
            $data = $this->vclassmenu_m->array_from_post(array(
                'menu_id', 'menu_name', 'user_group', 'menu_prompt', 'menu_timeout', 'menu_timeout_prompt', 'menu_invalid_prompt', 'menu_repeat', 'menu_time_check', 'call_time_id', 'track_in_vdac', 'tracking_group', 'dtmf_log'
            ));
            $menuID = $this->vclassmenu_m->save($data, $id);

            if($menuID){
                $aData = array('agency_id' => decode_url($this->input->post('agency_id'))   , 'vicidial_menu_id' => $menuID);
                $aMenu = $this->acallmenu_m->get_by(array('vicidial_menu_id' => $menuID),TRUE);
                $aMenuId = NULL;
                if($aMenu){
                    $aMenuId = $aMenu->id;
                }
                $this->acallmenu_m->save($aData, $aMenuId);
                $this->session->set_flashdata('success','Call menu saved successfully.');
                redirect('dialer/ainbound/menuedit/'.encode_url($menuID));
            }
        }
        $this->template->load("agency","dialer/agency/inbound/menu/edit", $this->data);
    }
    public function _check_string(){
        $string =  $this->input->post('menu_id');
        $result = preg_match('/[[:punct:]]/', $string);
        if($result || strpos($string, " ")){
            $this->form_validation->set_message('_check_string','%s should have no spaces or punctuation.');
            return FALSE;
        }
        return TRUE;
    }
    public function _unique_menu_id($campaignId){
        $id = $this->uri->segment(4);
        $id = decode_url($id);
        $this->vicidialdb->db->where('menu_id',$this->input->post('menu_id'));
        !$id || $this->vicidialdb->db->where(' menu_id!=', $id);
        $filter = $this->vicidialdb->db->get('vicidial_call_menu')->row();
        if(count($filter)){
            $this->form_validation->set_message('_unique_menu_id','%s should be unique.');
            return FALSE;
        }
        return TRUE;
    }
    public function menudelete($id = NULL) {
        if($id) {
            $id = decode_url($id);
            $this->vclassmenu_m->delete($id);
            $aMenu = $this->acallmenu_m->get_by(array('vicidial_menu_id' => $id), TRUE);
            if ($aMenu) {
                $this->acallmenu_m->delete($aMenu->id);
            }
            $this->session->set_flashdata('success', 'Call Menu deleted successfully.');
        }else{
            $this->session->set_flashdata('error', 'Call Menu doesn\'t exist.');
        }
        redirect('dialer/ainbound/menuindex');
    }
    public function menumassaction(){
        $ids = $this->input->post('id');

        if(empty($ids)){
            $this->session->set_flashdata('error','No Call Menu Records have been selected.');
            redirect('dialer/ainbound/menuindex');
        }
        $action = $this->input->post('action');
        switch ($action){
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $this->vclassmenu_m->delete($id);
                    $aMenu = $this->acallmenu_m->get_by(array('vicidial_menu_id' => $id), TRUE);
                    if ($aMenu) {
                        $this->acallmenu_m->delete($aDid->id);
                    }
                }
                $this->session->set_flashdata('success','Inbound Call Menu deleted successfully.');
                break;
        }
        redirect('dialer/ainbound/menuindex');
    }
    public function savemenuoption(){
        $post = $this->input->post();
        if($post){
            $h=0;
            $option_value_list='|';
            $menu_id = $post['menu_id'];
            while ($h <= 20){
                $option_value=''; $option_description=''; $option_route=''; $option_route_value=''; $option_route_value_context='';

                if(isset($post["option_value_$h"]))    {$option_value=$post["option_value_$h"];}
                if (isset($post["option_description_$h"]))	{$option_description=$post["option_description_$h"];}
                if (isset($post["option_route_$h"]))		{$option_route=$post["option_route_$h"];}
                if (isset($post["option_route_value_$h"]))	{$option_route_value=$post["option_route_value_$h"];}
                if (isset($post["option_route_value_context_$h"]))	{$option_route_value_context=$post["option_route_value_context_$h"];}

                if ($option_route == "INGROUP"){
                    if (isset($post["IGhandle_method_$h"]))			{$IGhandle_method=$post["IGhandle_method_$h"];}
                    if (isset($post["IGsearch_method_$h"]))			{$IGsearch_method=$post["IGsearch_method_$h"];}
                    if (isset($post["IGlist_id_$h"]))					{$IGlist_id=$post["IGlist_id_$h"];}
                    if (isset($post["IGcampaign_id_$h"]))				{$IGcampaign_id=$post["IGcampaign_id_$h"];}
                    if (isset($post["IGphone_code_$h"]))				{$IGphone_code=$post["IGphone_code_$h"];}
                    if (isset($post["IGvid_enter_filename_$h"]))		{$IGvid_enter_filename=$post["IGvid_enter_filename_$h"];}
                    if (isset($post["IGvid_id_number_filename_$h"]))	{$IGvid_id_number_filename=$post["IGvid_id_number_filename_$h"];}
                    if (isset($post["IGvid_confirm_filename_$h"]))		{$IGvid_confirm_filename=$post["IGvid_confirm_filename_$h"];}
                    if (isset($post["IGvid_validate_digits_$h"]))		{$IGvid_validate_digits=$post["IGvid_validate_digits_$h"];}

                    $option_route_value_context = "$IGhandle_method,$IGsearch_method,$IGlist_id,$IGcampaign_id,$IGphone_code,$IGvid_enter_filename,$IGvid_id_number_filename,$IGvid_confirm_filename,$IGvid_validate_digits";
                } //if ($option_route == "INGROUP"){

                $stmt = "SELECT use_non_latin FROM system_settings";
                $query = $this->vicidialdb->db->query($stmt);
                $row = $query->row();
                $non_latin = $row->use_non_latin;
                if ($non_latin < 1){
                    $option_value = preg_replace('/[^-\_0-9A-Z]/','',$option_value);
                    $option_description = preg_replace('/[^- \:\/\_0-9a-zA-Z]/','',$option_description);
                    $option_route = preg_replace('/[^-\_0-9a-zA-Z]/', '',$option_route);
                    $option_route_value = preg_replace('/[^-\/\|\_\#\*\,\.\_0-9a-zA-Z]/','',$option_route_value);
                    $option_route_value_context = preg_replace('/[^-\,\_0-9a-zA-Z]/','',$option_route_value_context);
                } //if ($non_latin < 1){
                if (strlen($option_route) > 0){
                    $stmtA="SELECT count(*) as count from vicidial_call_menu_options where menu_id='$menu_id' and option_value='$option_value';";
                    $query = $this->vicidialdb->db->query($stmtA);
                    $row = $query->row();
                    $option_exists = $row->count;
                    if ($option_exists > 0){
                        $stmtA="UPDATE vicidial_call_menu_options SET option_description='$option_description',option_route='$option_route',option_route_value='$option_route_value',option_route_value_context='$option_route_value_context' where menu_id='$menu_id' and option_value='$option_value';";
                        $query = $this->vicidialdb->db->query($stmtA);
                    }else{
                        $stmtA="INSERT INTO vicidial_call_menu_options SET menu_id='$menu_id',option_value='$option_value',option_description='$option_description',option_route='$option_route',option_route_value='$option_route_value',option_route_value_context='$option_route_value_context';";
                        $query = $this->vicidialdb->db->query($stmtA);
                    }
                }else{//if (strlen($option_route) > 0){
                    $stmtA="SELECT count(*) as count from vicidial_call_menu_options where menu_id='$menu_id' and option_value='$option_value';";
                    $query = $this->vicidialdb->db->query($stmtA);
                    $row = $query->row();
                    $option_exists_db = $row->count;
                    if ($option_exists_db > 0){
                        $stmtA="DELETE FROM vicidial_call_menu_options where menu_id='$menu_id' and option_value='$option_value';";
                        $query = $this->vicidialdb->db->query($stmtA);
                    }
                }
                $option_value_list .= "$option_value|";
                $h++;
            } // while ($h <= 20)
            ## delete existing database records that were not in the submit
            while ($h <= 20){
                if (!preg_match("/\|$dtmf[$h]\|/i",$option_value_list)){
                    $stmtA="SELECT count(*) as count from vicidial_call_menu_options where menu_id='$menu_id' and option_value='$dtmf[$h]';";
                    $query = $this->vicidialdb->db->query($stmtA);
                    $row = $query->row();
                    $option_exists_db = $row->count;
                }
                if ($option_exists_db > 0){
                    $stmtA="DELETE FROM vicidial_call_menu_options where menu_id='$menu_id' and option_value='$dtmf[$h]';";
                    $query = $this->vicidialdb->db->query($stmtA);
                }
                $h++;
            }
            $stmtA="UPDATE servers set rebuild_conf_files='Y' where generate_vicidial_conf='Y' and active_asterisk_server='Y';";
            $query = $this->vicidialdb->db->query($stmtA);
            $this->session->set_flashdata('success','Menu option saved successfully.');
            redirect(site_url('dialer/ainbound/menuedit/'.encode_url($menu_id)));
        }
    }
}
