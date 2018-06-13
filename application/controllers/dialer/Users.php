<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller{

    public function __construct(){
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
            "meta_title" => "Users",
            "title" => "Users",
            "breadcrumb" => "Users",
            "formtitle" => "Users",
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
        $this->load->model('vicidial/vinagent_m', 'vinagent_m');
        $this->load->model('agency_model');
        $this->load->model('agent_model');
        $this->load->model('user_model');
    }
    /**
     * [index description]
     * @return [type] [description]
     */
    public function index(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert']= TRUE;
        $this->data['listtitle'] = 'User Listing';
        $this->template->load('admin',"dialer/admin/users/list",$this->data);
    }
    /**
     * [indexjson description]
     * @return [type] [description]
     */
    public function indexjson(){
        $aColumns = array( 'user_id' , 'user', 'full_name', 'user_level', 'user_group', 'active');
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


        $rResult = $this->vusers_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->vusers_m->query($sWhere);
        if($aFilterResult){
                $iFilteredTotal = count($aFilterResult);
        }else{
                $iFilteredTotal = 0;
        }
        $iTotal = count($this->vusers_m->get());

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
                            if($aColumns[$i] == 'user_id'){
                                    $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.encode_url($aRow['user_id']).'"/>';
                            }else{
                                $row[] = $aRow[ $aColumns[$i] ];
                            }
                        }
                        $row[] = '<a href="'.site_url('dialer/users/edit/'.encode_url($aRow['user_id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/users/delete/'.encode_url($aRow['user_id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

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
     * [edit description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($id=NULL){
        $this->data['validation'] = TRUE;
        $this->data['formtitle'] = 'Users';
        $this->data['groups'] = $this->vugroup_m->get();
        $rules = $this->vusers_m->rules;
        if($id){
            $id = decode_url($id);
            $this->data['user'] = $this->vusers_m->get_by(array('user_id' => $id), TRUE);
            count($this->data['user']) || $this->data['errors'][] = 'User could not find.';
            $this->data['listtitle'] = 'Edit User '.$this->data['user']->user;
            $rules['pass']['rules'] = 'trim';
            $agencyId = getAgncyFromUserId($this->data['user']->user_id);
            $this->data['groups'] =  getAgencyGroup($agencyId);
            $this->data['ingroups'] = getInboundGroupsForUser($agencyId);
            $this->data['inagents'] = $this->vinagent_m->get_by_array(array('user' => $this->data['user']->user));
        }else{
            $this->data['listtitle'] = 'Add New User';
            $this->data['user'] = $this->vusers_m->get_new();
            $this->data['ingroups'] = getInboundGroupsForUser();
            $this->data['inagents'] = array();
        }
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run() == TRUE){
            $data = $this->vusers_m->array_from_post(array(
                'email', 'pass', 'full_name', 'user_level', 'active', 'user_group',
            ));
            if(!$id){
                $data['user'] = clean($data['email']);
            }
            if( isset($data['pass']) && $data['pass'] == ''){
                unset($data['pass']);
            }
            $other = $this->vusers_m->roles[$data['user_level']];
            $newData = array_merge($data, $other);
            $userId = $this->vusers_m->save($newData,$id);
            if($userId){
                foreach($this->input->post('ingroup') as $ingroup){
                    if(strlen($this->data['user']->user) > 0){
                        $user = $this->data['user']->user;
                    }else{
                        $user = $userId;
                    }
                    $group_id = $ingroup;
                    $group_rank = $this->input->post('RANK_'.$ingroup);
                    $group_grade = $this->input->post('GRADE_'.$ingroup);
                    $group_web_vars = $this->input->post('WEB_'.$ingroup);
                    $vinagent = $this->vinagent_m->get_by(array('group_id' => $group_id,'user' => $user),TRUE);
                    $vId = NULL;
                    if($vinagent){
                        $vId = $vinagent->id;
                    }
                    $data = array('user' => $user, 'group_id' => $group_id, 'group_rank' => $group_rank, 'group_grade' => $group_grade, 'group_web_vars' => $group_web_vars );
                    $this->vinagent_m->save($data, $vId);
                }
                $this->session->set_flashdata('success','User saved successfully.');
                redirect('dialer/users/edit/'.encode_url($userId));
            }else{
                $this->session->set_flashdata('error','Some thing went wrong.');
                redirect('dialer/users/edit/'.encode_url($id));
            }
        }

        $this->template->load('admin','dialer/admin/users/edit',$this->data);
    }
    /**
     * [delete description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id = NULL){
        if($id){
                $id = decode_url($id);

                $this->db->set(array('vicidial_user_id' => 0));
                $this->db->where('vicidial_user_id', $id);
                $this->db->update('agencies');
                $this->db->set(array('vicidial_user_id' => 0));
                $this->db->where('vicidial_user_id', $id);
                $this->db->update('agents');

                $this->vusers_m->delete($id);
                $this->session->set_flashdata('success','User deleted successfully.');
                redirect('dialer/users/index');
        }else{
                $this->session->set_flashdata('error','User record doesn\'t exist.');
                redirect('dialer/users/index');
        }
    }
    /**
     * [massaction description]
     * @return [type] [description]
     */
    public function massaction(){
        $ids = $this->input->post('id');
        if(empty($ids)){
            $this->session->set_flashdata('error','No User Records have been selected.');
            redirect('dialer/users/index');
        }
        $action = $this->input->post('action');
        switch ($action){
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $this->vusers_m->delete($id);
                    $this->db->set(array('vicidial_user_id' => 0));
                    $this->db->where('vicidial_user_id', $id);
                    $this->db->update('agencies');
                    $this->db->set(array('vicidial_user_id' => 0));
                    $this->db->where('vicidial_user_id', $id);
                    $this->db->update('agents');
                }
                $this->session->set_flashdata('success','User deleted successfully.');
                break;
        }
        redirect('dialer/users/index');
    }
    /**
     * [_unique_email description]
     * @param  [type] $email [description]
     * @return [type]        [description]
     */
    public function _unique_email($email){
        $id = $this->uri->segment(4);
        $id = decode_url($id);
        $this->vicidialdb->db->where('email',$this->input->post('email'));
        !$id || $this->vicidialdb->db->where(' user_id!=', $id);
        $user = $this->vicidialdb->db->get('vicidial_users')->result();

        if(count($user)){
            $this->form_validation->set_message('_unique_email','%s should be unique.');
            return FALSE;
        }
        return TRUE;
    }
    /**
     * [createagency description]
     * @param  [type] $agencyId [description]
     * @return [type]           [description]
     */
    public function createagency($agencyId =NULL){
        if($agencyId){
            $agency = $this->agency_model->getAgencyInfo($agencyId);
            if(!$agency){
                $this->session->set_flashdata('error','Agency not exists.');
                redirect('admin/manage_agency/view');
            }
            //$user = $this->user_model->getAgencyFromUser_id($agency->user_id);
            $data = array(
                'id' => $agency->id,
                'name' => $agency->name,
                'password' => clean(base64_decode($agency->password)),
                'email' => $agency->email_id,
                'user'  => 'agency'.$agency->id
            );
            $res = $this->vusers_m->addAgencyFromCrm($data);
            if($res){
                $this->session->set_flashdata('success','Dialer user created successfully.');
            }
        }else{
            $this->session->set_flashdata('error','Agency id not find.');
        }
        redirect('admin/agencyindex');
    }
    /**
     * [createagent description]
     * @param  [type] $agentId [description]
     * @return [type]          [description]
     */
    public function createagent($agentId =NULL){
        if($agentId){
            $agent = $this->agent_model->getAgentInfo($agentId);
            if(!isset($agent->id) && $agent->id > 0){
                $this->session->set_flashdata('msg','Agent does not exists.');
                redirect('admin/manage_agent/view');
            }
            //$user = $this->user_model->getAgencyFromUser_id($agency->user_id);
            $data = array(
                'id' => $agent->id,
                'name' => $agent->fname.' '.$agent->lname,
                'password' => clean(base64_decode($agent->password)),
                'email' => $agent->email_id,
                'user'  => 'agent'.$agent->id
            );
            $res = $this->vusers_m->addAgentFromCrm($data);
            if($res){
                $this->session->set_flashdata('success','Dialer user created successfully.');
            }
        }else{
            $this->session->set_flashdata('msg','Agent id does not exists.');
        }
        redirect('admin/agentindex');
    }
    /**
     * [agencyindex description]
     * @return [type] [description]
     */
    public function agencyindex(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert']= TRUE;
        $this->data['listtitle'] = 'Agency User Listing';
        $this->template->load('admin',"dialer/admin/users/agency/list",$this->data);
    }
    /**
     * [agencyindexjson description]
     * @return [type] [description]
     */
    public function agencyindexjson(){
        $aColumns = array( 'user_id','user','name', 'full_name', 'user_level', 'user_group', 'active');
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
                $newColumns = $aColumns;
                unset($newColumns[0]);
                unset($newColumns[3]);
                $newColumns = array_values($newColumns);
                for ( $i=0 ; $i<count($newColumns) ; $i++ )
                {
                        $sWhere .= $newColumns[$i]." LIKE '%". $_GET['sSearch']."%' OR ";
                }
                $sWhere = substr_replace( $sWhere, "", -3 );
                $sWhere .= ') ';
        }


        $rResult = $this->vusers_m->queryForAgency($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->vusers_m->queryForAgency($sWhere);
        if($aFilterResult){
                $iFilteredTotal = count($aFilterResult);
        }else{
                $iFilteredTotal = 0;
        }
        $iTotal = count($this->vusers_m->queryForAgency($sWhere));

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
                            if($aColumns[$i] == 'user_id'){
                                $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.encode_url($aRow['user_id']).'"/>';
                            }elseif($aColumns[$i] == 'name'){
                                $row[] = '<a href="'.site_url('admin/manage_agency/agency_info/'.$aRow['id']).'">'.$aRow['name'].'</a>';
                            }else{
                                $row[] = $aRow[ $aColumns[$i] ];
                            }
                        }
                        $row[] = '<a href="'.site_url('dialer/users/edit/'.encode_url($aRow['user_id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/users/delete/'.encode_url($aRow['user_id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

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
     * [agentindex description]
     * @return [type] [description]
     */
    public function agentindex(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert']= TRUE;
        $this->data['listtitle'] = 'Agent User Listing';
        $this->template->load('admin',"dialer/admin/users/agent/list",$this->data);
    }
    /**
     * [agentindexjson description]
     * @return [type] [description]
     */
    public function agentindexjson(){
        $aColumns = array( 'user_id','user','age.fname', 'full_name','name', 'user_level', 'user_group', 'active');
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
                $newColumns = $aColumns;
                unset($newColumns[0]);
                unset($newColumns[3]);
                $newColumns = array_values($newColumns);
                for ( $i=0 ; $i<count($newColumns) ; $i++ )
                {
                        $sWhere .= $newColumns[$i]." LIKE '%". $_GET['sSearch']."%' OR ";
                }
                $sWhere = substr_replace( $sWhere, "", -3 );
                $sWhere .= ') ';
        }


        $rResult = $this->vusers_m->queryForAgent($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->vusers_m->queryForAgent($sWhere);
        if($aFilterResult){
                $iFilteredTotal = count($aFilterResult);
        }else{
                $iFilteredTotal = 0;
        }
        $iTotal = count($this->vusers_m->queryForAgent($sWhere));

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
                            if($aColumns[$i] == 'user_id'){
                                $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.encode_url($aRow['user_id']).'"/>';
                            }elseif($aColumns[$i] == 'name'){
                                $row[] = '<a href="'.site_url('admin/manage_agency/agency_info/'.$aRow['agency_id']).'">'.$aRow['name'].'</a>';
                            }elseif($aColumns[$i] == 'age.fname'){
                                $row[] = '<a href="'.site_url('admin/manage_agent/agent_info/'.$aRow['id']).'">'.$aRow['fname'].' '.$aRow['lname'].'</a>';
                            }else{
                                $row[] = $aRow[ $aColumns[$i] ];
                            }
                        }
                        $row[] = '<a href="'.site_url('dialer/users/edit/'.encode_url($aRow['user_id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/users/delete/'.encode_url($aRow['user_id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

                        $output['aaData'][] = $row;
                }
        }else{
                $output['aaData'] =  array();
        }
        return $this->output
                    ->set_content_type('application/json')
                     ->set_output(json_encode($output));
    }
}
