<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bid extends CI_Controller
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
		$this->load->model('bid_m');
	}

	public function index()
	{
		$this->data['datatable'] = TRUE;
		$this->data['sweetAlert'] = TRUE;
		$this->data['title'] = 'Admin | Campaign Bids Type';
		$this->template->load('admin','campaign/bid/list_bid',$this->data);
	}

	 public function indexjson(){
        $aColumns = array('lead_bid_id', 'name','minbid','active');
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
                
        $rResult = $this->bid_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->bid_m->query($sWhere);
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
                        if($aColumns[$i] == 'lead_bid_id'){
                            $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="' . encode_url($aRow['lead_bid_id']) . '"/>';
                        }
						elseif($aColumns[$i] == 'active'){
                            if($aRow['active'] == '1') {
                            	$row[] = '<span class="label lable-sm label-success">Enable</span>';
                            }else{
                            	$row[] = '<span class="label lable-sm label-warning">Disable</span>';
                            }
                        }
                        else{
                            $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                        }
                }
                 $row[] = '<a href="' . site_url('adm/bid/edit/'. encode_url($aRow['lead_bid_id'])) . '"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="' . site_url('adm/bid/delete/'.encode_url($aRow['lead_bid_id'])) . '"><i class="fa fa-trash" aria-hidden="true"></i></i>';

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
		$this->data['meta_title'] = "Bid Type Operation";
		if($id){
			$id = decode_url($id);
            $this->data['bid'] = $this->bid_m->get_by(array('lead_bid_id' => $id), TRUE);
            count($this->data['bid']) || $this->data['errors'][] = 'Bid Type could not be found';            
            $this->data['listtitle'] = "Edit Bid Type";
            // $this->data['requiredJson'] = $this->bid_m->getRequiredFieldJson($id);
		}else{	
			$this->data['listtitle'] = "Add A New bid Type";		
			$this->data['bid'] = $this->bid_m->get_new();
		}

		$rules = $this->bid_m->rules;	
		
		/* For check is unique validation */
		if($id == '' || $this->data['bid']->name != $this->input->post('name')){
			$rules['name']['rules'] = $rules['name']['rules']."|is_unique[lead_bid_type.name]";
		}	
		/* End For check is unique validation */
		

		$this->form_validation->set_rules($rules);

		if( $this->form_validation->run() == TRUE){
			$data = $this->bid_m->array_from_post(array(
					'name','minbid','descr','active'
				));			
			$this->bid_m->save($data, $id);
			$this->session->set_flashdata('success','Campaign bid type save successfully.');
			redirect('adm/bid');
		}

		// Load the view	
		$this->template->load('admin','campaign/bid/edit_bid',$this->data);	
	}	

	public function delete($id)
	{
		if ($id) {
            $id = decode_url($id);
            $this->bid_m->delete($id);            
            $this->session->set_flashdata('success','Campaign bid type deleted successfully.');
        } else {
            $this->session->set_flashdata('error','Campaign bid type doesn\'t exist.');
        }
        redirect('adm/bid');	

	}

	public function massaction()
	{
		$ids = $this->input->post('id');
		if(empty($ids))
		{
			$this->session->set_flashdata('error','No Campaign id selected.');
			redirect('adm/bid');
		}
		$action = $this->input->post('action');
		switch ($action) 
		{
			case 'del':
				foreach ($ids as $key => $id) {
					$id = decode_url($id);
					$this->bid_m->delete($id);											
				}
				$this->session->set_flashdata('success','Campaign bid type ids deleted successfully.');
				break;							
		}			
		redirect('adm/bid');	
	}	
}