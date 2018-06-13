<?php

/**
 * Description of Agent_model
 *
 * @author Meet
 */
class Agent_model extends CI_Model {
    /*
     * getAll is used to retrive all record of agent table
     *
     * return two dimensional array in the form of array
     */

    public function getAll() {
        try {
            return $this->db->get('agents')->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    /*
     * insert is used to insert single record of agency in agents table of database
     *
     * @param $arr array key and value field as database field and its value
     *
     * return : int primary key, if successfully inserted
     *          bool false if not inserted
     */

    public function insert($arr) {
        try {
            $this->db->insert("agents", $arr);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return false;
        }
    }

    /*
     * insert_batch is used to insert multiple record of agent_states in agent_non_resident_licensed_state table of database
     *
     * @param $arr[][] array key and value field as database field and its value
     *
     * return : bool true if record inserted
     *          bool false if not inserted
     */

    public function insert_batch($arr) {
        try {
            $this->db->insert_batch("agent_non_resident_licensed_state", $arr);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /*
     * update is used to update record of agent
     *
     * @param $id specify primary key in agents table
     * @param $arr[][] array key and value field as database field and its value
     *
     * return : bool true if record updated
     *          bool false if not updated
     */

    public function update($id, $arr) {
        try {
            $this->db->where('id', $id);
            $this->db->update("agents", $arr);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /*
     * getAllAgentInfo is used to retrive all record of agent table with all information like name of parent agency, primary email, agent type, etc
     *
     * return two dimensional array in the form of array
     */

    public function getAllAgentInfo($id = 0) {
        try {
            $this->db->select('a.*,u.email_id,c.name as city,s.id as state_id,s.name as state,co.id as country_id,co.name as country,pa.name as parent_name,rs.name as resident_state');
            $this->db->from('agents a');
            if ($id != 0) {
                $query = "select id from {$this->db->protect_identifiers('agencies', TRUE)} WHERE parent_agency={$this->session->userdata('agency')->id}";
                $results = $this->db->query($query)->result_array();
                $ids[] = $this->session->userdata('agency')->id;
                foreach ($results as $result) {
                    $ids[] = $result['id'];
                }
                $this->db->where_in('a.agency_id', $ids);
            }
            $this->db->join('users u', 'u.id = a.user_id');
            $this->db->join('city c', 'c.id = a.city_id');
            $this->db->join('state s', 's.id = c.state_id');
            $this->db->join('country co', 'co.id = s.country_id');
            $this->db->join('agencies pa', 'pa.id = a.agency_id', 'left');
            $this->db->join('state rs', 'rs.id = a.resident_license_state_id', 'left');
            return $this->db->get()->result_array();
        } catch (Exception $e) {
            return false;
        }
    }

    /*
     * delete is used to delete single record of agent based on agent id
     *
     * @param $id int primary key of agent table
     *
     * return true if record is deleted
     *        false on failure
     */

    public function delete($id) {
        try {
            // Delete from non-resident state
            $this->db->where('agent_id', $id);
            $this->db->delete('agent_non_resident_licensed_state');

            //Delete from agent_phone
            $this->db->where('agent_id', $id);
            $this->db->delete('agent_phone');

            //Delete from User
            $this->db->select('user_id');
            $this->db->where('id', $id);
            $uid = $this->db->get('agents')->row()->user_id;
            $this->db->where('id', $uid);
            $this->db->delete('users');

            //Delete Agent
            $this->db->where('id', $id);
            if ($this->db->delete('agents')) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            return false;
        }
    }

    /*
     * getAgentInfo is used to retrive single record of agent table with all information like name of parent agency, primary email, agent type, etc
     *
     * @param $id int specify primary key of agent table
     *
     * return two dimensional array in the form of array
     */

    public function getAgentInfo($id) {
        try {
            $this->db->select('a.*,u.email_id,u.password,c.name as city,s.id as state_id,s.name as state,co.id as country_id,co.name as country,pa.name as parent_name,rs.name as resident_state');
            $this->db->from('agents a');
            $this->db->where('a.id', $id);
            $this->db->join('users u', 'u.id = a.user_id');
            $this->db->join('city c', 'c.id = a.city_id');
            $this->db->join('state s', 's.id = c.state_id');
            $this->db->join('country co', 'co.id = s.country_id');
            $this->db->join('agencies pa', 'pa.id = a.agency_id', 'left');
            $this->db->join('state rs', 'rs.id = a.resident_license_state_id', 'left');
            $agent = $this->db->get()->row();
            $this->db->select('a.state_id,s.name');
            $this->db->where('a.agent_id', $agent->id);
            $this->db->join('state s', 'a.state_id = s.id');
            $agent->non_resident_state = $this->db->get('agent_non_resident_licensed_state a')->result_array();
            return $agent;
        } catch (Exception $e) {
            return false;
        }
    }

    /*
     *
     *
     *
     */

    public function update_agent_state($id, $arr) {
        $this->db->where('agent_id', $id);
        $this->db->delete('agent_non_resident_licensed_state');
        if (count($arr) > 0) {
            $this->insert_batch($arr);
        }
    }

    /*
     * getAgentName is used to retrive agent name of agent table
     *
     * return two dimensional array in the form of array
     */

    public function getAgentName($id) {
        try {
            $this->db->select('fname,mname,lname');
            $this->db->from('agents');
            if ($id != 0) {
                $this->db->where('id', $id);
            }
            return $this->db->get()->row();
        } catch (Exception $e) {
            return false;
        }
    }

    public function update_batch($arr, $id) {
        try {
            $this->db->delete("agent_non_resident_licensed_state", array('agent_id' => $id));
            $this->db->insert_batch("agent_non_resident_licensed_state", $arr);
            //$this->db->update_batch("agency_non_resident_licensed_state",$arr,'agency_id');
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
