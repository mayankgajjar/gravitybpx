<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filter extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Admin') {
                redirect('/Forbidden');
            }
        }
		$this->load->model('filter_m');
	}

	public function index()
	{
		$this->data['datatable'] = TRUE;
		$this->data['sweetAlert'] = TRUE;
		$this->data['title'] = 'Admin | Campaign Filter';
		$this->template->load('admin','campaign/filter/list_filter',$this->data);
	}

	 public function indexjson(){
        $aColumns = array('filter_id', 'name','filter_label','filter_group');
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
        if ($_GET['sSearch'] != "") {
        	$sWhere = "WHERE (";    
           for ($i = 0; $i < count($aColumns); $i++) {                
                    $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
                
        $rResult = $this->filter_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->filter_m->query($sWhere);
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

                for ($i = 0; $i < count($aColumns); $i++) {
                        if($aColumns[$i] == 'filter_id'){
                            $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="' . encode_url($aRow['filter_id']) . '"/>';
                        }
                        elseif($aColumns[$i] == 'filter_group'){
                            if($aRow['filter_group'] == 'precision'){
                                $row[] = "Precision Targeting";
                            }else{
                                $row[] = "Affordability Filters";
                            }
                        }
                        else{
                            $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                        }
                }
                 $row[] = '<a href="' . site_url('adm/filter/edit/'. encode_url($aRow['filter_id'])) . '"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="' . site_url('adm/filter/delete/'.encode_url($aRow['filter_id'])) . '"><i class="fa fa-trash" aria-hidden="true"></i></i>';

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
		$this->data['meta_title'] = "Filter Operation";
		if($id){
			$id = decode_url($id);
            $this->data['filter'] = $this->filter_m->get_by(array('filter_id' => $id), TRUE);
            count($this->data['filter']) || $this->data['errors'][] = 'Filter could not be found';            
            $this->data['listtitle'] = "Edit Filter";
            // $this->data['requiredJson'] = $this->filter_m->getRequiredFieldJson($id);
		}else{	
			$this->data['listtitle'] = "Add A New Filter";		
			$this->data['filter'] = $this->filter_m->get_new();
		}

		$rules = $this->filter_m->rules;	
		
		/* For check is unique validation */
		// if($id == '' || $this->data['filter']->name != $this->input->post('name')){
		// 	$rules['name']['rules'] = $rules['name']['rules']."|is_unique[lead_campaign_filter.name]";
		// }	
		/* End For check is unique validation */
		

		$this->form_validation->set_rules($rules);

		if( $this->form_validation->run() == TRUE){
			$data = $this->filter_m->array_from_post(array(
					'name','filter_group','filter_type','filter_label','filter_value','note','options'
				));	

            $optionsPost = $this->input->post('options');
            $options = array(); 
            foreach ($optionsPost['label'] as $key => $value) {
                if( isset($optionsPost['label'][$key]) && $optionsPost['label'][$key] != ''  ){
                    $options[] = array('name' => $optionsPost['name'][$key] ,'label'=> $value,'value'=>$optionsPost['value'][$key]);    
                }                       
            }           
            if(!empty($options) && count($options) > 1){
                $data['options'] = serialize($options);
            }else{
                $data['options'] = '';
            }
            		
			$this->filter_m->save($data, $id);
			$this->session->set_flashdata('success','Campaign Filter save successfully.');
			redirect('adm/filter');
		}

		// Load the view	
		$this->template->load('admin','campaign/filter/edit_filter',$this->data);	
	}	

	public function delete($id)
	{
		if ($id) {
            $id = decode_url($id);
            $this->filter_m->delete($id);            
            $this->session->set_flashdata('success','Campaign Filter deleted successfully.');
        } else {
            $this->session->set_flashdata('error','Campaign Filter doesn\'t exist.');
        }
        redirect('adm/filter');	

	}

	public function massaction()
	{
		$ids = $this->input->post('id');
		if(empty($ids))
		{
			$this->session->set_flashdata('error','No Filter id selected.');
			redirect('adm/filter');
		}
		$action = $this->input->post('action');
		switch ($action) 
		{
			case 'del':
				foreach ($ids as $key => $id) {
					$id = decode_url($id);
					$this->filter_m->delete($id);											
				}
				$this->session->set_flashdata('success','Campaign filter ids deleted successfully.');
				break;							
		}			
		redirect('adm/filter');	
	}	
}