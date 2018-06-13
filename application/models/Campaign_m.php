<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Campaign_m extends My_Model{

    protected $_table_name = 'lead_campaign';
    protected $_primary_key = 'campaign_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'campaign_id';
    protected $_timestamps = TRUE;
    public $rules           = array();
    public $rules_admin     = array(
            'campcat' => array(
                'field' => 'campcat',
                'label' => 'Vertical',
                'rules' => 'trim|required'
            ),
            'auct_type' => array(
                'field' => 'auct_type',
                'label' => 'Auction Type',
                'rules' => 'trim|required'
            ),
            'bid_id'    => array(
                'field' => 'bid_id',
                'label' => 'Bid Type',
                'rules' => 'trim|required'
            ),
            'user_id'   => array(
                'field' => 'user_id',
                'label' => 'User Name',
                'rules' => 'trim|required'
            ),
            'name'      => array(
                'field' => 'name',
                'label' => 'Campaign Name',
                'rules' => 'trim|required'
            ),
            'max_cost'  => array(
                'field' => 'max_cost',
                'label' => 'Maximum Bid Price',
                'rules' => 'trim|required'
            ),
            'delivery_phone' => array(
                'field' => 'delivery_phone',
                'label' => 'Delivery Phone',
                'rules' => 'trim|required'
            )
        );

    public $rules_buyer    = array(
            'campcat' => array(
                'field' => 'campcat',
                'label' => 'Vertical',
                'rules' => 'trim|required'
            ),
            'auct_type' => array(
                'field' => 'auct_type',
                'label' => 'Auction Type',
                'rules' => 'trim|required'
            ),
            'bid_id'    => array(
                'field' => 'bid_id',
                'label' => 'Bid Type',
                'rules' => 'trim|required'
            ),
            'name'      => array(
                'field' => 'name',
                'label' => 'Campaign Name',
                'rules' => 'trim|required'
            ),
            'max_cost'  => array(
                'field' => 'max_cost',
                'label' => 'Maximum Bid Price',
                'rules' => 'trim|required'
            ),
            'delivery_phone' => array(
                'field' => 'delivery_phone',
                'label' => 'Delivery Phone',
                'rules' => 'trim|required'
            )
        );      

    
    public function get_new(){
        $lead = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $lead->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $lead;
    }


}
