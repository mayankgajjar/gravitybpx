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
class Calllog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agency') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('callog_m');
    }

    /**
     * Index Of Task
     */
    public function index() {
        $this->data['datatable'] = TRUE;
        $this->data['title'] = 'Agency | Call Log';
        $this->data['pagetitle'] = 'Call Log';
        $this->data['listtitle'] = 'Call Log Listing';
        $this->data['label'] = 'Call Log';
        $this->template->load('agency', 'calllog/index', $this->data);
    }

    public function AgencyCalllogJson() {
        $table = 'call_log cl';
        $aColumns = array('cl.unique_id', 'CONCAT(agn.fname," ",agn.lname) AS agent_name', 'l.member_id AS Lead' , 'cl.number_dialed', 'cl.start_time', 'cl.end_time' , 'cl.length_in_sec', 'cl.type', 'r.recording_url');
        $bColumns = array('unique_id',  'agent_name', 'Lead', 'number_dialed', 'start_time', 'end_time', 'length_in_sec', 'type', 'recording_url');
        $cColumns = array('agn.fname', 'agn.lname', 'l.member_id', 'cl.number_dialed', 'cl.start_time', 'cl.end_time' , 'cl.length_in_sec', 'type');
        
        $relation = array(
            "fields" => 'cl.unique_id,CONCAT(agn.fname," ",agn.lname) AS agent_name, l.member_id AS Lead, cl.number_dialed, cl.start_time, cl.end_time, cl.length_in_sec, cl.type, r.recording_url',
            "JOIN" => array(
                array(
                    "table" => 'agents agn',
                    "condition" => 'cl.agent_id = agn.id ',
                    "type" => 'LEFT'
                ),
                array(
                    "table" => 'lead_store_mst l',
                    "condition" => 'cl.lead_id = l.lead_id ',
                    "type" => 'LEFT'
                ),
                array(
                    "table" => 'recording_log r',
                    "condition" => 'cl.CallUUID = r.callUUid ',
                    "type" => 'LEFT'
                ),
            ),
        );
        $agentlist = getAgentFromAgncyId();
        $relation["conditions"] = "agent_id IN ({$agentlist})";
        
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
        
        if ($_GET['sSearch'] != "") {
            $sWhere .= " AND (";
            for ($i = 0; $i < count($cColumns); $i++) {
                $sWhere .= $cColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
        $relation['conditions'] .= $sWhere;
       
        $aFilterResult = $this->callog_m->get_relation($table, $relation);
        
        /** Paging */
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $relation['LIMIT']['start'] = $_GET['iDisplayLength'];
            $relation['LIMIT']['end'] = $_GET['iDisplayStart'];
        }
        
        $rResult = $this->callog_m->get_relation($table, $relation);
        
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
                    if($bColumns[$i] == 'unique_id'){
                        $row[] = $count++;
                    }elseif ($bColumns[$i] == 'start_time') {
                        $row[] = formatDate($aRow['start_time']);
                    }elseif ($bColumns[$i] == 'end_time') {
                        $row[] = formatDate($aRow['end_time']);
                    }elseif($bColumns[$i] == 'number_dialed'){
                        $row[] = convertphoneformat($aRow['number_dialed']);
                    }elseif($bColumns[$i] == 'recording_url'){
                        $row[] = '<audio controls><source src="'.$aRow['recording_url'].'" type="audio/mpeg"></audio>';
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
