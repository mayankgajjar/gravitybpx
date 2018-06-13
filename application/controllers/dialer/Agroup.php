<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agroup extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata("user")){
            redirect('login');
        }
        else{
            if(!$this->session->userdata("user")->group_name == 'Agency'){
                redirect('/Forbidden');
            }
        }
        $this->data = array(
            "meta_title" => "User Group",
            "title" => "User Group",
            "breadcrumb" => "User Group",
            "formtitle" => "User Group",
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
        $this->load->model('vicidial/agroups_m','agroups_m');
        $this->load->model('vicidial/vugroup_m','vugroup_m');
        $this->load->model('vicidial/vcampaigns_m','vcampaigns_m');
        $this->load->model('vicidial/vcalltime_m','vcalltime_m');
    }

    public function index(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['listtitle'] = 'User Group Listing';
        $this->template->load('agency',"dialer/agency/group/list",$this->data);
    }

    public function indexjson(){
        $aColumns = array( 'main.id' , 'user_group', 'group_name', 'forced_timeclock_login', 'name');
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


        $rResult = $this->agroups_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->agroups_m->query($sWhere);
        if($aFilterResult){
                $iFilteredTotal = count($aFilterResult);
        }else{
                $iFilteredTotal = 0;
        }
        $iTotal = count($this->agroups_m->get());

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
                            if($aColumns[$i] == 'main.id'){
                                    $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.encode_url($aRow['id']).'"/>';
                            }else{
                                $row[] = $aRow[ $aColumns[$i] ];
                            }
                        }
                        $row[] = '<a href="'.site_url('dialer/agroup/edit/'.encode_url($aRow['id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/group/delete/'.encode_url($aRow['id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

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
       $this->data['formtitle'] = 'User Group';
       $this->data['UGreports'] =  'ALL REPORTS, NONE, Real-Time Main Report, Real-Time Campaign Summary , Inbound Report, Inbound Service Level Report, Inbound Summary Hourly Report, Inbound Daily Report, Inbound DID Report, Inbound Email Report, Inbound IVR Report, Outbound Calling Report, Outbound Summary Interval Report, Outbound IVR Report, Fronter - Closer Report, Lists Campaign Statuses Report, Campaign Status List Report, Export Calls Report , Export Leads Report , Agent Time Detail, Agent Status Detail, Agent Performance Detail, Team Performance Detail, Performance Comparison Report, Single Agent Daily, Single Agent Daily Time, User Group Login Report, User Timeclock Report, User Group Timeclock Status Report, User Timeclock Detail Report , Server Performance Report, Administration Change Log, List Update Stats, User Stats, User Time Sheet, Download List, Dialer Inventory Report, Custom Reports Links, CallCard Search, Maximum System Stats, Maximum Stats Detail, Search Leads Logs, Email Log Report, Lists Pass Report, Called Counts List IDs Report, Front Page System Summary';
       if($id){
           $id = decode_url($id);
           $this->data['group'] = $this->vugroup_m->get_by(array('id' => $id), TRUE);
           count($this->data['group']) || $this->data['errors'][] = 'Group record could not find.';
           $this->data['listtitle'] = 'Edit User Group '.$this->data['group']->user_group;
       }else{
           $this->data['listtitle'] = 'Add New User Group';
           $this->data['group'] = $this->vugroup_m->get_new();
       }

       $this->form_validation->set_rules($this->vugroup_m->rules);

       if($this->form_validation->run() == TRUE){
           $post = $this->input->post();
           $data = $this->vugroup_m->array_from_post(array(
               'user_group', 'group_name', 'campaigns', 'admin_viewable_call_times'
           ));
           //$data['campaigns'][] = ' -ALL-CAMPAIGNS-';
           $data['allowed_campaigns'] .= ' ';
           $data['allowed_campaigns'] .= implode(' ', $data['campaigns']);
           $data['allowed_campaigns'] .= ' -';
           unset($data['campaigns']);
           $data['admin_viewable_call_times'] = implode(' ', $data['admin_viewable_call_times']);

           $groupId = $this->vugroup_m->save($data, $id);

           if($groupId){
               $gruoupData = array('agency_id' => $this->session->userdata('agency')->id,'vicidial_group_id' => $groupId);
               $group = $this->agroups_m->get_by(array('vicidial_group_id' => $groupId),TRUE);
               $id = NULL;
               if($group){
                   $id = $group->id;
               }
               $this->agroups_m->save($gruoupData,$id);
               $this->session->set_flashdata('success','User group saved successfully.');
               redirect('dialer/agroup/edit/'.encode_url($groupId));
           }else{
               $this->session->set_flashdata('error','Some thing went wrong.');
               redirect('dialer/agroup/edit/'.encode_url($groupId));
           }
       }

       $this->data['campaigns'] = $this->vcampaigns_m->getByAgencyId();
       $this->data['calltimes'] = $this->vcalltime_m->get();
       $this->template->load('agency','dialer/agency/group/edit',$this->data);
    }

    public function delete($id = NULL){
        if($id){
                $id = decode_url($id);
                $group = $this->agroups_m->get_by(array('vicidial_group_id' => $id),TRUE);
                $this->vugroup_m->delete($id);
                if($group){
                    $this->agroups_m->delete($group->id);
                }
                $this->session->set_flashdata('success','Agent Group deleted successfully.');
                redirect('dialer/agroup/index');
        }else{
                $this->session->set_flashdata('error','Agent Group record doesn\'t exist.');
                redirect('dialer/group/index');
        }
    }
    public function massaction(){
        $ids = $this->input->post('id');

        if(empty($ids)){
            $this->session->set_flashdata('error','No Agent Group Records have been selected.');
            redirect('dialer/agroup/index');
        }
        $action = $this->input->post('action');
        switch ($action){
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $group = $this->agroups_m->get_by(array('vicidial_group_id' => $id),TRUE);
                    if($group){
                        $this->agroups_m->delete($group->id);
                    }
                    $this->vugroup_m->delete($id);
                }
                $this->session->set_flashdata('success','Agent Group deleted successfully.');
                break;
        }
        redirect('dialer/sgroup/index');
    }
}
