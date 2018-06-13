<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Card_m extends My_Model {

    protected $_table_name = 'agents_billing_cards';
    protected $_primary_key = 'card_id';
    protected $_order_by = 'card_id';
    protected $_timestamps = FALSE;
    public $rules = array(
        'card_holder_name' => array(
            'field' => 'card_holder_name',
            'label' => 'Card Name',
            'rules' => 'trim|required'
        ),
        'card_number' => array(
            'field' => 'card_number',
            'label' => 'Card Number',
            'rules' => 'trim|required|min_length[12]|max_length[16]|callback_cardnumber_validation'
        ),
        'card_exp_date' => array(
            'field' => 'card_exp_date',
            'label' => 'Card Expiration Date',
            'rules' => 'trim|required'
        ),
        'card_cvv_code' => array(
            'field' => 'card_cvv_code',
            'label' => 'Card CVV Code',
            'rules' => 'trim|required'
        ),
        'card_type' => array(
            'field' => 'card_type',
            'label' => 'Card Type',
            'rules' => 'trim|required'
        ),
    );

}
