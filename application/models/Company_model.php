<?php
/**
 * Description of Company_model
 *
 * @author Meet
 */
class Company_model extends CI_Model
{
    /*
     * getAll is used to retrive all record of company table
     * 
     * return two dimensional array in the form of array
     */
    public function getAll()
    {
        try
        {                    
            
            $prodcuts = $this->db->query("SELECT * FROM company");        
            return $prodcuts->result_array();            
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /*
     * insert is used to insert single record of comapny in comapny table of database
     * 
     * @param $arr array key and value field as database field and its value
     * 
     * return : bool true, if successfully inserted
     *          bool false if not inserted
     */
    public function insert($arr)
    {
        try
        {
            return $this->db->insert("company",$arr);            
        }
        catch (Exception $e)
        {
            return false;
        }
    }
  

    /*
     * getById is used to retrive record by perticular id of company table
     * 
     * return two dimensional array in the form of array
     */
    public function getById($id="")
    {        
        try
        {                                
            $prodcuts = $this->db->query("SELECT * FROM company WHERE id = ".$id);        
           return $prodcuts->row();                
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /*
     * delete is used to delete single record of company based on company id
     * 
     * @param $id int primary key of comapny table
     *
     * return true if record is deleted
     *        false on failure
     */
    public function delete($id)
    {
        try
        {
            
            return $this->db->query("DELETE FROM company WHERE id=".$id);                    
        }
        catch(Exception $ex)
        {
            return false;
        }
    }


    /*
     * update is used to update single record of company in company table of database
     * 
     * @param $arr array key and value field as database field and its value
     * @param $id field as company id

     * return : bool true if successfully updated
     *          bool false if not inserted
     */
    public function update($arr,$company_id)
    {
        try
        {
            $this->db->where('id',$company_id);
            return $this->db->update('company',$arr);                            
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public function viewAllCompanyObject() {
        $query = "SELECT company_name as text,id FROM company ORDER BY id ASC ";
        $list = $this->db->query($query);
        return $list->result();
    }
}
