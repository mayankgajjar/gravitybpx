<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statuses extends CI_Controller{

	public function __constuct(){
		parent::__constuct();
        if(!$this->session->userdata("user")){
            redirect('login');
        }else{
            if($this->session->userdata("user")->group_name == 'Agent' || $this->session->userdata("user")->group_name == 'Agency'){
                redirect('/Forbidden');
            }
        }
        $this->data = array(
            "meta_title" => "System Statuses",
            "title" => "System Statuses",
            "breadcrumb" => "System Statuses",
            "formtitle" => "System Statuses",
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
		$this->load->model('vicidial/vstatuses', 'vstatuses');
	}

	public function index(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert']= TRUE;
        $this->data['listtitle'] = 'System Statuses Listing';
        $this->data['title'] = 'System Statuses';
        $this->template->load('admin',"dialer/admin/statuses/list",$this->data);
	}

	public function indexJson(){
		$this->load->model('vicidial/vstatuses', 'vstatuses');
        $aColumns = array( 'created' ,'status' , 'status_name', 'category', 'min_sec', 'max_sec',);
        /*
         * Paging
         */
        $sLimit = "";
        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ){
            $sLimit = " LIMIT ". $_GET['iDisplayStart'].", ".$_GET['iDisplayLength'];
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
        $sWhere = "";
        if ( $_GET['sSearch'] != "" ){
            $sWhere .= " WHERE (";
            for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                $sWhere .= $aColumns[$i]." LIKE '%". $_GET['sSearch']."%' OR ";
            }
            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= ') ';
        }


        $rResult = $this->vstatuses->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->vstatuses->query($sWhere);
        if($aFilterResult){
            $iFilteredTotal = count($aFilterResult);
        }else{
            $iFilteredTotal = 0;
        }
        $iTotal = count($this->vstatuses->get());

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
                	if($aColumns[$i] == 'created'){
		                $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.	encode_url($aRow['status']).'"/>';
                	}else{
                    	$row[] = $aRow[ $aColumns[$i] ];
                    }
                }
                $row[] = '<a href="'.site_url('dialer/statuses/edit/'.encode_url($aRow['status'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/statuses/delete/'.encode_url($aRow['status'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

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
        $this->data['meta_title'] = "Statuses";
        $this->data['title'] = "Statuses";
        $this->data['breadcrumb'] = "Statuses";
        $this->load->model('vicidial/vstatuses', 'vstatuses');
        $rules = $this->vstatuses->rules;

        if($id){
        	$id = decode_url($id);
        	$status = $this->vstatuses->get_by(array('status' => $id), TRUE);
        	count($status) || $this->data['errors'][] = 'Status could not be found.';
        	$this->data['listtitle'] = 'Edit Status '.$status->status;
        	$this->data['title'] = 'Edit Status '.$status->status;
        	$this->data['sData'] = $status;
        }else{
        	$this->data['listtitle'] = 'Add New Status';
    	 	$this->data['title'] = "Add New Status";
    	 	$this->data['sData'] = $this->vstatuses->get_new();
        }

        $this->form_validation->set_rules($rules);
        if($this->form_validation->run() == TRUE){
        	$data = $this->vstatuses->array_from_post(array(
        		'status', 'status_name', 'selectable', 'human_answered', 'category', 'sale', 'dnc', 'customer_contact', 'not_interested', 'unworkable', 'scheduled_callback', 'completed', 'min_sec', 'max_sec', 'answering_machine', 'transfer_crm'
    		));
        	$statusId = $this->vstatuses->save($data,$id);
        	if($statusId){
                $this->session->set_flashdata('success','Status saved successfully.');
                redirect('dialer/statuses/edit/'.  encode_url($statusId));
        	}
        }
        $this->template->load("admin","dialer/admin/statuses/edit",$this->data);
	}

    public function delete($id = NULL){
    	$this->load->model('vicidial/vstatuses', 'vstatuses');
        if($id){
            $id = decode_url($id);
            $this->vstatuses->delete($id);
            $this->session->set_flashdata('success','Status deleted successfully.');
            t('dialer/statuses/index');
        }else{
            $this->session->set_flashdata('error','Status doesn\'t exist.');
            redirect('dialer/statuses/index');
        }
    }

    public function massaction(){
    	$this->load->model('vicidial/vstatuses', 'vstatuses');
        $ids = $this->input->post('id');

        if(empty($ids)){
            $this->session->set_flashdata('error','No statuses have been selected.');
            redirect('dialer/statuses/index');
        }
        $action = $this->input->post('action');
        switch ($action){
            case 'del':
                foreach ($ids as $key => $id) {
	                $id = decode_url($id);
	                $this->vstatuses->delete($id);
                }
                $this->session->set_flashdata('success','Statuses deleted successfully.');
            break;
        }
        redirect('dialer/statuses/index');
    }

    function _unique_status_id(){
        $id = $this->uri->segment(4);
        $id = decode_url($id);
        $this->vicidialdb->db->where('status',$this->input->post('status'));
        !$id || $this->vicidialdb->db->where(' status!=', $id);
        $filter = $this->vicidialdb->db->get('vicidial_statuses')->row();
        if(count($filter)){
            $this->form_validation->set_message('_unique_filter_id','%s should be unique.');
            return FALSE;
        }
        return TRUE;
    }
}