<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dial extends CI_Controller{

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agent') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('Tasks_m');
        $this->load->model('Callog_m');
        $this->load->model('voicemails_m');
    }

    public function index(){
        // For now display agent page
         $this->data['counterup'] = true;
         $this->data['ckeditor'] = TRUE;
         $this->data['title'] = 'Agent | Dialer';
         $this->data['pagetitle'] = 'Dialer';
         $this->data['datatable'] = TRUE;
         /* recent calls */
        $options = array('LIMIT' => array('start' => '6', 'end' => '0'), 'ORDER_BY' => array('field' => 'unique_id', 'order' => 'DESC'));
        $options['conditions'] = 'agent_id = ' . $this->session->userdata('agent')->id . ' AND call_log.lead_id != ""';
        $options["JOIN"] = array(array(
                'table' => 'lead_store_mst',
                'condition' => 'lead_store_mst.lead_id = call_log.lead_id',
                'type' => 'FULL'
            )
        );
        $options['fields'] = 'call_log.unique_id,call_log.type,lead_store_mst.phone,call_log.lead_id,lead_store_mst.first_name,lead_store_mst.last_name';
        $this->data['callLogs'] = $this->Callog_m->get_relation('', $options);
        $id=$this->session->userdata['user']->id ;
        $this->data['tasks'] = $this->Tasks_m->get_by(array('user_id'=>$id));
        /* agentID */
        $agentID=$this->session->userdata['agent']->id;
        /* total outbound calls */
        $relation = array(
            'fields' => "count(*) As total",
            'conditions' => "agent_id = $agentID AND TYPE = 'outbound'"
        );
        $data = $this->Callog_m->get_relation('', $relation);
        $this->data['totalOutbound'] = $data['0']['total'];
        /* total inbound calls */
        $relation = array(
            'fields' => "count(*) As total",
            'conditions' => "agent_id = $agentID AND TYPE = 'inbound'"
        );
        $data = $this->Callog_m->get_relation('', $relation);
        $this->data['totalInbound'] = $data['0']['total'];
        $this->template->load("agent", "dialpad/index", $this->data);
    }

    public function voicemail() {
        $this->data['datatable'] = TRUE;
        $this->data['title'] = 'Agent | Voicemails';
        $this->data['pagetitle'] = 'Voicemails';
        $this->data['listtitle'] = 'Voicemail';
        $this->data['label'] = 'Task';
        $this->data ['audiojs'] = TRUE;
        $this->template->load('agent', 'dialpad/voicemail', $this->data);
    }

    public function voicemailjson() {
        $aColumns = array('voicemail_id', 'from', 'created', 'voicemail_url');
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
        $sWhere = " WHERE (agent_id = {$this->session->userdata('user')->id})";
        if ($_GET['sSearch'] != "") {
            $sWhere .= " AND (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }


        $rResult = $this->voicemails_m->query($sWhere, $sOrder, $sLimit);

        $aFilterResult = $this->voicemails_m->query($sWhere);
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

                for ($i = 0; $i < count($aColumns); $i++) {
                    if($aColumns[$i] == 'voicemail_id'){
                        $row[] = $count++;
                    }elseif ($aColumns[$i] == 'created') {
                        $row[] = formatDate($aRow['created']);
                    }elseif($aColumns[$i] == 'from'){
                        $row[] = convertphoneformat($aRow['from']);
                    }elseif ($aColumns[$i] == 'voicemail_url') {
                        $row[] = '<audio controls><source src="'.$aRow['voicemail_url'].'" type="audio/mpeg"></audio>';
                        //$row[] = '<audio class="audiojsc" type="audio/mpeg" src="'.$aRow['voicemail_url'].'"></audio>';
                    }else{
                        $row[] = $aRow[$aColumns[$i]];
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
