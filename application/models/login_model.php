<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class login_model extends CI_Model 
{
    public function check_user() 
    {
        $username = $this->input->post('email');
        $password = $this->input->post('password');
        $roles = userRoles();
        $roleIDs = array();
        foreach ($roles as $key => $val) 
        {
            if ($key == 'admin')
                $roleIDs[] = $val;
            if ($key == 'business')
                $roleIDs[] = $val;
        }
        $this->db->select('id,firstname,lastname,email,role_id,profile_image');
        $this->db->where_in('role_id', $roleIDs);
        $this->db->where('email', $username);
        $this->db->where('password', hashPassword($password));
        $q = $this->db->get('users');
        return $q->row_array();
    }

    /* Get Admin data by ID */

    public function getAdminByID($id) 
    {
        $roles = userRoles();
        $roleIDs = array();
        foreach ($roles as $key => $val) 
        {
            if ($key == 'admin')
                $roleIDs[] = $val;
            if ($key == 'business')
                $roleIDs[] = $val;
        }
        $this->db->select('*');
        $this->db->where_in('role_id', $roleIDs);
        $this->db->where('id', $id);

        $q = $this->db->get('users');
        return $q->row_array();
    }

    /* Change Admin Password */

    public function changePassword($password, $id) 
    {
        $this->db->set('password', hashPassword($password));
        $this->db->where('id', $id);
        $this->db->update('users');
        return true;
    }

    /* To check email already exist or ont in database */

    public function checkEmailExist($email, $id = '') 
    {
        $this->db->select('firstname,lastname,email');
        if ($id != '')
            $this->db->where('id !=', $id);
        $this->db->where('email', $email);
        $q = $this->db->get('users');
        return $q->row_array();
    }

    /* Update admin data (In Update Profile) */

    public function updateAdminData($data, $id) 
    {
        $this->db->where('id', $id);
        if ($this->db->update('users', $data))
            return TRUE;
        else
            return FALSE;
    }
}
?>