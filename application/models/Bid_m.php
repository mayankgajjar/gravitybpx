<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bid_m extends My_Model
{	
	protected $_table_name  = 'lead_bid_type';
	protected $_primary_key = 'lead_bid_id';
	protected $_order_by    = 'lead_bid_id';
	protected $_timestamps  = TRUE;
	public $rules           = array('name'=>array(
				'field' => 'name',
				'label'	=> 'Bid Name',
				'rules' => 'trim|required'
				),
				'minbid' => array(
				'field' => 'minbid',
				'label'	=> 'Min. Bid',
				'rules' => 'trim|required'					
				),
				'active' => array(
				'field' => 'active',
				'label'	=> 'Status',
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

    public function getActiveBids()	
	{
		$bids = $this->get_by(array('active' => 1 ));
		return $bids;
	}

}