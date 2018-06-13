<?php
/**
 * Description of Agency_model
 *
 * @author rashish
 */
class Agency_model extends CI_Model
{
    /*
     * getAll is used to retrive all record of agency table
     *
     * return two dimensional array in the form of array
     */
    public function getAll()
    {
        try
        {
            return $this->db->get('agencies')->result_array();
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    /*
     * insert is used to insert single record of agency in agencies table of database
     *
     * @param $arr array key and value field as database field and its value
     *
     * return : int primary key, if successfully inserted
     *          bool false if not inserted
     */
    public function insert($arr)
    {
        try
        {
            $this->db->insert("agencies",$arr);
            return $this->db->insert_id();
        }
        catch (Exception $e)
        {
            return false;
        }
    }

	/*
     * insert_batch is used to insert multiple record of agency_states in agency_non_resident_licensed_state table of database
     *
     * @param $arr[][] array key and value field as database field and its value
     *
     * return : bool true if record inserted
     *          bool false if not inserted
     */
    public function insert_batch($arr)
    {
        try
        {
            $this->db->insert_batch("agency_non_resident_licensed_state",$arr);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    /*
     * update_batch is used to update multiple record of agency_states in agency_non_resident_licensed_state table of database
     *
     * @param $arr[][] array key and value field as database field and its value
     *
     * return : bool true if record inserted
     *          bool false if not inserted
     */
    public function update_batch($arr,$id)
    {
        try
        {
            $this->db->delete("agency_non_resident_licensed_state",array('agency_id' => $id));
            $this->db->insert_batch("agency_non_resident_licensed_state",$arr);
            //$this->db->update_batch("agency_non_resident_licensed_state",$arr,'agency_id');
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

	/*
     * update is used to update record of agency
     *
     * @param $id specify primary key in agencies table
     * @param $arr[][] array key and value field as database field and its value
     *
     * return : bool true if record updated
     *          bool false if not updated
     */
	public function update($id,$arr)
	{
		try
        {
			$this->db->where('id',$id);
            $this->db->update("agencies",$arr);
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
	}

	/*
     * getAllAgencyInfo is used to retrive all record of agency table with all information like name of parent agency, primary email, bank_city, etc
     *
	 * @param $pid specify parent id
	 *
     * return two dimensional array in the form of array
     */
    public function getAllAgencyInfo($pid=0)
    {
        try
        {
			$this->db->select('a.*,u.email_id,c.name as city,s.id as state_id,s.name as state,co.id as country_id,co.name as country,bc.name as bank_city,pa.name as parent_name,rs.name as resident_state');
			$this->db->from('agencies a');
			if($pid != 0)
			{
				$this->db->where('a.parent_agency',$pid);
			}
			$this->db->join('users u','u.id = a.user_id');
			$this->db->join('city c','c.id = a.city_id');
			$this->db->join('state s','s.id = c.state_id');
			$this->db->join('country co','co.id = s.country_id');
			$this->db->join('city bc','bc.id=a.bank_city_id','left');
			$this->db->join('agencies pa','pa.id = a.parent_agency','left');
			$this->db->join('state rs','rs.id = a.resident_license_state_id','left');
            return $this->db->get()->result_array();
        }
        catch(Exception $e)
        {
            return false;
        }
    }

	/*
	 * delete is used to delete single record of agency based on agency id
	 *
	 * @param $id int primary key of agency table
	 *
	 * return true if record is deleted
	 *        false on failure
	 */
	public function delete($id)
	{
		try
		{
			// Delete from non-resident state
			$this->db->where('agency_id',$id);
			$this->db->delete('agency_non_resident_licensed_state');

			//Delete from agency_phone
			$this->db->where('agency_id',$id);
			$this->db->delete('agency_phone');

			//Delete from User
			$this->db->select('user_id');
			$this->db->where('id',$id);
			$uid = $this->db->get('agencies')->row()->user_id;
			$this->db->where('id',$uid);
			$this->db->delete('users');

			//Delete Agency
			$this->db->where('id',$id);
			if($this->db->delete('agencies'))
			{
				//Checking for child Agencies
				$update_data['parent_agency'] = 0;
				$this->db->where('parent_agency',$id);
				$this->db->update('agencies',$update_data);

				//Checking for child Agents
				$up_data['agency_id'] = 0;
				$this->db->where('agency_id',$id);
				$this->db->update('agents',$up_data);

				return true;
			}
			return false;
		}
		catch(Exception $ex)
		{
			return false;
		}
	}

	/*
     * getAgencyInfo is used to retrieve all record of agency table with all information like name of parent agency, primary email, bank_city, etc
     *
	 * @param $id int specify primary key of agency table
	 *
     * return two dimensional array in the form of array
     */
    public function getAgencyInfo($id)
    {
        try
        {
			$this->db->select('a.*,u.email_id,u.password,s.country_id,s.id as state_id');
			$this->db->from('agencies a');
			$this->db->where('a.id',$id);
			$this->db->join('users u','u.id = a.user_id');
			$this->db->join('city c','c.id = a.city_id');
			$this->db->join('state s','s.id = c.state_id');
			$this->db->join('country co','co.id = s.country_id');
			$this->db->join('city bc','bc.id = a.bank_city_id','left');
			$this->db->join('state bs','bs.id = bc.state_id','left');
			$this->db->join('country bco','bco.id = bs.country_id','left');
			$this->db->join('agencies pa','pa.id = a.parent_agency','left');
			$this->db->join('state rs','rs.id = a.resident_license_state_id','left');
            $agency = $this->db->get()->row();
			/*$this->db->select('a.state_id,s.name');
			$this->db->where('a.agency_id',$agency->id);
			$this->db->join('state s','a.state_id = s.id');

			$agency->non_resident_state = $this->db->get('agency_non_resident_licensed_state a')->result_array();*/

			/*echo '<pre>';
			print_r($this->db->query("SELECT agency_id,GROUP_CONCAT(state_id SEPARATOR ',') FROM agency_non_resident_licensed_state GROUP BY agency_id")->result_array());
			echo '</pre>';
			die;*/
			$arrayvalue = array();
            if($agency->non_resident_license_state_ids != "")
            {
               foreach (explode(',',$agency->non_resident_license_state_ids) as $key => $value)
               {
                  $arrayvalue[] = $this->db->query("SELECT id as state_id,name FROM state WHERE id = $value")->row_array();
               }
            }
            $agency->non_resident_state = $arrayvalue;

			$agency->downline = $this->getDownlineAgency($id);
			$agency->downline_agent = $this->getDownlineAgent($id);

			return $agency;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

	/*
	 * getDownlineAgency is used to get all downline agency information according to parent agency
	 *
	 * @param int $id specidy parent agency id
	 *
	 * @return two dimensional array with downline agency
	 */
	public function getDownlineAgency($id)
	{
		$this->db->select('a.id,a.name,u.created_at,a.resident_license_number,a.non_resident_license_state_ids,rs.name as resident_state');
		$this->db->from('agencies a');
		$this->db->where('a.parent_agency',$id);
		$this->db->join('users u','u.id = a.user_id');
		$this->db->join('state rs','rs.id = a.resident_license_state_id','left');
		$agencies = $this->db->get()->result_array();

		foreach ($agencies as $key => $value)
		{
			$arrayvalue = array();
			if($value['non_resident_license_state_ids'] != "")
	        {

	           foreach (explode(',',$value['non_resident_license_state_ids']) as $key1 => $value1)
	           {
	              $arrayvalue[] = $this->db->query("SELECT id as state_id,name FROM state WHERE id = $value1")->row_array();
	           }
	        }
	        $agencies[$key]['non_resident_state'] = $arrayvalue;
		}

		/*for($i = 0;$i < count($agencies); ++$i)
		{
			$this->db->select('a.state_id,s.name');
			$this->db->where('a.agency_id',$agencies[$i]['id']);
			$this->db->join('state s','a.state_id = s.id');

			$agencies[$i]['non_resident_state'] = $this->db->get('agency_non_resident_licensed_state a')->result_array();
		}
		echo '<pre>';
		print_r($agencies);
		echo '</pre>';
		die;*/
		return $agencies;
	}

	/*
	 * getDownlineAgent is used to get all downline agent information according to parent agency
	 *
	 * @param int $id specidy parent agency id
	 *
	 * @return two dimensional array with downline agent
	 */
	public function getDownlineAgent($id)
	{
		$this->db->select('a.id,a.fname,a.lname,u.created_at,a.resident_license_number,a.non_resident_license_state_ids,rs.name as resident_state');
		$this->db->from('agents a');
		$this->db->where('a.agency_id',$id);
		$this->db->join('users u','u.id = a.user_id');
		$this->db->join('state rs','rs.id = a.resident_license_state_id','left');
		$agents = $this->db->get()->result_array();

		/*echo '<pre>';
		print_r($this->db->query("SELECT agent_id,GROUP_CONCAT(state_id SEPARATOR ',') FROM agent_non_resident_licensed_state GROUP BY agent_id")->result_array());
		echo '</pre>';
		die;*/

		//$arrayvalue = array();
		foreach ($agents as $key => $value)
		{
			$arrayvalue = array();
			if($value['non_resident_license_state_ids'] != "")
	        {

	           foreach (explode(',',$value['non_resident_license_state_ids']) as $key1 => $value1)
	           {
	              $arrayvalue[] = $this->db->query("SELECT id as state_id,name FROM state WHERE id = $value1")->row_array();
	           }
	        }
	        $agents[$key]['non_resident_state'] = $arrayvalue;
		}

		/*for($i = 0;$i < count($agents); ++$i)
		{
			$this->db->select('a.state_id,s.name');
			$this->db->where('a.agent_id',$agents[$i]['id']);
			$this->db->join('state s','a.state_id = s.id');

			$agents[$i]['non_resident_state'] = $this->db->get('agent_non_resident_licensed_state a')->result_array();
		}*/

		/*echo '<pre>';
		print_r($agents);
		echo '</pre>';
		die;*/
		return $agents;
	}

	/*
     * getAllSubAgencyByParentAgency is used to retrive all record of agency table
     *
     * return two dimensional array in the form of array
     */
    public function getAllSubAgencyByParentAgency($id)
    {
        try
        {
        	$this->db->where('parent_agency',$id);
        	$this->db->or_where('id',$id);
            return $this->db->get('agencies')->result_array();
        }
        catch(Exception $e)
        {
            return false;
        }
    }

	public function get_nested ($parentId = NULL)
	{
		$agency = array();
        if($parentId || $this->session->userdata('user')->group_name == 'Agency'){
        	$parentId = $this->session->userdata('agency')->id;
    		$agency[] = (array) $this->session->userdata('agency');
            $this->db->where(array('parent_agency' => $parentId));
        }
		$this->db->order_by('id');
		$agencies = $this->db->get('agencies')->result_array();
		return array_merge($agency, $agencies);
	}
}
