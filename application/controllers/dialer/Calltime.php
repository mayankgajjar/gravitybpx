<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calltime extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
        if(!$this->session->userdata("user"))
        {
            redirect('login');
        }
        else
        {
            if($this->session->userdata("user")->group_name == 'Agent' || $this->session->userdata("user")->group_name == 'Agency')
            {
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
		 $this->load->model('dcalltime_m');
		 $this->load->model('dcalltimestate_m');
		 $this->load->model('dcalltimeholiday_m');
		 $this->load->model('state_model');
	}
	/**
	 * call time listing page comes from this function.
	 * @return type
	 */
	public function index()
	{
		$data = $this->data;
		$this->data['datatable'] = TRUE;
		$this->data['sweetAlert'] = TRUE;
		$this->data['meta_title'] = 'Call Times';
		$this->data['title'] = 'Call Times';
		$this->data['breadcrumb'] = 'Call Times';
		$this->data['listtitle'] = "Call Times";
		//$this->data['calltimes'] = $this->dcalltime_m->get();
		$this->template->load('admin', 'dialer/admin/calltime/list',$this->data);
	}
	/**
	 * sorting, searching, pagination script for datatable.
	 * @return null
	 */
	public function indexJson()
	{
			$aColumns = array('id', 'call_time_id', 'call_time_name', 'ct_default_start', 'ct_default_stop');
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


			$rResult = $this->dcalltime_m->query($sWhere, $sOrder, $sLimit);

			$aFilterResult = $this->dcalltime_m->query($sWhere);
			if($aFilterResult){
				$iFilteredTotal = count($aFilterResult);
			}else{
				$iFilteredTotal = 0;
			}
			$iTotal = count($this->dcalltime_m->get());

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
						}else if($aColumns[$i] == 'parent_id'){
							$parent = $this->page_m->get_by(array('id' => $aRow['parent_id']),TRUE);
							if($parent)
								$row[] = $parent->title;
							else
								$row[] =  '';
						}else{
							$row[] = $aRow[ $aColumns[$i] ];
						}
					}
					$row[] = '<a href="'.site_url('dialer/calltime/edit/'.encode_url($aRow['id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/calltime/calltimedelete/'.encode_url($aRow['id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

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
	 *  calltime edit and add function
	 * @param type|null|int $id
	 * @return type
	 */
	public function edit($id = NULL)
	{
		$this->data['validation'] = TRUE;
		$this->data['select2'] = TRUE;
		$this->data['meta_title'] = "Call TimesCall Times";
		$this->data['title'] = "Call Times ";
		$this->data['breadcrumb'] = "Call Times";

		$rules = $this->dcalltime_m->rules;

		if ($id) {
			$id = decode_url($id);
			$this->data['calltime'] = $this->dcalltime_m->get($id);
			count($this->data['calltime']) || $this->data['errors'][] = 'Call time could not be found.';
			$this->data['listtitle'] = "Edit Call Time ".$this->data['calltime']->call_time_id;
			$this->data['stateRules'] = $this->dcalltimestate_m->get();
			$this->data['holidayRules'] = $this->dcalltimeholiday_m->get();
			$newRules = $this->dcalltime_m->rulesEdit;
			$rules = array_merge($rules, $newRules);
		}else{
			$rules['call_time_id']['rules'] .= '|is_unique[dialer_call_times.call_time_id]';
			$this->data['listtitle'] = "Add New Call Time";
			$this->data['calltime'] = $this->dcalltime_m->get_new();
		}


		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE) {
			if($id){
				$data = $this->dcalltime_m->array_from_post(array(
					'call_time_id', 'call_time_name', 'call_time_comments', 'ct_default_start', 'ct_default_stop', 'default_afterhours_filename_override', 'ct_sunday_start', 'ct_sunday_stop', 'sunday_afterhours_filename_override', 'ct_monday_start', 'ct_monday_stop', 'monday_afterhours_filename_override', 'ct_tuesday_start', 'ct_tuesday_stop', 'tuesday_afterhours_filename_override','ct_wednesday_start', 'ct_wednesday_stop', 'wednesday_afterhours_filename_override','ct_thursday_start', 'ct_thursday_stop', 'thursday_afterhours_filename_override', 'ct_friday_start', 'ct_friday_stop', 'friday_afterhours_filename_override', 'ct_saturday_start', 'ct_saturday_stop', 'saturday_afterhours_filename_override',
				));

				if($this->input->post('ct_state_call_times')){
					$data['ct_state_call_times'] =  implode(',', $this->input->post('ct_state_call_times'));
				}
				if($this->input->post('ct_holidays')){
					$data['ct_holidays'] =  implode(',', $this->input->post('ct_holidays'));
				}
		   }else{
				$data = $this->dcalltime_m->array_from_post(array(
					'call_time_id', 'call_time_name', 'call_time_comments'
				));
		   }
			$id = $this->dcalltime_m->save($data, $id);
			$this->session->set_flashdata('success','Call time save successfully.');
			redirect('dialer/calltime/edit/'.encode_url($id));
		}
		$this->template->load("admin","dialer/admin/calltime/edit",$this->data);
	}
	/**
	 * delete calltime data.
	 * @param type|null|int $id
	 * @return type
	 */
	public function calltimedelete($id = NULL)
	{
		if($id){
			$id = decode_url($id);
			$this->dcalltime_m->delete($id);
			$this->session->set_flashdata('success','Call Time deleted successfully.');
			redirect('dialer/calltime/index');
		}else{
			$this->session->set_flashdata('error','Call Time record doesn\'t exist.');
			redirect('dialer/calltime/index');
		}
	}
	/**
	 *  calltime massaction delete functionlaity.
	 * @return type
	 */
	public function calltimemassaction()
	{
		$ids = $this->input->post('id');

		if(empty($ids))
		{
			$this->session->set_flashdata('error','No Call Time Records have been selected.');
			redirect('dialer/calltime/index');
		}
		$action = $this->input->post('action');
		switch ($action)
		{
			case 'del':
				foreach ($ids as $key => $id) {
					$id = decode_url($id);
					$this->dcalltime_m->delete($id);
				}
				$this->session->set_flashdata('success','Call Time deleted successfully.');
				break;
		}
		redirect('dialer/calltime/index');
	}
	/**
	 * State call time listing page comes.
	 * @return type
	 */
	public function stateindex()
	{
		$data = $this->data;
		$this->data['datatable'] = TRUE;
		$this->data['sweetAlert'] = TRUE;
		$this->data['meta_title'] = 'State Call Time';
		$this->data['title'] = 'State Call Time';
		$this->data['breadcrumb'] = 'State Call Time';
		$this->data['listtitle'] = "State Call Times";
		//$this->data['calltimes'] = $this->dcalltimestate_m->get();
		$this->template->load('admin', 'dialer/admin/calltime/state/list',$this->data);
	}
	public function stateindexJson()
	{
			$aColumns = array('id', 'state_call_time_id', 'state_call_time_state', 'state_call_time_name', 'sct_default_start', 'sct_default_stop');
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


			$rResult = $this->dcalltimestate_m->query($sWhere, $sOrder, $sLimit);

			$aFilterResult = $this->dcalltimestate_m->query($sWhere);
			if($aFilterResult){
				$iFilteredTotal = count($aFilterResult);
			}else{
				$iFilteredTotal = 0;
			}
			$iTotal = count($this->dcalltimestate_m->get());

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
						}else if($aColumns[$i] == 'parent_id'){
							$parent = $this->page_m->get_by(array('id' => $aRow['parent_id']),TRUE);
							if($parent)
								$row[] = $parent->title;
							else
								$row[] =  '';
						}else{
							$row[] = $aRow[ $aColumns[$i] ];
						}
					}
					$row[] = '<a href="'.site_url('dialer/calltime/stateedit/'.encode_url($aRow['id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/calltime/statecalltimedelete/'.encode_url($aRow['id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

					$output['aaData'][] = $row;
				}
			}else{
				$output['aaData'] =  array();
			}
			return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
	}
	public function stateedit($id = NULL)
	{
		$this->data['validation'] = TRUE;
		$this->data['select2'] = TRUE;
		$this->data['meta_title'] = "State Call Times";
		$this->data['title'] = "State Call Times ";
		$this->data['breadcrumb'] = " State Call Times";
		$this->data['states'] = $this->state_model->getAll();
		$this->data['holidayRules'] = $this->dcalltimeholiday_m->get();

		$rules = $this->dcalltimestate_m->rules;

		if ($id) {
			$id = decode_url($id);
			$this->data['calltime'] = $this->dcalltimestate_m->get($id);
			count($this->data['calltime']) || $this->data['errors'][] = 'Call time could not be found.';
			$this->data['listtitle'] = "Edit Call Time ".$this->data['calltime']->state_call_time_id;
			$newRules = $this->dcalltimestate_m->rulesEdit;
			$rules = array_merge($rules, $newRules);
		}else{
			$rules['call_time_id']['rules'] .= '|is_unique[dialer_call_times.call_time_id]';
			$this->data['listtitle'] = "Add New State Call Time";
			$this->data['calltime'] = $this->dcalltimestate_m->get_new();
		}


		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE) {
			if($id){
				$data = $this->dcalltimestate_m->array_from_post(array(
					'state_call_time_id', 'state_call_time_state', 'state_call_time_name', 'state_call_time_comments', 'sct_default_start', 'sct_default_stop', 'sct_sunday_start', 'sct_sunday_stop',  'sct_monday_start', 'sct_monday_stop', 'sct_tuesday_start', 'sct_tuesday_stop', 'sct_wednesday_start', 'sct_wednesday_stop','sct_thursday_start', 'sct_thursday_stop','sct_friday_start', 'sct_friday_stop', 'sct_saturday_start', 'sct_saturday_stop', 
				));
				if($this->input->post('ct_holidays')){
					$data['ct_holidays'] =  implode(',', $this->input->post('ct_holidays'));
				}
		   }else{
				$data = $this->dcalltimestate_m->array_from_post(array(
					'state_call_time_id', 'state_call_time_name', 'state_call_time_comments', 'state_call_time_state'
				));
		   }
			$id = $this->dcalltimestate_m->save($data, $id);
			$this->session->set_flashdata('success','State Call time save successfully.');
			redirect('dialer/calltime/stateedit/'.encode_url($id));
		}
		$this->template->load("admin","dialer/admin/calltime/state/edit",$this->data);
	}
	public function statecalltimedelete($id = NULL)
	{
		if($id){
			$id = decode_url($id);
			$this->dcalltimestate_m->delete($id);
			$this->session->set_flashdata('success','State Call Time deleted successfully.');
			redirect('dialer/calltime/stateindex');
		}else{
			$this->session->set_flashdata('error','State Call Time record doesn\'t exist.');
			redirect('dialer/calltime/stateindex');
		}
	}
	public function statecalltimemassaction()
	{
		$ids = $this->input->post('id');
		if(empty($ids))
		{
			$this->session->set_flashdata('error','No State Call Time Records have been selected.');
			redirect('dialer/calltime/stateindex');
		}
		$action = $this->input->post('action');
		switch ($action)
		{
			case 'del':
				foreach ($ids as $key => $id) {
					$id = decode_url($id);
					$this->dcalltimestate_m->delete($id);
				}
				$this->session->set_flashdata('success','State Call Time deleted successfully.');
				break;
		}
		redirect('dialer/calltime/stateindex');
	}
	public function holidayindex()
	{
		$data = $this->data;
		$this->data['datatable'] = TRUE;
		$this->data['sweetAlert'] = TRUE;
		$this->data['meta_title'] = 'Holiday';
		$this->data['title'] = 'Holiday';
		$this->data['breadcrumb'] = 'Holiday';
		$this->data['listtitle'] = "Holiday";
		//$this->data['calltimes'] = $this->dcalltime_m->get();
		$this->template->load('admin', 'dialer/admin/calltime/holiday/list',$this->data);
	}
	public function holidayindexJson()
	{
			$aColumns = array('id',  'holiday_id','holiday_date', 'holiday_name', 'holiday_status',  'ct_default_start', 'ct_default_stop');
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


			$rResult = $this->dcalltimeholiday_m->query($sWhere, $sOrder, $sLimit);

			$aFilterResult = $this->dcalltimeholiday_m->query($sWhere);
			if($aFilterResult){
				$iFilteredTotal = count($aFilterResult);
			}else{
				$iFilteredTotal = 0;
			}
			$iTotal = count($this->dcalltimeholiday_m->get());

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
						}else if($aColumns[$i] == 'parent_id'){
							$parent = $this->page_m->get_by(array('id' => $aRow['parent_id']),TRUE);
							if($parent)
								$row[] = $parent->title;
							else
								$row[] =  '';
						}else{
							$row[] = $aRow[ $aColumns[$i] ];
						}
					}
					$row[] = '<a href="'.site_url('dialer/calltime/holidayedit/'.encode_url($aRow['id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/calltime/holidaydelete/'.encode_url($aRow['id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

					$output['aaData'][] = $row;
				}
			}else{
				$output['aaData'] =  array();
			}
			return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
	}	
	public function holidayedit($id = NULL)
	{
		$this->data['validation'] = TRUE;
		$this->data['datepicker'] = TRUE;
		$this->data['meta_title'] = "Holiday";
		$this->data['title'] = "Holiday";
		$this->data['breadcrumb'] = "Holiday";

		$rules = $this->dcalltimeholiday_m->rules;

		if ($id) {
			$id = decode_url($id);
			$this->data['calltime'] = $this->dcalltimeholiday_m->get($id);
			count($this->data['calltime']) || $this->data['errors'][] = 'Call time could not be found.';
			$this->data['listtitle'] = "Edit Call Time ".$this->data['calltime']->holiday_id;
			$newRules = $this->dcalltimeholiday_m->rulesEdit;
			$rules = array_merge($rules, $newRules);
		}else{
			$rules['call_time_id']['rules'] .= '|is_unique[dialer_call_times.call_time_id]';
			$this->data['listtitle'] = "Add New Call Time";
			$this->data['calltime'] = $this->dcalltimeholiday_m->get_new();
		}


		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE) {
			if($id){
				$data = $this->dcalltimeholiday_m->array_from_post(array(
					'holiday_id', 'holiday_name', 'holiday_comments', 'ct_default_start', 'ct_default_stop', 'default_afterhours_filename_override', 'holiday_date', 'holiday_status'
				));
		   }else{
				$data = $this->dcalltimeholiday_m->array_from_post(array(
					'holiday_id', 'holiday_name', 'holiday_comments', 'holiday_date'
				));
		   }
			$id = $this->dcalltimeholiday_m->save($data, $id);
			$this->session->set_flashdata('success','Holiday save successfully.');
			redirect('dialer/calltime/holidayedit/'.encode_url($id));
		}
		$this->template->load("admin","dialer/admin/calltime/holiday/edit",$this->data);
	}
	public function holidaydelete($id = NULL)
	{
		if($id){
			$id = decode_url($id);
			$this->dcalltimeholiday_m->delete($id);
			$this->session->set_flashdata('success','Holiday deleted successfully.');
			redirect('dialer/calltime/holidayindex');
		}else{
			$this->session->set_flashdata('error','Holiday record doesn\'t exist.');
			redirect('dialer/calltime/holidayindex');
		}
	}
	public function holidaymassaction()
	{
		$ids = $this->input->post('id');
		if(empty($ids))
		{
			$this->session->set_flashdata('error','No Holiday Records have been selected.');
			redirect('dialer/calltime/holidayindex');
		}
		$action = $this->input->post('action');
		switch ($action)
		{
			case 'del':
				foreach ($ids as $key => $id) {
					$id = decode_url($id);
					$this->dcalltimeholiday_m->delete($id);
				}
				$this->session->set_flashdata('success','Holiday deleted successfully.');
				break;
		}
		redirect('dialer/calltime/holidayindex');
	}
}