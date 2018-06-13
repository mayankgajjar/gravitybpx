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
class Tasks extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata("user")) {
            redirect('login');
        } else {
            if ($this->session->userdata("user")->group_name != 'Agency') {
                redirect('/Forbidden');
            }
        }
        $this->load->model('tasks_m');
        $this->load->model('Agents');
        $this->load->model('leadstore_m');
        $this->load->model('Calendar_m');
    }

    /**
     * Index Of Task
     */
    public function index() {
        $this->data['datatable'] = TRUE;
        $this->data['validation'] = TRUE;
        $this->data['daterangepicker'] = TRUE;
        $this->data['datepicker'] = TRUE;
        $this->data['sweetAlert'] = TRUE;
        $this->data['title'] = 'Agent | Tasks';
        $this->data['pagetitle'] = 'Tasks';
        $this->data['listtitle'] = 'Tasks Listing';
        $this->data['label'] = 'Task';
        $this->template->load('agency', 'task/index', $this->data);
    }

    public function taskjson() {

        $table = 'tasks t';
        $aColumns = array('t.task_id', 'a.name', 'CONCAT(agn.fname," ",agn.lname) AS agent_name', 't.task_description', 't.task_date', 't.task_start_time', 't.task_end_time', 't.task_status', 't.assign_agent_id');
        $bColumns = array('task_id', 'name', 'agent_name', 'task_description', 'task_date', 'task_start_time', 'task_end_time', 'task_status');
        $relation = array(
            "fields" => 't.task_id,a.name,CONCAT(agn.fname," ",agn.lname) AS agent_name,t.task_description,t.task_date,t.task_start_time,t.task_end_time,t.task_status',
            "JOIN" => array(
                array(
                    "table" => 'users u',
                    "condition" => 't.user_id = u.id ',
                    "type" => 'LEFT'
                ),
                array(
                    "table" => 'agencies a',
                    "condition" => 'u.id = a.user_id ',
                    "type" => 'LEFT'
                ),
                array(
                    "table" => 'agents agn',
                    "condition" => 't.assign_agent_id = agn.id ',
                    "type" => 'LEFT'
                ),
            ),
        );
        $relation["conditions"] = "t.user_id = {$this->session->userdata('agency')->user_id}";

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
                    } elseif ($bColumns[$i] == 'task_date') {
                        $row[] = isset($aRow[$bColumns[$i]]) ? formatDate($aRow[$bColumns[$i]], false) : '';
                    } else {
                        $row[] = isset($aRow[$bColumns[$i]]) ? $aRow[$bColumns[$i]] : '';
                    }
                }
                if (strtolower($aRow['task_status']) == 'pending') {
                    $row[] = '<a class="view_task" title="View" data-toggle="modal" href="#large" data-custom-value="' . encode_url($aRow['task_id']) . '"><i class="fa fa-info" aria-hidden="true"></i></a>&nbsp;&nbsp;'
                            .'<a class="delete_task" title="Delete Task" data-custom-value="' . encode_url($aRow['task_id']) . '"><i class="fa fa-trash" aria-hidden="true"></i></a>&nbsp;&nbsp;'
                            . '<a class="task_done" title="Task Done" data-custom-value="' . encode_url($aRow['task_id']) . '"><i class="fa fa-check-square" aria-hidden="true"></i></a>';
                } else {
                    $row[] = '<a class="view_task" title="View" data-toggle="modal" href="#large" data-custom-value="' . encode_url($aRow['task_id']) . '"><i class="fa fa-info" aria-hidden="true"></i></a>';
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

    public function get_popup_box() {
        $box_type = $this->input->post('boxtype');
        if ($box_type == 'task') {
            $this->data['title'] = 'Add New Task';
            $sql = "SELECT id, CONCAT(fname,' ',lname) AS agent_name FROM `agents` WHERE `agency_id` = " . $this->session->userdata('agency')->id . "";
            $query = $this->db->query($sql);
            $this->data['agent_list'] = $query->result_array();
            echo $this->load->view("agency/task/popup", $this->data, TRUE);
        }
    }

    public function create_save() {
        $save_arr = $this->input->post();
        $this->form_validation->set_rules($this->tasks_m->rules);
        if ($this->form_validation->run() == TRUE) {
            $data = $this->tasks_m->array_from_post(array(
                'task_description', 'task_start_time', 'task_end_time', 'task_note', 'task_date', 'assign_agent_id'
            ));
            $data['user_id'] = $this->session->userdata('agency')->user_id;
            $data['task_date'] = date("Y-m-d", strtotime($data['task_date']));
            $data['assign_agent_id'] = $data['assign_agent_id'];
            $task_id = $this->tasks_m->save($data, $id);
            if ($task_id) {
                $link = base_url('age/tasks/index');
                echo $link;
            }
        } else {
            $this->session->set_flashdata('error', 'Data Not save');
            echo 'error';
        }
    }

    function view_task() {
        $task_id = decode_url($this->input->post('taskid'));
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
        echo $this->load->view("agency/task/view_task_popup", $this->data, TRUE);
    }

    function done_task() {
        $id = decode_url($this->input->post('taskid'));
        $data['task_status'] = 'completed';
        $task_id = $this->tasks_m->save($data, $id);
        if ($task_id) {
            echo 'task successfully completed';
        }
    }

    function deleteTask() {
        $id = decode_url($this->input->post('taskid'));
        $task_id = $this->tasks_m->delete($id);
        if ($task_id) {
            echo 'Task Deleted Successfully';
        }
    }

}
