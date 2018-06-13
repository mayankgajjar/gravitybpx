<?php
class Admin_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function updateAdminInfo($data,$id)
    {
        $this->db->set($data);
	$this->db->where('user_id', $id);
	$this->db->update('admin');
        return $id;
    }

    public function updateAdmin($data, $id)
    {
        $this->db->set($data);
	$this->db->where('id', $id);
	$this->db->update('users');
        return $id;        
    }

    public function getAdminInfo($user_id)
    {
        $this->db->where(array('user_id' => $user_id));
        return $this->db->get('admin')->row();
    }

    public function getAdminEmailInfo($user_id)
    {
        $this->db->where(array('id' => $user_id));
        return $this->db->get('users')->row();
    }

}