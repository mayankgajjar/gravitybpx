<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vertical extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Admin') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('vertical_m');
        $this->load->model('bid_m');
        $this->load->model('filter_m');
    }

    public function index() {
        $this->data['datatable'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['title'] = 'Lead Store | Campaign Type';
        $this->data['maintitle'] = 'Campaign Type';
        $this->data['listtitle'] = 'Manege Campaign Type';
        $this->data['breadcrumb'] = 'Campaign Type';
        $this->data['addactioncontroller'] = 'adm/vertical/edit';
        $categories = $this->vertical_m->get(NULL, FALSE);
        $this->data['categories'] = $categories;
        $this->template->load('admin', 'campaign/vertical/list', $this->data);
    }

    public function indexJson() {
        $aColumns = array('id', 'cat_name', 'cat_slug', 'active');
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
        $sWhere = "";
        if ($_GET['sSearch'] != "") {
            $sWhere .= "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                if($aColumns[$i] != 'leads_count' && $aColumns[$i] != 'agency' ){
                    $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
                }
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }


        $rResult = $this->vertical_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->vertical_m->query($sWhere);
        if ($aFilterResult) {
            $iFilteredTotal = count($aFilterResult);
        } else {
            $iFilteredTotal = 0;
        }
        $iTotal = count($this->vertical_m->get());

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
                    if($aColumns[$i] == 'id'){
                        $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="' . encode_url($aRow['id']) . '"/>';
                    }else if($aColumns[$i] == 'active'){
                        if($aRow['active'] == 1){
                            $row[] = '<span class="label label-sm label-success">Enable</span>';
                        }else{
                            $row[] = '<span class="label label-sm label-warning">Disable</span>';
                        }
                    }else{
                        $row[] = isset($aRow[$aColumns[$i]]) ? $aRow[$aColumns[$i]] : '';
                    }

                }
                $row[] = '<a href="' . site_url('adm/vertical/edit/' . encode_url($aRow['id'])) . '"><i class="fa  fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a class="delete" href="' . site_url('adm/vertical/delete/' . encode_url($aRow['id'])) . '"><i class="fa fa-trash" aria-hidden="true"></i></i>';

                $output['aaData'][] = $row;
            }
        } else {
            $output['aaData'] = array();
        }

        return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($output));
    }

    public function edit($id = NULL) {
        $this->data['validation'] = TRUE;
        $this->data['breadcrumb'] = '';
        $this->data['title'] = '';
        $this->data['bids'] = $this->bid_m->get_by(array('active' => 1));
        if ($id) {
            $id = decode_url($id);
            $this->data['vertical'] = $this->vertical_m->get($id);
            $this->data['title'] = 'Edit ' . $this->data['vertical']->cat_name;
            $this->data['breadcrumb'] = 'Edit ' . $this->data['vertical']->cat_name;
            count($this->data['vertical']) || $this->data['errors'][] = 'Verical could not be found.';
        } else {
            $this->data['vertical'] = $this->vertical_m->get_new();
            $this->data['title'] = 'Add New';
            $this->data['breadcrumb'] = 'Add New';
        }

        $rules = $this->vertical_m->rules;
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == TRUE) {
            $data = $this->vertical_m->array_from_post(array(
                'cat_name', 'cat_slug', 'active', 'is_condition', 'condition_text'
            ));
            if ($this->input->post('auctions')) {
                $data['auctions'] = implode(',', $this->input->post('auctions'));
            }
            if ($this->input->post('bid')) {
                $data['bid'] = implode(',', $this->input->post('bid'));
            }
            if ($this->input->post('filters')) {
                $data['filters'] = serialize($this->input->post('filters'));
            }
            $this->vertical_m->save($data, $id);
            $this->session->set_flashdata('success', 'Campaign type save successfully.');
            redirect('adm/vertical/index');
        }

        // Load the view
        $this->template->load('admin', 'campaign/vertical/edit', $this->data);
    }

    public function massaction(){
        $ids = $this->input->post('id');

        if (empty($ids)) {
            $this->session->set_flashdata('error', 'No Campaign Category have been selected.');
            redirect('adm/vertical/index');
        }
        $action = $this->input->post('action');
        switch ($action) {
            case 'del':
                foreach ($ids as $key => $id) {
                    $id = decode_url($id);
                    $this->vertical_m->delete($id);
                }
                $this->session->set_flashdata('success', 'Leads deleted successfully.');
                break;
        }
        redirect('adm/vertical/index');
    }

    public function delete($id = NULL) {
        if ($id) {
            $id = decode_url($id);
            $this->vertical_m->delete($id);
            $this->session->set_flashdata('success', 'Campaign category deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Campaign category doesn\'t exist.');
        }
         redirect('adm/vertical/index');
    }

}
