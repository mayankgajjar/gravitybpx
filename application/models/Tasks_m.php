<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks_m extends My_Model{
    protected $_table_name = 'tasks';
    protected $_primary_key = 'task_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'task_id';
    protected $_timestamps = TRUE;
     public $rules = array(
        'task_date' => array(
            'field' => 'task_date',
            'label' => 'Task Date',
            'rules' => 'trim|required'
        ),
        'task_description' => array(
            'field' => 'task_description',
            'label' => 'Task Description',
            'rules' => 'trim|required'
        ),
        'task_end_time' => array(
                'field' => 'task_end_time',
                'label'	=> 'Task End Time',
                'rules' => 'trim|required'
        ),
        'task_start_time' => array(
                'field' => 'task_start_time',
                'label'	=> 'Task Start Time',
                'rules' => 'trim|required'
        ),
    );

    public function get_new(){
        $task = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $bid->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $task;
    }

}
