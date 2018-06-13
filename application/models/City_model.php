<?php
/**
 * Description of City_model
 *
 * @author rashish
 */
class City_model extends CI_Model
{
    /*
     * getAll is used to retrive all record of city table
     * 
     * return two dimensional array in the form of array
     */
    public function getAll()
    {
        try
        {
            return $this->db->get('city')->result_array();
        }
        catch(Exception $e)
        {
            return false;
        }
    }
    
    /*
     * getCityByStateId is used to retrive city of particular state
     * 
     * @param $sid int specify state id
     * 
     * return two dimensional array in the form of array
     */
    public function getCityByStateId($sid)
    {
        try
        {
            $this->db->where('state_id',$sid);
            return $this->db->get('city')->result_array();
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function getCity($cid)
    {
        $this->db->where(array('id' => $cid));
        return $this->db->get('city')->row();
    }
}