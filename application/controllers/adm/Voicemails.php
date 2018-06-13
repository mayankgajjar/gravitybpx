<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tasks
 * @uses element Description
 */
class Voicemails extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Admin') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('voicemails_m');
    }

    /**
     * Index Of Task
     */
    public function index() {
        $this->data['datatable'] = TRUE;
        $this->data['title'] = 'Admin | Voicemail';
        $this->data['pagetitle'] = 'Voicemail';
        $this->data['listtitle'] = 'Voicemail Listing';
        $this->data['label'] = 'Voicemail';
        $this->data ['audiojs'] = TRUE;
        $this->template->load('admin', 'voicemail/index', $this->data);
    }

    public function Adminvoicemailjson() {
        
        $table = 'voicemails v';
        $aColumns = array('v.voicemail_id', 'CONCAT(agn.fname," ",agn.lname) AS agent_name','age.name AS agency_name', 'v.from', 'v.created', 'v.voicemail_url');
        $bColumns = array('voicemail_id', 'agent_name', 'agency_name', 'from', 'created', 'voicemail_url');
        $cColumns = array('agn.fname', 'agn.lname', 'age.name', 'v.from', 'v.created');
        
        $relation = array(
            "fields" => 'v.voicemail_id,CONCAT(agn.fname," ",agn.lname) AS agent_name, age.name AS agency_name,v.from,v.created,v.voicemail_url',
            "JOIN" => array(
                array(
                    "table" => 'agents agn',
                    "condition" => 'v.agent_id = agn.user_id ',
                    "type" => 'LEFT'
                ),
                array(
                    "table" => 'agencies age',
                    "condition" => 'agn.agency_id = age.id ',
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
        
        

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = '1<2';
        if ($_GET['sSearch'] != "") {
            $sWhere .= " AND (";
            for ($i = 0; $i < count($cColumns); $i++) {
                $sWhere .= $cColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
        $relation['conditions'] .= $sWhere;
       
        $aFilterResult = $this->voicemails_m->get_relation($table, $relation);
        
        /** Paging */
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $relation['LIMIT']['start'] = $_GET['iDisplayLength'];
            $relation['LIMIT']['end'] = $_GET['iDisplayStart'];
        }
        
        $rResult = $this->voicemails_m->get_relation($table, $relation);
        /*echo $this->db->last_query();
        die;*/

        
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

                for ($i = 0; $i < count($bColumns); $i++) {
                    if($bColumns[$i] == 'voicemail_id'){
                        $row[] = $count++;
                    }elseif ($bColumns[$i] == 'created') {
                        $row[] = formatDate($aRow['created']);
                    }elseif($bColumns[$i] == 'from'){
                        $row[] = convertphoneformat($aRow['from']);
                    }elseif ($bColumns[$i] == 'voicemail_url') {
                        $row[] = '<audio controls><source src="'.$aRow['voicemail_url'].'" type="audio/mpeg"></audio>';
                    }else{
                        $row[] = $aRow[$bColumns[$i]];
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
