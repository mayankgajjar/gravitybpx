<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filter extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name == 'Agent' || $this->session->userdata("user")->group_name == 'Agency') {
                redirect('/Forbidden');
            }
        }
        $this->data = array(
            "meta_title" => "",
            "title" => "",
            "breadcrumb" => "",
            "formtitle" => "",
            "listtitle" => "",
            "modelname" => "",
            "formactioncontroller" => "",
            "addactioncontroller" => "",
            "deleteactioncontroller" => "",
            "openparentsli" => "configuration",
            "activeparentsli" => "status_management",
            "deletetitle" => "Status",
            "datatablecontroller" => "statusmanagementcontroller/indexJson",

        );
        $this->load->library('vicidialdb');
        $this->load->model('vicidial/vlfilters_m', 'vlfilters_m');
        $this->load->model('vicidial/vugroup_m', 'vugroup_m');
        $this->load->model('vicidial/afilter_m', 'afilter_m');
    }
    public function index(){
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['meta_title'] = "Filter";
        $this->data['title'] = "Filter";
        $this->data['breadcrumb'] = "Filter";
        $this->data['listtitle'] = "Filter Listing";
        $this->data['addactioncontroller'] = "dialer/filter/edit";
        $this->template->load("admin","dialer/admin/filter/list",$this->data);
    }
    public function indexjson(){
        $aColumns = array( 'lead_filter_id' , 'lead_filter_name', 'user_group');
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


        $rResult = $this->vlfilters_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->vlfilters_m->query($sWhere);
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
                    $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.encode_url($aRow['lead_filter_id']).'"/>';
                    for ( $i=0 ; $i<count($aColumns) ; $i++ )
                        {
                                $row[] = $aRow[ $aColumns[$i] ];

                        }
                        $row[] = '<a href="'.site_url('dialer/filter/edit/'.encode_url($aRow['lead_filter_id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('dialer/filter/delete/'.encode_url($aRow['lead_filter_id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';

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
        $this->data['datepicker'] = TRUE;
        $this->data['meta_title'] = "Filter";
        $this->data['title'] = "Filter";
        $this->data['breadcrumb'] = "Filter";
        $this->data['groups'] = $this->vugroup_m->get();
        if($id){
            $id = decode_url($id);
            $this->data['filter'] = $this->vlfilters_m->get_by(array('lead_filter_id' => $id), TRUE);
            count($this->data['filter']) || $this->data['errors'][] = 'Filter doesn\'t exists';
            $afilter = $this->afilter_m->get_by(array('vicidial_filter_id' => $id), TRUE);
            $this->data['filter'] = (object) array_merge((array) $this->data['filter'], (array) $afilter);
            $this->data['listtitle'] = "Edit Filter ".$this->data['filter']->lead_filter_id;
        }else{
            $this->data['filter'] = $this->vlfilters_m->get_new();
            $this->data['listtitle'] = "Add New Filter";
        }
        $rules = $this->vlfilters_m->rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run() == TRUE){
            $data = $this->vlfilters_m->array_from_post(array(
                'lead_filter_id', 'lead_filter_name', 'lead_filter_comments', 'user_group'
            ));
            $filter_options = $this->input->post('filter_options');
            $filter_type = $this->input->post('filter_type');
            $type = '';
            switch ($filter_type){
                case 'in':
                    $type = 'IN';
                    break;
                case 'not-in':
                    $type = 'NOT IN';
                    break;
            }
            switch($filter_options){
                case 'area_code':
                    $data['lead_filter_sql'] = "LEFT(phone_number,3) {$type} ";
                    $data['lead_filter_sql'] .= '('.rtrim($this->input->post('filter_values'), ',').')';
                    break;
                case 'postel_code':
                    $data['lead_filter_sql'] = "postal_code {$type} ";
                    $data['lead_filter_sql'] .= '('.rtrim($this->input->post('filter_values'), ',').')';
                    break;
                case 'state':
                    $data['lead_filter_sql'] = "state {$type} ";
                    $data['lead_filter_sql'] .= '('.rtrim($this->input->post('filter_values'), ',').')';
                    break;
                case 'custom':
                    $data['lead_filter_sql'] .= $this->input->post('lead_filter_sql');
                    break;
            }
            $filterId = $this->vlfilters_m->save($data, $id);
            if($filterId){
                $aData = array('vicidial_filter_id' => $filterId, 'filter_type' => $type, 'filter_options' => $filter_options, 'filter_values' => $this->input->post('filter_values'));
                $aFilter = $this->afilter_m->get_by(array('vicidial_filter_id' => $filterId), TRUE);
                $aFilterId = NULL;
                if($aFilter){
                    $aFilterId = $aFilter->id;
                }
                $this->afilter_m->save($aData, $aFilterId);
                $this->session->set_flashdata('success', 'Filter saved successfully.');
                redirect('dialer/filter/edit/'.encode_url($filterId));
            }
        }
        $this->template->load('admin', "dialer/admin/filter/edit", $this->data);
    }
    public function _check_string(){
        $string =  $this->input->post('lead_filter_id');
        $result = preg_match('/[[:punct:]]/', $string);
        if($result || strpos($string, " ")){
            $this->form_validation->set_message('_check_string','%s should have no spaces or punctuation.');
            return FALSE;
        }
        return TRUE;
    }
    public function _unique_filter_id($campaignId){
        $id = $this->uri->segment(4);
        $id = decode_url($id);
        $this->vicidialdb->db->where('lead_filter_id',$this->input->post('lead_filter_id'));
        !$id || $this->vicidialdb->db->where(' lead_filter_id!=', $id);
        $filter = $this->vicidialdb->db->get('vicidial_lead_filters')->row();
        if(count($filter)){
            $this->form_validation->set_message('_unique_filter_id','%s should be unique.');
            return FALSE;
        }
        return TRUE;
    }
    public function delete($id = NULL){
        if($id){
                $id = decode_url($id);
                $this->vlfilters_m->delete($id);
                $aFilter = $this->afilter_m->get_by(array('vicidial_filter_id' => $id), TRUE);
                if($aFilter){
                    $this->afilter_m->delete($aFilter->id);
                }
                $this->session->set_flashdata('success','Filter deleted successfully.');
                redirect('dialer/filter/index');
        }else{
                $this->session->set_flashdata('error','Filter record doesn\'t exist.');
                redirect('dialer/filter/index');
        }
    }
    public function massaction(){
        $ids = $this->input->post('id');

        if(empty($ids)){
            $this->session->set_flashdata('error','No User Group Records have been selected.');
            redirect('dialer/filter/index');
        }
        $action = $this->input->post('action');
        switch ($action){
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $this->vlfilters_m->delete($id);
                    $aFilter = $this->afilter_m->get_by(array('vicidial_filter_id' => $id), TRUE);
                    if($aFilter){
                        $this->afilter_m->delete($aFilter->id);
                    }
                }
                $this->session->set_flashdata('success','User Group deleted successfully.');
                break;
        }
        redirect('dialer/filter/index');
    }
}
