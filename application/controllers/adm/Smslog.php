<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Smslog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Admin') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('leadSmsLog_m', 'leadsmslog_m');
    }

    public function index() {
        $this->data['datatable'] = TRUE;
        $this->data['title'] = 'Admin | SMS Log';
        $this->data['pagetitle'] = 'SMS Log';
        $this->data['listtitle'] = 'SMS Log Listing';
        $this->data['label'] = 'SMS Log';
        $this->template->load('admin', 'smslog/index', $this->data);
    }

    public function indexJson() {
        $aColumns = array('id', 'created', 'sender_number', 'receiver_number', 'sms_status');
        $bColumns = array('id', 'created', 'sender_number', 'receiver_number', 'sms_status');
        $relation = array(
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
        $sWhere = "";
        if ($_GET['sSearch'] != "") {

            $sWhere .= " (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
        $relation['conditions'] = $sWhere;

        $aFilterResult = $this->leadsmslog_m->get_relation('', $relation);
        /** Paging */
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $relation['LIMIT']['start'] = $_GET['iDisplayLength'];
            $relation['LIMIT']['end'] = $_GET['iDisplayStart'];
        }
        $rResult = $this->leadsmslog_m->get_relation('', $relation);
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
                    if ($bColumns[$i] == 'id') {
                        $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="' . encode_url($aRow['id']) . '"/>';
                    } else {
                        $row[] = isset($aRow[$bColumns[$i]]) ? $aRow[$bColumns[$i]] : '';
                    }
                }
                $output['aaData'][] = $row;
            }
        } else {
            $output['aaData'] = array();
        }
        return $this->output
                        ->set_content_type('application/json')
                        ->set_output(json_encode($output));
    }

}
