<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filter_m extends My_Model
{	
	protected $_table_name  = 'lead_campaign_filter';
	protected $_primary_key = 'filter_id';
	protected $_order_by    = 'filter_id';
	protected $_timestamps  = TRUE;
	public $rules           = array(
			'name' => array(
				'field' => 'name',
				'label' => 'Field Name',
				'rules' => 'trim|required'
			),
			'filter_group' => array(
				'field' => 'filter_group',
				'label' => 'Group Name',
				'rules' => 'trim|required'
			),
			'filter_label' => array(
				'field' => 'filter_label',
				'label' => 'Label Text',
				'rules' => 'trim|required',
			),
			'filter_value' => array(
				'field' => 'filter_value',
				'label' => 'Filter value',
				'rules' => 'trim|required',
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