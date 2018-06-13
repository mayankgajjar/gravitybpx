<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leadfield_m extends My_Model{

    protected $_table_name = 'lead_custom_fields';
    protected $_primary_key = 'field_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'field_id';
    protected $_timestamps = TRUE;
    
    public function get_new(){
        $lead = new stdClass();
        $coloms = $this->db->list_fields($this->_table_name);
        foreach ($coloms as $key => $colom) {
            $lead->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $lead;
    }    
    
    public function getRequiredFieldJson($leadId = NULL){
        $output = array();
        if($leadId){
            $fields = $this->get_by(array('lead_id' => $leadId));
            if($fields){
                foreach ($fields as $field) {
                     $settings = unserialize($field->field_settings);
                     if($settings['required'] == 'yes'){
                        $output[] = array(
                            'field_id' => $field->field_id
                        );
                     }
                }
            }
        }
       return json_encode($output);         
    }
}
