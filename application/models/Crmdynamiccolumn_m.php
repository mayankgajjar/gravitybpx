<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crmdynamiccolumn_m extends My_Model
{	
	protected $_table_name  = 'crm_dynamic_column';
	protected $_primary_key = 'dynamic_id';
	protected $_order_by    = 'dynamic_id';
	protected $_timestamps  = FALSE;
	// public $rules           = array(
	// 		'name'=>array(
	// 			'field' => 'name',
	// 			'label'	=> 'Bid Name',
	// 			'rules' => 'trim|required'
	// 		),
	// );

	public function get_new(){
        $bid = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $bid->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $bid;
    }

}