<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller{

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agent') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('tasks_m');
    }

    public function index(){
        $this->data['datatable'] = TRUE;
        $this->data['validation'] = TRUE;
        $this->data['daterangepicker'] = TRUE;
        $this->data['datepicker'] = TRUE;
        $this->data['title'] = 'Agent | Tasks';
        $this->data['pagetitle'] = 'Tasks';
        $this->data['listtitle'] = 'Tasks Listing';
        $this->data['label'] = 'Task';
        $this->template->load('agent','task/list', $this->data);
    }
    
   public function taskjson(){
        $status = "";
        if (isset($_REQUEST['status'])) {
            $status = $_REQUEST['status'];
        }
        $table = 'tasks t';
        $aColumns = array('t.task_id','a.fname','a.lname','ag.fname','ag.lname','t.task_date','t.task_description','t.task_start_time','t.assign_agent_id');
        $bColumns = array('task_id','add_by','task_date','task_description','task_start_time','assign_agent_name','task_status');
        
        $relation = array(
                "fields" => 't.task_id,CONCAT(a.fname," ",a.lname) as add_by,t.task_date,t.task_description,t.task_start_time,CONCAT(ag.fname," ",ag.lname) as assign_agent_name,t.task_status',
                "JOIN" => array(
                    array(
                        "table" => 'users u',
                        "condition" => 't.user_id = u.id ',
                        "type" => 'LEFT'
                    ),
                    array(
                        "table" => 'agents a',
                        "condition" => 'u.id = a.user_id ',
                        "type" => 'LEFT'
                    ),
                    array(
                        "table" => 'agents ag',
                        "condition" => 't.assign_agent_id = ag.id ',
                        "type" => 'LEFT'
                    ),
                ),
            );    

        if($status == 'assign'){
            $relation['conditions'] = "t.user_id = {$this->session->userdata('agent')->user_id}";
        } elseif($status == 'received') {
            $relation['conditions'] = "t.assign_agent_id = {$this->session->userdata('agent')->id}";
        }else{
            $relation['conditions'] = "t.user_id = {$this->session->userdata('agent')->user_id} OR t.assign_agent_id = {$this->session->userdata('agent')->id}";
        }
        
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

            $sWhere .= " AND (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
        $relation['conditions'] .= $sWhere;

        $aFilterResult = $this->tasks_m->get_relation($table, $relation);
        /** Paging */
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $relation['LIMIT']['start'] = $_GET['iDisplayLength'];
            $relation['LIMIT']['end'] = $_GET['iDisplayStart'];
        }
        $rResult = $this->tasks_m->get_relation($table, $relation);
      
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
                    if ($bColumns[$i] == 'task_id') {
                        $row[] = '<input type="checkbox" class="checkboxes"  name="id[]" value="' . encode_url($aRow['task_id']) . '"/>';
                    } else {
                        $row[] = isset($aRow[$bColumns[$i]]) ? $aRow[$bColumns[$i]] : '';
                    }
                }
               
                if(strtolower($aRow['task_status']) == 'pending'){                    
                    $row[] = '<a class="view_task" title="View" data-toggle="modal" href="#large" data-custom-value="'. encode_url($aRow['task_id']).'"><i class="fa fa-2x fa-info" aria-hidden="true"></i></a>&nbsp;&nbsp;'
                        . '<a class="task_done" title="Task Done" data-custom-value="'. encode_url($aRow['task_id']).'"><i class="fa fa-2x fa-check-square" aria-hidden="true"></i></a>';
                } else { 
                    $row[] = '<a class="view_task" title="View" data-toggle="modal" href="#large" data-custom-value="'. encode_url($aRow['task_id']).'"><i class="fa fa-2x fa-info" aria-hidden="true"></i></a>';
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
    
    function view_task() {
        $task_id =  decode_url($this->input->post('taskid'));
        $table = 'tasks t';
        $relation = array(
            "fields" => 't.task_id,CONCAT(a.fname," ",a.lname) as add_by,t.task_date,t.task_description,t.task_start_time,t.task_end_time,CONCAT(ag.fname," ",ag.lname) as assign_agent_name,t.task_note,t.task_status',
            "JOIN" => array(
                array(
                    "table" => 'users u',
                    "condition" => 't.user_id = u.id ',
                    "type" => 'LEFT'
                ),
                array(
                    "table" => 'agents a',
                    "condition" => 'u.id = a.user_id ',
                    "type" => 'LEFT'
                ),  
                array(
                    "table" => 'agents ag',
                    "condition" => 't.assign_agent_id = ag.id ',
                    "type" => 'LEFT'
                ),
            ),
            "conditions" => "t.task_id = {$task_id}"
        );
        $this->data['task_info'] = $this->tasks_m->get_relation($table, $relation);
        $this->data['title'] = 'View Task';
        echo $this->load->view("agent/crm/popupbox/view_task", $this->data, TRUE);
    }
    
    function done_task() {
        $id =  decode_url($this->input->post('taskid'));
        $data['task_status'] = 'completed';
        $task_id = $this->tasks_m->save($data,$id);
        if($task_id){
            echo 'task successfully completed';
        }
    }
    
    public function dialertaskjson(){
        $table = 'tasks t';
        $aColumns = array('t.task_id','t.task_description','t.task_date');
        $bColumns = array('task_id','task_description','task_date');
        
            $relation = array(
                "fields" => 't.task_id,t.task_description,t.task_date,',
            );    

            $relation['conditions'] = "t.assign_agent_id = {$this->session->userdata('agent')->id}";
        
        
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

            $sWhere .= " AND (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $_GET['sSearch'] . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ') ';
        }
        $relation['conditions'] .= $sWhere;

        $aFilterResult = $this->tasks_m->get_relation($table, $relation);
        /** Paging */
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $relation['LIMIT']['start'] = $_GET['iDisplayLength'];
            $relation['LIMIT']['end'] = $_GET['iDisplayStart'];
        }
        $rResult = $this->tasks_m->get_relation($table, $relation);
      
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
                    if ($bColumns[$i] == 'task_id') {
                        $row[] = $i+1;
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
