<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Autofund_m extends My_Model {

    protected $_table_name = 'agents_billing_auto_funding';
    protected $_primary_key = 'fund_id';
    protected $_order_by = 'fund_id';
    protected $_timestamps = FALSE;
    public $rules = array(
        'add_price' => array(
            'field' => 'add_price',
            'label' => 'Automitacally Add Price',
            'rules' => 'trim|required|greater_than[25]'
        ),
        'condition_name' => array(
            'field' => 'condition_name',
            'label' => 'Balance falls below',
            'rules' => 'trim|required'
        ),
        'card_id' => array(
            'field' => 'card_id',
            'label' => 'Credit Card',
            'rules' => 'trim|required'
        ),
    );

    public function get_new() {
        $autofund = new stdClass();
        $autofund->id = '';
        $autofund->agent_id = '';        
        $autofund->card_id = '';
        $autofund->add_price = '0.00';
        $autofund->condition_name = '0.00';
        $autofund->is_active = 'NO';
        return $autofund;
    }

}
