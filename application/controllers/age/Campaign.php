<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agency') {
                redirect('/Forbidden');
            }
        }
		$this->load->model('campaign_m');
        $this->load->model('filter_m');
        $this->load->model('vertical_m');
        $this->load->model('bid_m');
        $this->load->model('agents');
        $this->load->model('State_model');
	}

	public function index()
	{
        $this->data['datatable'] = TRUE;
		$this->data['sweetAlert'] = TRUE;
		$this->data['title'] = 'Agent | Campaign';
		$this->template->load('agency','campaign/list_campaign',$this->data);
	}

	public function indexjson(){

        $table = 'lead_campaign lc';
        $aColumns = array('campaign_id','lc.name','a.fname','a.lname','age.name','lcc.cat_name','lc.auct_type','lc.daily_budget','lc.max_cost','lc.active');    
        $bColumns = array('campaign_id','name','agent_name','agency_name','cat_name','auct_type','daily_budget','max_cost','active');
        $relation = array(
            "fields" => 'campaign_id,lc.name,CONCAT(a.fname," ",a.lname) as agent_name,age.name as agency_name,lcc.cat_name,lc.auct_type,lc.daily_budget,lc.max_cost,lc.active',
            "JOIN" => array(
                    array(
                        "table" => 'agents a',
                        "condition" => 'lc.user_id = a.id ',
                        "type" => 'LEFT'
                    ),
                    array(
                        "table" => 'agencies age',
                        "condition" => 'a.agency_id = age.id ',
                        "type" => 'FULL'
                    ),
                    array(
                        "table" => 'lead_campaign_category lcc',
                        "condition" => 'lc.campcat = lcc.id ',
                        "type" => 'LEFT'
                    ),
            ),
        );

        /** Ordering */
        if (isset($_GET['iSortCol_0'])) {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $relation['ORDER_BY']['field'] = $aColumns[$i];
                    $relation['ORDER_BY']['order'] = $_GET['sSortDir_' . $i];
                }
            }
        }

        // /*
        //  * Filtering
        //  * NOTE this does not match the built-in DataTables filtering which does it
        //  * word by word on any field. It's possible to do here, but concerned about efficiency
        //  * on very large tables, and MySQL's regex functionality is very limited
        //  */
        $sWhere = "age.id = ".$this->session->userdata('agency')->id." AND lc.is_archive = 0";
        if ($_GET['sSearch'] != "") {
            
           $sWhere .= " AND (";    
           for ($i = 0; $i < count($aColumns); $i++) {                
                    $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
            
        }
        $relation['conditions'] = $sWhere;

        $aFilterResult = $this->campaign_m->get_relation($table,$relation); 
        /** Paging */
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $relation['LIMIT']['start'] = $_GET['iDisplayLength'];
            $relation['LIMIT']['end'] = $_GET['iDisplayStart'];
        }
        
        $rResult = $this->campaign_m->get_relation($table,$relation);

        if ($aFilterResult) {
            $iFilteredTotal = count($aFilterResult);
        } else {
            $iFilteredTotal = 0;
        }
        $iTotal = $iFilteredTotal;

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

                for ($i = 0; $i < count($bColumns); $i++) {
                       if($bColumns[$i] == 'campaign_id'){
                            $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="' . encode_url($aRow['campaign_id']) . '"/>';
                        }
                        elseif($bColumns[$i] == 'daily_budget' || $bColumns[$i] == 'max_cost'){
                            $row[] = isset($aRow[$bColumns[$i]]) ? toMoney($aRow[$bColumns[$i]]) : '';
                        }
                        elseif($bColumns[$i] == 'auct_type'){
                             $auction = array('live_transfer' => 'Live Transfer','data' => 'Data');
                             $auct_type = $aRow[$bColumns[$i]];
                             $row[] = isset($aRow[$bColumns[$i]]) ? $auction[$auct_type] : '';
                        }
                        elseif($bColumns[$i] == 'active'){
                            if(isset($aRow[$bColumns[$i]]) && $aRow[$bColumns[$i]] == '1'){
                                $row[] = '<span class="label label-success">Active</span>';
                            }else{
                                $row[] = '<span class="label label-danger">Paused</span>';
                            }
                        }
                        else{
                            $row[] = isset($aRow[$bColumns[$i]]) ? $aRow[$bColumns[$i]] : '';
                        }
                }
                 $row[] = '<a href="' . site_url('age/campaign/edit/'. encode_url($aRow['campaign_id'])) . '" title="Edit"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="' . site_url('age/campaign/delete/'.encode_url($aRow['campaign_id'])) . '" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="' . site_url('age/campaign/archive/'.encode_url($aRow['campaign_id'])) . '" title="Archive"><i class="fa fa-archive" aria-hidden="true"></i></a>';

                $output['aaData'][] = $row;
            }
        } else {
            $output['aaData'] = array();
        }
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
        
    }


    public function archiveindex()
    {
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['title'] = 'Agency | Archive Campaign';
        $this->template->load('agency','campaign/list_archive_campaign',$this->data);
    }

    public function archiveindexjson(){

        // $aColumns = array('campaign_id','lc.name','a.fname','a.lname','age.name','lcc.cat_name','lc.auct_type','lc.daily_budget','lc.max_cost','lc.active');
        
         $table = 'lead_campaign lc';
         $aColumns = array('campaign_id','lc.name','a.fname','a.lname','age.name','lcc.cat_name','lc.auct_type','lc.daily_budget','lc.max_cost','lc.active');    
         $bColumns = array('campaign_id','name','agent_name','agency_name','cat_name','auct_type','daily_budget','max_cost','active');
         $relation = array(
            "fields" => 'campaign_id,lc.name,CONCAT(a.fname," ",a.lname) as agent_name,age.name as agency_name,lcc.cat_name,lc.auct_type,lc.daily_budget,lc.max_cost,lc.active',
            "JOIN" => array(
                    array(
                        "table" => 'agents a',
                        "condition" => 'lc.user_id = a.id ',
                        "type" => 'LEFT'
                    ),
                    array(
                        "table" => 'agencies age',
                        "condition" => 'a.agency_id = age.id ',
                        "type" => 'FULL'
                    ),
                    array(
                        "table" => 'lead_campaign_category lcc',
                        "condition" => 'lc.campcat = lcc.id ',
                        "type" => 'LEFT'
                    ),
            ),
        );

        /** Ordering */
        if (isset($_GET['iSortCol_0'])) {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $relation['ORDER_BY']['field'] = $aColumns[$i];
                    $relation['ORDER_BY']['order'] = $_GET['sSortDir_' . $i];
                }
            }
        }

        // /*
        //  * Filtering
        //  * NOTE this does not match the built-in DataTables filtering which does it
        //  * word by word on any field. It's possible to do here, but concerned about efficiency
        //  * on very large tables, and MySQL's regex functionality is very limited
        //  */
        $sWhere = "age.id = ".$this->session->userdata('agency')->id." AND lc.is_archive = 1";
        if ($_GET['sSearch'] != "") {
            
           $sWhere .= " AND (";    
           for ($i = 0; $i < count($aColumns); $i++) {                
                    $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
            
        }
        $relation['conditions'] = $sWhere;

        $aFilterResult = $this->campaign_m->get_relation($table,$relation); 
        /** Paging */
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $relation['LIMIT']['start'] = $_GET['iDisplayLength'];
            $relation['LIMIT']['end'] = $_GET['iDisplayStart'];
        }
        
        $rResult = $this->campaign_m->get_relation($table,$relation);
        if ($aFilterResult) {
            $iFilteredTotal = count($aFilterResult);
        } else {
            $iFilteredTotal = 0;
        }
        $iTotal = $iFilteredTotal;

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

                for ($i = 0; $i < count($bColumns); $i++) {
                       if($bColumns[$i] == 'campaign_id'){
                            $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="' . encode_url($aRow['campaign_id']) . '"/>';
                        }
                        elseif($bColumns[$i] == 'daily_budget' || $bColumns[$i] == 'max_cost'){
                            $row[] = isset($aRow[$bColumns[$i]]) ? toMoney($aRow[$bColumns[$i]]) : '';
                        }
                        elseif($bColumns[$i] == 'auct_type'){
                             $auction = array('live_transfer' => 'Live Transfer','data' => 'Data');
                             $auct_type = $aRow[$bColumns[$i]];
                             $row[] = isset($aRow[$bColumns[$i]]) ? $auction[$auct_type] : '';
                        }
                        elseif($bColumns[$i] == 'active'){
                            if(isset($aRow[$bColumns[$i]]) && $aRow[$bColumns[$i]] == '1'){
                                $row[] = '<span class="label label-success">Active</span>';
                            }else{
                                $row[] = '<span class="label label-danger">Paused</span>';
                            }
                        }
                        else{
                            $row[] = isset($aRow[$bColumns[$i]]) ? $aRow[$bColumns[$i]] : '';
                        }
                }
                 $row[] = '<a class="delete" href="' . site_url('age/campaign/delete/'.encode_url($aRow['campaign_id'])) . '" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>&nbsp;&nbsp;<a href="' . site_url('age/campaign/unarchive/'.encode_url($aRow['campaign_id'])) . '" title="Unarchive"><i class="fa fa-archive" aria-hidden="true"></i></a>';

                $output['aaData'][] = $row;
            }
        } else {
            $output['aaData'] = array();
        }
        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
        
    }


	public function edit($id = NULL)
	{
		$this->data['validation'] = TRUE;
        $this->data['meta_title'] = "Campaign Operation";

        /* set variable to include javascript */
        $this->data['statechart']     = TRUE;
        $this->data['rangeslider']    = TRUE;
        $this->data['taginput']       = TRUE;
        $this->data['formwizard']     = TRUE;       
        $this->data['statechart']     = TRUE;
        $this->data['sweetAlert']     = TRUE;

        $this->data['pre_filters']    = $this->filter_m->get_by(array('filter_group' => 'precision'));
        $this->data['aff_filters']    = $this->filter_m->get_by(array('filter_group' => 'affordability'));

        $this->data['buyers'] = $this->agents->get_by(array('agency_id' => $this->session->userdata('agency')->id));

        if($id){
            $id = decode_url($id);
            $this->data['campaign'] = $this->campaign_m->get_by(array('campaign_id' => $id), TRUE);
            count($this->data['campaign']) || $this->data['errors'][] = "Unable to find campaign.";         
            $this->data['listtitle'] = "Edit Campaign";
        }else{
            $this->data['listtitle'] = "Add A New Campaign";      
            $this->data['campaign'] = $this->campaign_m->get_new();
        }
       
        
        $rules = $this->campaign_m->rules_admin;
        $this->form_validation->set_rules($rules);

        if($this->form_validation->run() == true){    
            // echo "<pre>";print_r($_POST);die;  
            $data = $this->campaign_m->array_from_post(array(
                'campcat','auct_type','bid_id','user_id','name','descr','max_cost','delivery_phone','lead_throtle','daily_budget','delivery_email'
            ));

            if($this->input->post('active') == 'on'){
                $data['active'] = 1; 
            }else{
                $data['active'] = 0; 
            }
            if( $this->input->post('custom_schedule') == 'on' ){
                $data['ref_schedule'] = serialize($this->input->post('schedule_time'));             
            }else{
                $data['ref_schedule'] = '';
            }
            if($this->input->post('location-switch') == 'state' && $this->input->post('state')){
                $data['ref_states'] = implode(',',$this->input->post('state')); 
                $data['ref_zipcodes'] = '';
            }else{
                $data['ref_states'] = '';
                $data['ref_zipcodes'] = $this->input->post('ref_zipcodes'); 
            }
            $data['filters'] = serialize($this->input->post('filters'));
            
            $id = $this->campaign_m->save($data, $id);          
            $this->session->set_flashdata('success','Campaign successfully saved.');
            redirect('age/campaign');                     
        }           
		// Load the view	
		$this->template->load('agency','campaign/edit_campaign',$this->data);	
	}	

	public function delete($id)
	{
		if ($id) {
            $id = decode_url($id);
            $this->campaign_m->delete($id);            
            $this->session->set_flashdata('success','Campaign deleted successfully.');
        } else {
            $this->session->set_flashdata('error','Campaign doesn\'t exist.');
        }
        redirect('age/campaign');	

	}

	public function massaction()
	{
		$ids = $this->input->post('id');
		if(empty($ids))
		{
			$this->session->set_flashdata('error','No Campaign id selected.');
			redirect('age/campaign');
		}
		$action = $this->input->post('action');
		switch ($action) 
		{
			case 'del':
				foreach ($ids as $key => $id) {
					$id = decode_url($id);
					$this->campaign_m->delete($id);											
				}
				$this->session->set_flashdata('success','Campaign ids deleted successfully.');
				break;							
		}			
		redirect('age/campaign');	
	}	

    /**
     * make campaign in archive
     * @param type|null $id 
     * @return type
     */
    public function archive($id  = NULL)
    {
        if($id != NULL){
            $id = decode_url($id);
            $data = array('is_archive' => '1' );
            $this->campaign_m->save($data, $id);
            $this->session->set_flashdata('success','Campaign successfully archived.');
        }else{
            $this->session->set_flashdata('error','No Campaign id found.');                     
        }
        redirect('age/campaign/archiveindex');      
    }
    /**
     * make campaign unarchive
     * @param type|null $id 
     * @return type
     */
    public function unarchive($id  = NULL)
    {
        if($id != NULL){
            $id = decode_url($id);
            $data = array('is_archive' => '0' );
            $this->campaign_m->save($data, $id);
            $this->session->set_flashdata('success','Campaign successfully removed from archived.');
        }else{
            $this->session->set_flashdata('error','No Campaign id found.');                     
        }
        redirect('age/campaign');       
    }

    /**
     * get the bids and auctions available in selected vertical
     * @return json string
     */
    public function checkvertical()
    {
        
        $isAjax = $this->input->post('isAjax');
        if($isAjax == 'true'){
          $vertical = $this->vertical_m->get($this->input->post('vertical'),TRUE);
          $result['auctions'] = explode(',', $vertical->auctions);
          $result['bid'] = explode(',', $vertical->bid);
          $result['filters'] = unserialize($vertical->filters);
          //$filterHtml = $this->load->view('agency/filter/campaignfilter',$data, TRUE);       
          //$result['html'] = $filterHtml;
          echo json_encode($result);              
        }
        exit;       
    }

    /**
     * lead email example
     * @return json string
     */
    public function testemail()
    {
        $this->load->model('emailtemplate_m');
        $isAjax = $this->input->post('isAjax');         
        if($isAjax){
            $mails  = explode(',',$this->input->post('mails'));     
            foreach ($mails as $key => $mail) {
                /* send mail to user */
                $template = $this->emailtemplate_m->get_by(array('event' => 'test_lead'),TRUE);         
                $subject = $template->subject;              
                $html = $template->body;
                $data = array(
                    'vertical'          => $this->input->post('vertical'),
                    'auction'           => $this->input->post('aucttype'),                  
                    'm/d/y'             => date('m/d/Y'),
                    'customerName'      => 'Shipper',            
                    'customerPhone'     => '(999) 999-9999',
                    'customerEmail'     => 'admin@lead.com',
                    'customerCity'      => 'San Deigo',
                    'customerState'     => 'CA',
                    'customerZip'       => '90210',
                    'customerSex'       => 'Male',
                    'customerDob'       => '07/01/1980',
                    'customerAge'       => '35 years old',
                    'customerHeight'    => '5\' 6"',
                    'customerWeight'    => '170lbs.',
                    'customerHousehold' => '1',
                    'customerMed'       => 'None',
                    'customerPregnant'  => 'No',
                    'customerTobacco'   => 'No',
                    'customerIncome'    => 'Unknown',
                    'customerTimeframe' => 'Not Sure',
                    'customerLifeevent' => 'None',
                    'customerNotes'     => 'None',
                );
                $subject = $this->parser->parse_string($subject, $data, TRUE);                  
                $message = $this->parser->parse_string($html, $data, TRUE);             
                
                $this->load->model('email_model');                          
                $res=$this->email_model->mail_send($subject, $mail,$message);  
            }
            // echo $res;die;
            echo json_encode($mails);   
        }
    }
}