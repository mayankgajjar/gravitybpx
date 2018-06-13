<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vertical_m extends My_Model {

    protected $_table_name = 'lead_campaign_category';
    protected $_primary_key = 'id';
    protected $_order_by = 'id';
    protected $_timestamps = FALSE;
    public $rules = array('cat_name' => array(
            'field' => 'cat_name',
            'label' => 'Vertical Name',
            'rules' => 'trim|required'
        ),
        'cat_slug' => array(
            'field' => 'cat_slug',
            'label' => 'Vertical Slug',
            'rules' => 'trim|required'
        ),
        'active' => array(
            'field' => 'active',
            'label' => 'Status',
            'rules' => 'trim|required'
        ),
    );

    public function get_new() {
        $verical = new stdClass();
        $verical->cat_name = $this->input->post('cat_name') ? $this->input->post('cat_name') : '';
        $verical->cat_slug = $this->input->post('cat_slug') ? $this->input->post('cat_slug') : '';
        $verical->active = $this->input->post('active') ? $this->input->post('active') : '';
        $verical->auctions = $this->input->post('auctions') ? $this->input->post('auctions') : '';
        $verical->bid = $this->input->post('bid') ? $this->input->post('bid') : '';
        $verical->is_condition = $this->input->post('is_condition') ? $this->input->post('is_condition') : '';
        $verical->condition_text = $this->input->post('condition_text') ? $this->input->post('condition_text') : '';
        $verical->filters = $this->input->post('filters') ? $this->input->post('filters') : '';
        return $verical;
    }

    public function getActiveVetical() {
        $verticales = $this->get_by(array('active' => ACTIVE));
        return $verticales;
    }

}
