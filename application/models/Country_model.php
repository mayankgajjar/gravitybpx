<?php
/**
 * Description of country_model
 *
 * @author rashish
 */
class Country_model extends CI_Model
{
    /*
     * getAll is used to retrive all record of country table
     * 
     * return two dimensional array in the form of array
     */
    public function getAll()
    {
        try
        {
            return $this->db->get('country')->result_array();
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    
    
    /*
     * getCountryIdByStateId is used to retrive country for country table
     * 
     * return two dimensional array in the form of array
     */
    public function getCountryIdByStateId($bank_state_id)
    {
        try
        {
            $this->db->select('id');
            $this->db->where('id',$bank_state_id);
            return $this->db->get('state')->result_array();
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}
