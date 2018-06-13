<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar_m extends My_Model
{	
	protected $_table_name  = 'calendar';
	protected $_primary_key = 'id';
	protected $_order_by    = 'id';
	protected $_timestamps  = TRUE;
	public $rules           = array('event_start_date'=>array(
					'field' => 'event_start_date',
					'label'	=> 'Event Start Date',
					'rules' => 'trim|required'
				),
				'event_end_date' => array(
					'field' => 'event_end_date',
					'label'	=> 'Event End Date',
					'rules' => 'trim|required'					
				),
				'event_start_time' => array(
					'field' => 'event_start_time',
					'label'	=> 'Event Start Time',
					'rules' => 'trim|required'					
				),
				'event_end_time' => array(
					'field' => 'event_end_time',
					'label'	=> 'Event End Time',
					'rules' => 'trim|required'					
				),
				'event_desc' => array(
					'field' => 'event_desc',
					'label'	=> 'Event Description',
					'rules' => 'trim|required'					
				),
	);

	public function get_new(){
        $bid = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $bid->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $bid;
    }

}