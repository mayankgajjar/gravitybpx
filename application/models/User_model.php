<?php

/**
 * Description of user_model
 *
 * @author rashish
 */
class User_model extends CI_Model {

    /**
     * getUser return single user from user according to email and password
     *
     * @param string $email specify email of table user
     * @param string $psw specify passwd field of user table
     *
     * return : single row in the form of object
     *
     * @author rashish
     */
    public function getUser($email, $psw) {
        $this->db->select('u.*,ug.group_name');
        $this->db->where(array("u.email_id" => $email, "u.password" => $psw));
        $this->db->join('user_groups ug', 'ug.id = u.user_group_id');
        $result = $this->db->get('users u');
        return $result->row();
    }

    public function getUserbyid($uid) {
        $this->db->select('u.*');
        $this->db->where(array("u.id" => $uid));
        $result = $this->db->get('users u');
        return $result->row();
    }

    public function get_new($table) {
        $user = new stdClass();
        $coloms = $this->db->list_fields($table);
        foreach ($coloms as $key => $colom) {
            $user->$colom = $this->input->post($colom) ? $this->input->post($colom) : '';
        }
        return $user;
    }

    /**
     * chkUser method used to check user is authorized or not
     *
     * @param string $email specify email of table user
     * @param string $psw specify passwd field of user table
     *
     * return : true if user is valid
     * return : false if user is not valid
     *
     * @author rashish
     */
    public function chkUser($email, $psw) {
        $this->db->where(array("email_id" => $email, "password" => $psw));
        $result = $this->db->get("users");
        if ($result->num_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * getGroupidFromName is used to get group id from group name
     *
     * @param string $name specify name of group
     *
     * return : int grroup id, if found
     */

    public function getGroupidFromName($name) {
        try {
            $this->db->where("group_name", $name);
            return $this->db->get('user_groups')->row()->id;
        } catch (Exception $e) {
            return false;
        }
    }

    /*
     * insert is used to insert single record of user in users table of database
     *
     * @param $arr array key and value field as database field and its value
     *
     * return : int primary key, if successfully inserted
     *          bool false if not inserted
     */

    public function insert($arr) {
        try {
            $this->db->insert("users", $arr);
            return $this->db->insert_id();
        } catch (Exception $e) {
            return false;
        }
    }

    /*
     * getAdminFromUser_id return single record of admin according to user id
     *
     * @param $uid specify user id
     *
     * return single object of admin
     */

    public function getAdminFromUser_id($uid) {
        $this->db->where('user_id', $uid);
        return $this->db->get('admin')->row();
    }

    /*
     * getAgencyFromUser_id return single record of agency according to user id
     *
     * @param $uid specify user id
     *
     * return single object of agency
     */

    public function getAgencyFromUser_id($uid) {
        $this->db->select('a.*,c.id as cid,s.id as sid');
        $this->db->where('user_id', $uid);
        $this->db->join('city ci', 'ci.id = a.city_id');
        $this->db->join('state s', 's.id = ci.state_id');
        $this->db->join('country c', 'c.id = s.country_id');
        return $this->db->get('agencies a')->row();
    }

    /*
     * getVendorFromUser_id return single record of Vendor according to user id
     *
     * @param $uid specify user id
     *
     * return single object of Vendor
     */

    public function getVendorFromUser_id($uid) {

        $this->db->where('user_id', $uid);
        return $this->db->get('vendors v')->row();
    }

    /*
     * getAgentFromUser_id return single record of agent according to user id
     *
     * @param $uid specify user id
     *
     * return single object of agent
     */

    public function getAgentFromUser_id($uid) {
        $this->db->select('a.*,ag.name as agency,c.id as cid,s.id as sid');
        $this->db->where('a.user_id', $uid);
        $this->db->join('agencies ag', 'ag.id = a.agency_id');
        $this->db->join('city ci', 'ci.id = a.city_id');
        $this->db->join('state s', 's.id = ci.state_id');
        $this->db->join('country c', 'c.id = s.country_id');
        return $this->db->get('agents a')->row();
    }

    public function changePassword($uid, $password) {
        $this->db->where('id', $uid);
        $this->db->set('password', $password);
        $this->db->update('users');
    }

    /**
     * check_email method used to check email is already exists or not.
     *
     * @param string $id specify emailid field of user table
     *
     * return : if $query->num_rows() > 0
     * 			return $query->result_array();
     * 		   if emailid alredy in exists then retrun array.
     *
     * @author Meet
     */
    public function check_email($id) {

        $this->db->select('email_id');
        $this->db->from('users');
        $this->db->where('email_id', $id);  // Also mention table name here
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function Check_Email_Exist($EmailId, $UserId = 0) {
        $this->db->from('users');
        $this->db->where('email_id', $EmailId);
        $this->db->where('id !=' . $UserId);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function updateUser($data, $id) {
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('users');
        return $id;
    }

    public function delete_user($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }

}
