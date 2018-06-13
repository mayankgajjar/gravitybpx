<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Email_template extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Admin') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('emailtemplate_m');
    }

    public function index() {
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['label'] = 'Email Template';
        $this->data['pagetitle'] = 'Email Template';
        $this->data['listtitle'] = 'Manege Email Template';
        $this->template->load('admin', 'email_template/list_template', $this->data);
    }

    public function indexJson()
    {
            $aColumns = array('id', 'name', 'subject', 'created' ,'modified');
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
            $sWhere = " ";
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


            $rResult = $this->emailtemplate_m->query($sWhere, $sOrder, $sLimit);

            $aFilterResult = $this->emailtemplate_m->query($sWhere);
            if($aFilterResult){
                $iFilteredTotal = count($aFilterResult);
            }else{
                $iFilteredTotal = 0;
            }

            $iTotal = count($this->emailtemplate_m->get());

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

                    for ( $i=0 ; $i<count($aColumns) ; $i++ )
                    {
                        if($aColumns[$i] == 'id'){
                            $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="'.encode_url($aRow['id']).'"/>';
                        }else{
                            $row[] = $aRow[ $aColumns[$i] ];
                        }
                    }
                    $row[] = '<a href="'.site_url('adm/email_template/edit/'.encode_url($aRow['id'])).'"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="'.site_url('adm/email_template/delete/'.encode_url($aRow['id'])).'"><i class="fa fa-trash" aria-hidden="true"></i></i>';
                    $output['aaData'][] = $row;
                }
            }else{
                $output['aaData'] = array();
            }
            return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));

    }

    public function edit($id = NULL) {

        $this->data['validation'] = TRUE;
        $this->data['ckeditor'] = TRUE;
        $this->data['model'] = TRUE;
        $this->data['label'] = 'Email Template';
        $this->data['pagetitle'] = 'Email Template';
        if($id){
            $id = decode_url($id);
            $this->data['template'] = $this->emailtemplate_m->get($id,TRUE);
            count($this->data['template']) || $this->data['errors'][] = 'Template could not be found.';
            $this->data['title'] = 'Edit Template '.$this->data['template']->name;
            $this->data['breadcrumb'] = 'Template';
        }else{
            $this->data['template'] = $this->emailtemplate_m->get_new();
            $this->data['title'] = 'Add New Template';
            $this->data['breadcrumb'] = 'Template';
        }

        $rules = $this->emailtemplate_m->rules;
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run() == TRUE){
            $data = $this->emailtemplate_m->array_from_post(array(
                'name', 'subject', 'body', 'event'
            ));
            $id = $this->emailtemplate_m->save($data, $id);
            $this->session->set_flashdata('success','Template saved successfully.');
            redirect('adm/email_template');
            // redirect('adm/email_template/edit/'.encode_url($id));
        }
        // Load the view
        $this->template->load('admin', 'email_template/edit_template', $this->data);
    }

    public function massaction(){
        $ids = $this->input->post('id');

        if (empty($ids)) {
            $this->session->set_flashdata('error', 'No Email Template have been selected.');
            redirect('adm/email_template');
        }
        $action = $this->input->post('action');
        switch ($action) {
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $this->emailtemplate_m->delete($id);
                }
                $this->session->set_flashdata('success', 'Email Template deleted successfully.');
                break;
        }
        redirect('adm/email_template');
    }

    public function delete($id = NULL) {
        if ($id) {
            $id = decode_url($id);
            $this->emailtemplate_m->delete($id);
            $this->session->set_flashdata('success', 'Email Template deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Email Template doesn\'t exist.');
        }
         redirect('adm/email_template');
    }

    public function setvariable($name = NULL)
    {
        if($name){
            $this->load->view('admin/email_template/variable/'.strtolower($name));
        }
    }

}
