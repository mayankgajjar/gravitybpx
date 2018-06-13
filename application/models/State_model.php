<?php

/**
 * Description of State_model
 *
 * @author rashish
 */
class State_model extends CI_Model {
    /*
     * getAll is used to retrive all record of state table
     * 
     * return two dimensional array in the form of array
     */

    public function getAll() {
        try {
            $this->db->order_by('name','asc');
            return $this->db->get('state')->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    /*
     * getStateByCountryId is used to retrive state of particular country
     * 
     * @param $cid int specify country id
     * 
     * return two dimensional array in the form of array
     */

    public function getStateByCountryId($cid) {
        try {
            $this->db->where('country_id', $cid);
            return $this->db->get('state')->result_array();
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function getCountryByStateId($cid) {
        try {
            $this->db->where('id', $cid);
            $res = $this->db->get('state')->result_array();
            return $res;
        } catch (Exception $e) {
            return false;
        }
    }
    
    
    /*
     * getStateByCityName is used to retrive state for state table
     * 
     * return two dimensional array in the form of array
     */

    public function getStateIdByCityName($bank_city_name) {
        try {
            $this->db->select('state_id');
            $this->db->where('name', $bank_city_name);
            return $this->db->get('city')->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

}
