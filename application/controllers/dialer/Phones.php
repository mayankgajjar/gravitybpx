<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Phones extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata("user")){
            redirect('login');
        }
        else{
            if($this->session->userdata("user")->group_name == 'Agent' || $this->session->userdata("user")->group_name == 'Agency'){
                redirect('/Forbidden');
            }
        }
        $this->data = array(
            "meta_title" => "Phones",
            "title" => "Phones",
            "breadcrumb" => "Phones",
            "formtitle" => "Phones",
            "listtitle" => "",
            "formactioncontroller" => "",
            "addactioncontroller" => "",
            "deleteactioncontroller" => "",
            "openparentsli" => "configuration",
            "activeparentsli" => "status_management",
            "deletetitle" => "Status",
            "datatablecontroller" => "statusmanagementcontroller/indexJson",
        );
        $this->load->library('vicidialdb');
        $this->load->model('vicidial/vusers_m','vusers_m');
        $this->load->model('vicidial/vugroup_m','vugroup_m');
        $this->load->model('vicidial/vphones_m','vphones_m');
        $this->load->model('vicidial/aphones_m','aphones_m');
        $this->load->model('agency_model');
        $this->load->model('agent_model');
        $this->load->model('user_model');
    }

    public function index(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert']= TRUE;
        $this->data['listtitle'] = 'Phone Listing';
        $this->template->load('admin',"dialer/admin/phones/list",$this->data);
    }


    public function indexjson(){
        $aColumns = array( 'id' , 'extension','fullname', 'dialplan_number', 'voicemail_id', 'active');
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


        $rResult = $this->vphones_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->vphones_m->query($sWhere);
        if($aFilterResult){
                $iFilteredTotal = count($aFilterResult);
        }else{
                $iFilteredTotal = 0;
        }
        $iTotal = count($this->vphones_m->get());

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
                            if($aColumns[$i] == 'id'){
                                    $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.encode_url($aRow['id']).'"/>';
                            }else{
                                $row[] = $aRow[ $aColumns[$i] ];
                            }
                        }
                        $row[] = '<a href="'.site_url('dialer/phones/edit/'.encode_url($aRow['id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/phones/delete/'.encode_url($aRow['id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

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
        $this->data['select2'] = TRUE;
        $this->data['meta_title'] = "Phones";
        $this->data['title'] = "Phones";
        $this->data['breadcrumb'] = "Phones";
        $this->data['templates'] = getTemplates();
        if($id){
            $id = decode_url($id);
            $this->data['phone'] = $this->vphones_m->get($id,TRUE);
            if(count($this->data['phone']) <= 0){
                redirect('dialer/phones/index');
            }
            count($this->data['phone']) || $this->data['errors'][] = 'Phone record could not be found.';
            $this->data['listtitle'] = "Edit Phone ".$this->data['phone']->extension;
        }else{
            redirect('dialer/phones/index');
        }

        $rules = $this->vphones_m->rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run() == TRUE){
            $data = $this->vphones_m->array_from_post(array(
                'extension', 'dialplan_number', 'voicemail_id', 'login', 'pass', 'conf_secret', 'active', 'template_id'
            ));
            $phoneId = $this->vphones_m->save($data, $id);
            if($phoneId){
                $this->session->set_flashdata('success','Phone saved successfully.');
                redirect('dialer/phones/edit/'.encode_url($phoneId));
            }
        }

        $this->template->load("admin","dialer/admin/phones/edit",$this->data);
    }

    public function delete($id = NULL){
        if($id){
                $id = decode_url($id);
                $this->vphones_m->delete($id);
                $phone = $this->aphones_m->get_by(array('vicidial_phone_id' => $id), TRUE);
                if($phone){
                    $this->aphones_m->delete($phone->id);
                }
                $this->session->set_flashdata('success','Phone record deleted successfully.');
                redirect('dialer/phones/index');
        }else{
                $this->session->set_flashdata('error','phone record doesn\'t exist.');
                redirect('dialer/phones/index');
        }
    }

    public function massaction(){
        $ids = $this->input->post('id');

        if(empty($ids))
        {
                $this->session->set_flashdata('error','No Phone Records have been selected.');
                redirect('dialer/phones/index');
        }
        $action = $this->input->post('action');
        switch ($action){
            case 'del':

                    foreach ($ids as $key => $id) {
                        $id = decode_url($id);
                        $this->vphones_m->delete($id);
                        $phone = $this->aphones_m->get_by(array('vicidial_phone_id' => $id), TRUE);
                        if($phone){
                            $this->aphones_m->delete($phone->id);
                        }

                    }
                    $this->session->set_flashdata('success','Phone deleted successfully.');
            break;
        }
        redirect('dialer/phones/index');
    }

    public function agencyindex(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert']= TRUE;
        $this->data['listtitle'] = 'Agency Phones Listing';
        $this->template->load('admin',"dialer/admin/phones/agency/list",$this->data);
    }

    public function agencyindexjson(){
        $aColumns = array( 'p.id' , 'name','extension','fullname', 'dialplan_number', 'voicemail_id', 'active');
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


        $rResult = $this->aphones_m->queryForAgency($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->aphones_m->queryForAgency($sWhere);
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
                            if($aColumns[$i] == 'p.id'){
                                $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.encode_url($aRow['id']).'"/>';
                            }elseif($aColumns[$i] == 'name'){
                                $row[] = '<a href="'.site_url('admin/manage_agency/agency_info/'.$aRow['agency_id']).'">'.$aRow['name'].'</a>';
                            }else{
                                $row[] = $aRow[ $aColumns[$i] ];
                            }
                        }
                        $row[] = '<a href="'.site_url('dialer/phones/edit/'.encode_url($aRow['id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/phones/delete/'.encode_url($aRow['id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

                        $output['aaData'][] = $row;
                }
        }else{
                $output['aaData'] =  array();
        }
        return $this->output
                    ->set_content_type('application/json')
                     ->set_output(json_encode($output));
    }

    public function agentndex(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert']= TRUE;
        $this->data['listtitle'] = 'Agent Phones Listing';
        $this->template->load('admin',"dialer/admin/phones/agent/list",$this->data);
    }

    public function agentindexjson(){
        $aColumns = array( 'p.id' , 'fname','extension','fullname', 'dialplan_number', 'voicemail_id', 'active');
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


        $rResult = $this->aphones_m->queryForAgent($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->aphones_m->queryForAgent($sWhere);
        if($aFilterResult){
                $iFilteredTotal = count($aFilterResult);
        }else{
                $iFilteredTotal = 0;
        }
        $iTotal = count( $aFilterResult);

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
                            if($aColumns[$i] == 'p.id'){
                                $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.encode_url($aRow['id']).'"/>';
                            }elseif($aColumns[$i] == 'fname'){
                                $row[] = '<a href="'.site_url('admin/manage_agent/agent_info/'.$aRow['agent_id']).'">'.$aRow['fname'].' '.$aRow['lname'].'</a>';
                            }else{
                                $row[] = $aRow[ $aColumns[$i] ];
                            }
                        }
                        $row[] = '<a href="'.site_url('dialer/phones/edit/'.encode_url($aRow['id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/phones/delete/'.encode_url($aRow['id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

                        $output['aaData'][] = $row;
                }
        }else{
                $output['aaData'] =  array();
        }
        return $this->output
                    ->set_content_type('application/json')
                     ->set_output(json_encode($output));
    }

    public function createphone($user_id = NULL){
        if($user_id){
            $lastId = $this->vphones_m->getLastInserted();
            $seq = $lastId + 1;
            $phoneData = array(
                'extension' => 'CRM'.$seq,
                'dialplan_number' => $seq,
                'voicemail_id' => $seq,
                'login' => 'crm'.$seq,
                'pass' => 'crm'.$seq,
                'conf_secret' => 'utyghujikoplit65',
                'active' => 'Y',
                'fullname' => 'CRM'.$seq
            );
            $default = $this->vphones_m->_default;
            $newPhoneData = array_merge($phoneData,$default);
            $phoneID = $this->vphones_m->save($newPhoneData);
            if($phoneID > 0){
                $this->db->set(array('vicidial_user_id' => $user_id , 'vicidial_phone_id' => $phoneID));
                $this->db->insert('users_phones');
                $this->session->set_flashdata('success','Phone created successfully.');
            }
            redirect('dialer/phones/edit/'.encode_url($phoneID));
        }
    }
}
