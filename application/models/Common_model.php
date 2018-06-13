<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Common_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Login Validate User Credentials
     * @return type
     */
    public function validate() {
        $username = $this->security->xss_clean($this->input->post('email'));
        $password = $this->security->xss_clean($this->input->post('password'));
        $this->db->select('*');
        $this->db->where('active', 1);
        $this->db->where('email', $username);
        $this->db->or_where('username', $username);
        $this->db->where('password', hashPassword($password));
        $q = $this->db->get('users');
        return $q->row();
    }

    /**
     * Login Validate Admin Credentials
     * @return type
     */
    public function adminValidate() {
        // grab user input
        $email = $this->security->xss_clean($this->input->post('email'));
        $pass = $this->security->xss_clean($this->input->post('password'));
        $password = hashPassword($pass);
        $sql = "SELECT * FROM users WHERE (email='$email' OR username='$email' ) AND password='$password' AND user_group_id='1' AND active='1'";
        $result = $this->db->query($sql);
        return $result->row();
    }

    /**
     * Check if the username exits
     */
    public function checkUser($username) {
        $sql = "SELECT * FROM users WHERE username='" . $username . "'";
        $result = $this->db->query($sql);
        return $result->row();
    }

    /**
     * Check if the username exits
     */
    public function checkUserEmail($email) {
        $sql = "SELECT * FROM users WHERE email='" . $email . "'";
        $result = $this->db->query($sql);
        return $result->row();
    }

    /**
     * Common Add function
     * @param type $data
     * @param type $table
     * @return type
     */
    public function add($data, $table) {
        if ($this->db->insert($table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Common Multiple Add function
     * @param type $data
     * @param type $table
     * @return type
     */
    public function multipleadd($data, $table) 
    {        
        if ($this->db->insert_batch($table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Common Edit function
     * @param type $id
     * @param type $data
     * @param type $table
     * @return type
     */
    public function edit($id, $data, $table) {
        $this->db->where('id', $id);
        if ($this->db->update($table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * custom edit_custom function
     * @param type $id
     * @param type $data
     * @param type $table
     * @return type
     */
    public function edit_custom($condition, $data, $table) {
        $this->db->where($condition);
        if ($this->db->update($table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Common View (List) function
     */
    public function viewAll($table, $limit) {
        $query = "SELECT * FROM " . $table . " " . $limit;
        $list = $this->db->query($query);
        return $list->result_array();
    }

    /**
     * Common View (List) function
     */
    public function viewAllObject($table, $limit) {
        $query = "SELECT * FROM " . $table . " " . $limit;
        $list = $this->db->query($query);
        return $list->result();
    }
    
    /**
     * Common View by Id function
     * @param type $id
     * @param type $table
     * @return type
     */
    public function view($id, $table) {
        $query = "SELECT * FROM " . $table . " where id='" . $id . "'";
        $list = $this->db->query($query);
        return $list->row();
    }

    /**
     * Custom View by function
     * @param type $id
     * @param type $table
     * @return type
     */
    public function view_custom($condition, $table) {       
        $query = "SELECT * FROM " . $table . " where " . $condition;        
        $list = $this->db->query($query);
        return $list->row();
    }

    /**
     * Common Delete function
     * @param type $id
     * @param type $table
     * @return boolean
     */
    public function delete($id, $table) {
        $this->db->delete($table, array('id' => $id));
        return true;
    }

    /**
     * Common Delete All function
     * @param type $id
     * @param type $table
     * @return boolean
     */
    public function deleteAll($value, $field, $table) {
        $query = "DELETE FROM " . $table . " WHERE " . $field . "='" . $value . "'";
        $this->db->query($query);
        return true;
    }

    /**
     * Multiple Delete Function
     * @param type $ids
     * @param type $table
     * @param type $field
     * @return boolean
     */
    public function deleteMultiple($ids, $table, $field = 'id') {
        $query = "DELETE FROM " . $table . " WHERE " . $field . " in (" . $ids . ")";
        $this->db->query($query);
        return true;
    }

    /**
     * Common Delete By Condtion function
     * @param type $table
     * @param type $condition
     * @return boolean
     */
    public function deleteByCondition($table, $condition) {
        $query = "DELETE FROM " . $table . " WHERE " . $condition;
        $this->db->query($query);
        return true;
    }

    /**
     * Get Last Inserted Id
     * @param type $table
     * @return type
     */
    public function getLastInsertId($table) {
        $insert_id = $this->db->insert_id($table);
        return $insert_id;
    }

    /**
     * Get last record of the table
     * @param type $table
     * @return type
     */
    public function getLastRecordId($table) {
        $query = "SELECT id FROM " . $table . " ORDER BY id DESC LIMIT 1";
        $result = $this->db->query($query);
        return $result->row();
    }

    /**
     * Update by Id Field function 
     * @param type $id
     * @param type $fieldname
     * @param type $value
     * @param type $table
     */
    public function updateField($id, $fieldname, $value, $table) {
        $query = "update " . $table . " set " . $fieldname . "='" . $value . "' where id=" . $id;
        if ($this->db->query($query)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update by Id Field function 
     * @param int $id
     * @param str $fieldname to be updated
     * @param str $value to be updated
     * @param str $key1 reference field
     * @param str $val1 reference's fields value
     * @param type $table
     */
    public function updateFieldByKey($key1, $val1, $fieldname, $value, $table) {
        $query = "update " . $table . " set " . $fieldname . "='" . $value . "' where `$key1`='" . $val1 . "'";
//        echo $query . "<br/>";
        if ($this->db->query($query)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get field by Id
     */
    public function getFieldById($id, $field, $table) {
        $query = "select " . $field . " from " . $table . " where id=" . $id;
        $result = $this->db->query($query);
        return $result->row_array();
    }

    /**
     * Return Array of result matching particular condition
     */
    public function getArrayByCondition($value, $fieldname, $table, $condition) {
        $query = "select * from " . $table . " where " . $fieldname . "='" . $value . "' " . $condition;
        $result = $this->db->query($query);
        return $result->result_array();
    }

    /**
     * Return row of result matching particular condition
     */
    public function getRowByCondition($condition, $table) {
        $query = "select * from " . $table . " where " . $condition;
        $result = $this->db->query($query);
        return $result->row_array();
    }

    /**
     * Get No. of records for a table
     */
    public function getCount($table, $userId) {
        $query = "SELECT * FROM " . $table . " where user_id=" . $userId;
        $result = $this->db->query($query);
        return $result->num_rows();
    }

    /**
     * Get Sorted array
     */
    public function alphasort($fieldname, $table) {
        $query = "select * from " . $table . " order by " . $fieldname . " ASC";
        $result = $this->db->query($query);
        return $result->result();
    }

    /**
     * Custom Query
     * $option = 1 if return a row
     * $option = 2 if return an array
     */
    public function customQuery($query, $option) {
        $result = $this->db->query($query);
        if ($option == 1) {
            return $result->row_array();
        } else {
            return $result->result_array();
        }
    }

    /**
     * Get relational array
     * @param type $options
     * @return type
     */
    public function get($table, $options = null) {

        $default = array("fields" => "*", "conditions" => array(), "JOIN" => array(), "GROUP_BY" => array(), 'LIMIT' => array(), 'ORDER BY' => array());
        if (empty($options))
            $options = $default;
        else
            $options = array_merge($default, $options);

        $this->db->select($options["fields"]);
        $this->db->from($table);

        foreach ($options["JOIN"] as $join) {
            $this->db->join($join["table"], $join["condition"], $join["type"]);
        }
        if (!empty($options["GROUP_BY"])) {
            $this->db->group_by($options["GROUP_BY"]);
        }

        if (count($options["conditions"]) > 0 && $options['conditions'] != "") {
            $this->db->where($options["conditions"]);
        }
        if (!empty($options['LIMIT'])) {
            $this->db->limit($options['LIMIT']['start'], $options['LIMIT']['end']);
        }

        if (!empty($options['ORDER_BY']))
            $this->db->order_by($options['ORDER_BY']['field'], $options['ORDER_BY']['order']);

        $dbObj = $this->db->get();
        if ($dbObj->num_rows() > 0) {
            $data = $dbObj->result_array();
            return $data;
        } else {
            return array();
        }
    }

    /**
     *  Check if the value is unique
     */
    public function isUnique($field, $value, $table, $id = '', $cnd = "") {
        if ($id != '')
            $condition = "AND id!= $id";
        else
            $condition = $cnd;
        $query = "SELECT * FROM " . $table . " WHERE " . $field . "='" . $value . "'" . $condition;
        $result = $this->db->query($query);
        return $result->row();
    }

    /**
     * Get Next Increment Value 
     * @param type $table
     */
    public function getNextIncrementKey($table) {
        $query = "SHOW TABLE STATUS LIKE '" . $table . "'";
        $result = $this->db->query($query);
        return $result->row()->Auto_increment;
    }

    /**
     *  Get Allowed Groups to access methods
     */
    public function getAllowedGroups($controller, $action) {
        $this->db->select('allowed_groups');
        $this->db->from("user_group_permissions");
        $this->db->where('controller', $controller);
        $this->db->where('action', $action);
        $result = $this->db->get();
        return $result->row_array();
    }

}

?>
