<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        if(!$this->session->userdata("user")){
            redirect('login');
        }else{
            if($this->session->userdata("user")->group_name == 'Agent' || $this->session->userdata("user")->group_name == 'Agency' ){
                    redirect('/Forbidden');
            }
        }
        $this->data = array(
            "meta_title" => "",
            "title" => "",
            "breadcrumb" => "",
            "formtitle" => "",
            "listtitle" => "",
            "modelname" => "Dcampaign_m",
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
        $this->load->model('vicidial/vcampaigns_m','vcampaigns_m');
        $this->load->model('vicidial/acampaigns_m','acampaigns_m');
        $this->load->model('vicidial/vcstatuses_m','vcstatuses_m');
        $this->load->model('vicidial/vcategories_m','vcategories_m');
        $this->load->model('vicidial/vingroup_m', 'vingroup_m');
        $this->load->model('vicidial/aingroup_m', 'aingroup_m');
    }
    /**
     * List all campigns
     * @return none
     */
    public function index(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['meta_title'] = "Campaigns";
        $this->data['title'] = "Campaigns List";
        $this->data['breadcrumb'] = "Campaign";
        $this->data['listtitle'] = "Campaigns Listing";
        $this->data['addactioncontroller'] = "dialer/campaign/campaignedit";
        $this->template->load("admin","dialer/admin/campaign/list",$this->data);
    }
    /**
     * Datatable function for sorting,searching and pagination
     * @return none
     */
    public function indexJson( $join = NULL  ){
        $aColumns = array('id', 'campaign_id', 'campaign_name', 'agency_id', 'active');
        if($join){
            $aColumns = array('campaign_id','campaign_name', $join);
            if($join == 'accid'){
                //$aColumns[] = 'use_custom_cid';
                $aColumns = array('campaign_id','campaign_name','use_custom_cid', $join);
            }
        }
        /*
         * Paging
         */
        $sLimit = "";
        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ){
            $sLimit = " LIMIT ". $_GET['iDisplayStart'].", ".
                             $_GET['iDisplayLength'];
        }
        /*
         * Ordering
         */
        if ( isset( $_GET['iSortCol_0'] ) ){
            $sOrder = "ORDER BY  ";
            for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
                if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
                                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                                            ".$_GET['sSortDir_'.$i] .", ";
                    }
            }

            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" ){
                $sOrder = "";
            }
        }

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */

        if($join == 'preset'){
            $sWhere.= "WHERE enable_xfer_presets = 'ENABLED' ";
        }else{
            $sWhere = "";
        }
        if ( $_GET['sSearch'] != "" ){
            if($sWhere != ""){
                $sWhere .= "AND (";
            }else{
                $sWhere .= " WHERE (";
            }
            for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                if( $aColumns[$i] != 'id' && $aColumns[$i] != $join ){
                    $sWhere .= $aColumns[$i]." LIKE '%". $_GET['sSearch']."%' OR ";
                }
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ') ';
        }

        $rResult = $this->vcampaigns_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->vcampaigns_m->query($sWhere);

        if($aFilterResult){
            $iFilteredTotal = count($aFilterResult);
        }else{
            $iFilteredTotal = 0;
        }
        $iTotal = count($this->vcampaigns_m->get());

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
                //$row[] = $count++;
                for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                        if($aColumns[$i] == 'id'){
                            $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.encode_url($aRow['campaign_id']).'"/>';
                        }elseif($aColumns[$i] == $join){
                            switch($join){
                                case 'status':
                                    $statuses = $this->vcstatuses_m->get_by(array('campaign_id' => $aRow['campaign_id']));
                                    $array = array();
                                    if(count($statuses) > 0){
                                        foreach($statuses as $status){
                                            $array[] = $status->status;
                                        }
                                    $row[] = implode(' ', $array);
                                    }else{
                                        $row[] = 'None';
                                    }
                                break;
                                case 'hotkey':
                                    $hotkeys = $this->dhotkey_m->get_by(array('campaign_id' => $aRow['id']));
                                    $array = array();
                                    if(count($hotkeys) > 0){
                                        foreach($hotkeys as $hotkey){
                                            $array[] = $hotkey->status;
                                        }
                                        $row[] = implode(' ', $array);
                                        }else{
                                            $row[] = 'None';
                                        }
                                break;
                                case 'lead':
                                    $leads = $this->dleadrecycle_m->get_by(array('campaign_id' => $aRow['id']));
                                    $array = array();
                                    if(count($leads) > 0){
                                        foreach($leads as $lead){
                                            $array[] = $lead->status;
                                        }
                                        $row[] = implode(' ', $array);
                                    }else{
                                        $row[] = 'None';
                                    }
                                break;
                                case 'autoalt':
                                    if($aRow['auto_alt_dial_statuses'])
                                        $row[] = str_replace (' -', '', $aRow['auto_alt_dial_statuses']);
                                    else
                                        $row[] = 'None';
                                break;
                                case 'listmix':
                                    $listmixes = $this->dclistmix_m->get_by(array('campaign_id' => $aRow['id']));
                                    if(count($listmixes) > 0){
                                    $array = array();
                                    foreach ($listmixes as $listmix) {
                                        $array[] = $listmix->pause_code;
                                    }
                                    $row[] = implode(' ', $array);
                                    }else{
                                        $row[] = 'None';
                                    }
                                break;
                                case 'code':
                                    $pauseCodes = $this->dpausecode_m->get_by(array('campaign_id' => $aRow['id']));
                                    if(count($pauseCodes) > 0){
                                        $array = array();
                                        foreach ($pauseCodes as $pauseCode) {
                                            $array[] = $pauseCode->pause_code;
                                        }
                                        $row[] = implode(' ', $array);
                                    }else{
                                        $row[] = 'None';
                                    }
                                break;
                                case 'preset':
                                    $presets = $this->dpreset_m->get_by(array('campaign_id' => $aRow['id']));
                                    if(count($presets) > 0){
                                        $array = array();
                                        foreach ($presets as $key => $preset) {
                                            $array[] = $preset->preset_name;
                                        }
                                        $row[] = implode(' ', $array);
                                    }else{
                                        $row[] = 'None';
                                    }
                                break;
                                case 'accid':
                                    $areacodes = $this->dcareacode_m->get_by(array('campaign_id' => $aRow['id']));
                                    $row[] = count($areacodes);
                                break;
                            }
                        }elseif($aColumns[$i] == 'agency_id'){
                            $crmCam = $this->acampaigns_m->get_by(array('vicidial_campaign_id' => $aRow['campaign_id']),TRUE);
                            if(count($crmCam) == 0){
                                $row[] = 'Agency not assigned';
                            }else{
                                $this->db->where(array('id' => $crmCam->agency_id ));
                                $agency = $this->db->get('agencies')->row();
                                if( count($agency) > 0 )
                                    $row[] = "<a href='".site_url("admin/manage_agency/edit/".$agency->id)."'>".$agency->name."</a>";
                                else
                                    $row[] = 'Agency not assigned.';
                            }
                        }else{
                            $row[] = $aRow[ $aColumns[$i]];
                        }
                }
                if($join){
                    switch($join){
                        case 'status':
                            $row[] = '<a href="'.site_url('dialer/campaign/statusedit/'.encode_url($aRow['campaign_id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>';
                        break;
                        case 'hotkey':
                            $row[] = '<a href="'.site_url('dialer/campaign/hotkeyedit/'.encode_url($aRow['id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>';
                        break;
                        case 'lead':
                            $row[] = '<a href="'.site_url('dialer/campaign/leadedit/'.encode_url($aRow['id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>';
                        break;
                        case 'autoalt':
                            $row[] = '<a href="'.site_url('dialer/campaign/autoaltedit/'.encode_url($aRow['campaign_id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>';
                        break;
                        case 'code':
                            $row[] = '<a href="'.site_url('dialer/campaign/codeedit/'.encode_url($aRow['id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>';
                        break;
                        case 'listmix':
                            $row[] = '<a href="'.site_url('dialer/campaign/listmixedit/'.encode_url($aRow['id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>';
                        break;
                        case 'preset':
                            $row[] = '<a href="'.site_url('dialer/campaign/presetedit/'.encode_url($aRow['id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>';
                        break;
                        case 'accid':
                            $row[] = '<a href="'.site_url('dialer/campaign/accidedit/'.encode_url($aRow['id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>';
                        break;
                    }
                }else{
                    $row[] = '<a href="'.site_url('dialer/campaign/campaignedit/'.encode_url($aRow['campaign_id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/campaign/campaigndelete/'.encode_url($aRow['campaign_id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';
                }
                $output['aaData'][] = $row;
            }
        }else{
                    $output['aaData'] =  array();
        }
        return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($output));
    }
    /**
     * Campaign add and edit for admin
     * @param type|null $id
     * @return none
     */
    public function campaignedit($id = NULL){
        $this->data['validation'] = TRUE;
        $this->data['meta_title'] = "Campaigns";
        $this->data['title'] = "Campaigns ";
        $this->data['breadcrumb'] = "Campaign";
        $this->data['agencies'] = $this->agency_model->get_nested();
        $this->data['ingroups'] = getInboundGroupsForUser();
        $rules = $this->vcampaigns_m->rules;

        if($id){
            $id = decode_url($id);
            $this->data['campaign'] = $this->vcampaigns_m->get_by(array('campaign_id' => $id), TRUE);
            if(!$this->data['campaign']){
                $this->session->set_flashdata('error','Campaign doesn\'t exits.');
                redirect('dialer/campaign/index');
            }
            $crmCamp = $this->acampaigns_m->get_by(array('vicidial_campaign_id' => $this->data['campaign']->campaign_id), TRUE);
            if($crmCamp){
                $this->data['ingroups'] = getInboundGroupsForUser($crmCamp->agency_id);
            }
            $this->data['campaign']->agency_id = $crmCamp->agency_id;
            $this->data['listtitle'] = "Edit Campaigns ".$this->data['campaign']->campaign_id;
        }else{
                $this->data['campaign'] = $this->vcampaigns_m->get_new();
                $this->data['listtitle'] = "Add New Campaigns";
        }

        $this->form_validation->set_rules($rules);
        if( $this->form_validation->run() == TRUE ){
            $data = $this->vcampaigns_m->array_from_post(array(
                'campaign_id', 'campaign_name', 'active', 'lead_order', 'lead_filter_id', 'dial_method', 'auto_dial_level', 'campaign_vdad_exten', 'campaign_cid', 'use_internal_dnc', 'allow_closers', 'campaign_allow_inbound', 'groups'
            ));
            if($data['groups'] == null){
            	$data['groups'] = array();
            }
            if($data['allow_closers'] == 'Y'){
                $data['closer_campaigns'] = ' ';
                $data['closer_campaigns'] .= implode(' ', $data['groups']);
                unset($data['groups']);
                $data['closer_campaigns'] .= ' -';
            }else{
                unset($data['groups']);
            }
            $other  = $this->vcampaigns_m->default;
            $newData = array_merge($data, $other);
            $camId = $this->vcampaigns_m->save($newData, $id);

            if($camId){
                /* store data in CRM table for campaigns */
                $crmCamp = $this->acampaigns_m->get_by(array('vicidial_campaign_id' => $camId), TRUE);
                $crmId = NULL;
                if(count($crmCamp) > 0){
                    $crmId = $crmCamp->id;
                }
                $data = array(
                    'agency_id' => $this->input->post('agency_id'), 'vicidial_campaign_id' => $camId
                );
                $this->acampaigns_m->save($data,$crmId);
                /* end of storing data in crm */
                $this->session->set_flashdata('success','Campaign saved successfully.');
            }else{
                $this->session->set_flashdata('error','Something went wrong.');
            }
            redirect('dialer/campaign/campaignedit/'.  encode_url($camId));
        }

        if($id){
            $this->template->load("admin","dialer/admin/campaign/edit",$this->data);
        }else{
            $this->template->load("admin","dialer/admin/campaign/add",$this->data);
        }
    }

    public function _unique_campaign_id($campaignId){
        $id = $this->uri->segment(4);
        $id = decode_url($id);
        $this->vicidialdb->db->where('campaign_id',$this->input->post('campaign_id'));
        !$id || $this->vicidialdb->db->where(' campaign_id!=', $id);
        $campaign = $this->vicidialdb->db->get('vicidial_campaigns')->row();
        if(count($campaign)){
            $this->form_validation->set_message('_unique_campaign_id','%s should be unique.');
            return FALSE;
        }
        return TRUE;
    }
    public function campaigndelete($id = NULL){
        if($id){
            $id = decode_url($id);
            $this->vcampaigns_m->delete($id);
            $crmCam = $this->acampaigns_m->get_by(array('vicidial_campaign_id' => $id),TRUE);
            if($crmCam){
                $this->acampaigns_m->delete($crmCam->id);
            }
            $this->session->set_flashdata('success','Campaign deleted successfully.');
        }else{
            $this->session->set_flashdata('error','Campaign doesn\'t exist.');
        }
        redirect('dialer/campaign/index');
    }
    /**
     *  campaign deletion massaction function
     */
    public function campaignmassaction(){
        $ids = $this->input->post('id');
        if(empty($ids)){
            $this->session->set_flashdata('error','No Campaign Records have been selected.');
            redirect('dialer/campaign/index');
        }
        $action = $this->input->post('action');
        switch ($action){
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $this->vcampaigns_m->delete($id);
                    $crmCam = $this->acampaigns_m->get_by(array('vicidial_campaign_id' => $id),TRUE);
                    if($crmCam){
                        $this->acampaigns_m->delete($crmCam->id);
                    }
                }
                $this->session->set_flashdata('success','Campaign deleted successfully.');
            break;
        }
        redirect('dialer/campaign/index');
    }

    /**
     * List all status for campigns
     * @return none
     */
    public function statusindex(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['meta_title'] = "Campaigns Statues";
        $this->data['title'] = "CUSTOM CAMPAIGN STATUSES LISTINGS: ";
        $this->data['breadcrumb'] = "Campaign Status";
        $this->data['listtitle'] = "CUSTOM CAMPAIGN STATUSES LISTINGS: ";
        $this->template->load("admin","dialer/admin/campaign/status/list",$this->data);
    }
    /**
     * Add and edit statues for campaigns
     * @param type|null or int $id
     * @return none
     */
    public function statusedit($id = NULL, $statusid = NULL){
        $this->data['validation'] = TRUE;
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;

        if($id){
            $id = decode_url($id);
            $this->data['campaign'] = $this->vcampaigns_m->get_by(array('campaign_id' => $id), TRUE);
            if(count($this->data['campaign']) == 0){
                $this->session->set_flashdata('error','Campaign doesn\'t exists.');
                    redirect('dialer/campaign/statusindex');
            }
            $this->data['statuses'] = $this->vcstatuses_m->get_by(array('campaign_id' => $id));
        }
        $this->data['meta_title'] = "Campaigns Statues";
        $this->data['title'] = "CUSTOM CAMPAIGN STATUS MODIFIED ";
        $this->data['breadcrumb'] = "Campaign Status";
        $this->data['listtitle'] = $this->data['campaign']->campaign_id." : CUSTOM STATUSES WITHIN THIS CAMPAIGN";
        $this->data['categories'] = $this->vcategories_m->get();

        $this->form_validation->set_rules($this->vcstatuses_m->rules);
        if($this->form_validation->run() == TRUE){
            $data = $this->vcstatuses_m->array_from_post( array(
                'status', 'campaign_id', 'status_name', 'selectable', 'human_answered', 'sale', 'dnc', 'customer_contact', 'not_interested', 'unworkable', 'scheduled_callback', 'category'
            ));
            $data['campaign_id'] = decode_url($data['campaign_id']);
            $Statusid = $this->vcstatuses_m->save($data, NULL);
            $this->session->set_flashdata('success','Status saved successfully.');
            redirect('dialer/campaign/statusedit/'. encode_url($id));
        }

        $this->template->load("admin","dialer/admin/campaign/status/edit",$this->data);
    }
    /**
     * List of all hotkeys that associated with campaigns
     * @return null
     */

    public function autoaltindex(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['meta_title'] = "Campaigns";
        $this->data['title'] = "Campaigns Auto-alt List";
        $this->data['breadcrumb'] = "Campaign Auto-alt";
        $this->data['listtitle'] = "Campaigns Auto-alt Listing";
        $this->data['addactioncontroller'] = "dialer/campaign/autoaltedit";
        $this->template->load("admin","dialer/admin/campaign/autoalt/list",$this->data);
    }

    public function autoaltedit($id = NULL){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['validation'] = TRUE;
        if($id){
            $id = decode_url($id);
            $this->data['campaign'] = $this->vcampaigns_m->get_by(array('campaign_id' => $id), TRUE);
            if(count($this->data['campaign']) == 0){
                $this->session->set_flashdata('error','Campaign doesn\'t exists.');
                redirect('dialer/campaign/autoaltindex');
            }
            $records = $this->vcampaigns_m->get_by(array('campaign_id' => $id),TRUE);
            if($records->auto_alt_dial_statuses)
                $this->data['autoalts'] = explode(' ',trim(preg_replace("/ -$/","",$records->auto_alt_dial_statuses)));
            else
            $this->data['autoalts'] = array();
        }

        $this->form_validation->set_rules('status', 'Status', 'trim|required|callback__check_auto_alt');

        if($this->form_validation->run() == TRUE){
            $aultalt = $this->vcampaigns_m->get_by(array('campaign_id'=> $id),TRUE)->auto_alt_dial_statuses;

            if($aultalt){
                $aultalt = trim(preg_replace("/ -$/","",$records->auto_alt_dial_statuses));
                $array = explode(' ', $aultalt);
            }else{
                $array = array();
            }

            $array[] = $this->input->post('status');

            $data['auto_alt_dial_statuses'] = implode(' ', $array).' -';
            $campid = $this->vcampaigns_m->save($data,$id);
            if($campid){
                $this->session->set_flashdata('success','Auto-Alt saved successfully.');
                redirect('dialer/campaign/autoaltedit/'.encode_url($id));
            }
        }

        $this->data['meta_title'] = "Campaigns Auto-alt";
        $this->data['title'] = "Campaigns Auto-alt";
        $this->data['breadcrumb'] = "Campaign Auto-alt";
        $this->data['listtitle'] = $this->data['campaign']->campaign_id." : Auto Alt Number Dialing For This Campaign";

        //$this->data['hotKeyStatuses'] = $this->dstatuses_m->getHotkeyStatuses();
        $this->template->load("admin","dialer/admin/campaign/autoalt/edit",$this->data);
    }

    public function deletealt(){
        if($post = $this->input->post()){
            $id = decode_url($post['id']);
            $aultalts = $this->vcampaigns_m->get_by(array('campaign_id'=> $id),TRUE)->auto_alt_dial_statuses;
            $array = explode(' ', trim(preg_replace("/ -$/","",$aultalts)));
            foreach ( $array as $key => $value) {
                if($post['status'] == $value ){
                    unset($array[$key]);
                }
            }
            $data['auto_alt_dial_statuses'] = implode(' ', $array).' -';
            $campid = $this->vcampaigns_m->save($data,$id);
            $output['success'] = TRUE;
            $output['msg'] = 'Record deleted successfully.';
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
        }
    }

    public function _check_auto_alt(){
        $post = $this->input->post();
        $id = decode_url($post['campaign_id']);
        $aultalt = $this->vcampaigns_m->get_by(array('campaign_id'=> $id),TRUE)->auto_alt_dial_statuses;

        if($aultalt){
            $aultalt = trim(preg_replace("/ -$/","",$aultalt));
            $array = explode (' ', $aultalt);
        }else{
            $array = array();
        }
        $flag = FALSE;
        foreach ($array as $key => $value) {
            if( $value == $post['status'] ){
                $flag = TRUE;
                break;
            }
        }

        if($flag == TRUE){
            $this->form_validation->set_message('_check_auto_alt','There is already a auto alt status in the system with this campaign.');
            return FALSE;
        }
        return TRUE;
    }

    public function ajaxedit($id = NULL){
        if( $data = $this->input->post() ){
            $model = $data['model'];
            $id = decode_url($data['id']);
            unset($data['model']);
            unset($data['id']);
            $id = $this->$model->save($data, $id);
            if($id){
                $output['success'] = TRUE;
                $output['msg'] = 'Record Updated successfully.';
                return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($output));
            }else{
                $output['success'] = FALSE;
                $output['msg'] = 'Something went wrong.';
                return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($output));
            }
        }
    }

    public function deleteall(){
        if($data = $this->input->post()){
            $model = $data['model'];
            $id = decode_url($data['id']);
            $status = $this->$model->get_by(array('id' => $id), TRUE);
            if(count($status) == 0 ){
                $output['success'] = FALSE;
                $output['msg'] = 'Record not found.';
                return $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode($output));
            }
            $delete = $this->$model->delete($id);
            $output['success'] = TRUE;
            $output['msg'] = 'Record deleted successfully.';
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));

            }
        }
}