<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor_m extends My_Model {

    protected $_table_name = 'vendors';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    protected $_timestamps = TRUE;
    public $rules = array();
    public $rules_admin = array(
        'fname' => array(
            'field' => 'fname',
            'label' => 'First Name',
            'rules' => 'trim|required'
        ),
        'lname' => array(
            'field' => 'lname',
            'label' => 'Last Name',
            'rules' => 'trim|required'
        ),
//        'email_id' => array(
//            'field' => 'email_id',
//            'label' => 'Email Id',
//            'rules' => 'trim|required'
//        ),
//        'password' => array(
//            'field' => 'password',
//            'label' => 'password',
//            'rules' => 'trim|required'
//        ),
//        'cpassword' => array(
//            'field' => 'cpassword',
//            'label' => 'Confirm Password',
//            'rules' => 'trim|required'
//        ),
        'date_of_birth' => array(
            'field' => 'date_of_birth',
            'label' => 'Birth Date',
            'rules' => 'trim|required'
        ),
        'phone_number' => array(
            'field' => 'phone_number',
            'label' => 'Phone Number',
            'rules' => 'trim|required'
        ),
        'address_line_1' => array(
            'field' => 'address_line_1',
            'label' => 'Address',
            'rules' => 'trim|required'
        ),
        'city_id' => array(
            'field' => 'city_id',
            'label' => 'City',
            'rules' => 'trim|required'
        ),
        'state_id' => array(
            'field' => 'state_id',
            'label' => 'State',
            'rules' => 'trim|required'
        ),
        'country_id' => array(
            'field' => 'country_id',
            'label' => 'Country',
            'rules' => 'trim|required'
        ),
        'zip_code' => array(
            'field' => 'zip_code',
            'label' => 'Zip Code',
            'rules' => 'trim|required'
        )
    );
    public function get_new() {
        $lead = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $lead->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $lead;
    }

    //================================================
    function CheckExist($EmailId, $UserId = 0) {
        $this->db->from('users');
        $this->db->where('email_id', $EmailId);
        $this->db->where('id !=' . $UserId);
        $query = $this->db->get();
        return $query->num_rows();
    }

}
