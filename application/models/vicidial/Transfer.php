<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends My_Model{
    protected $_table_name     = 'transfer_lead';
    protected $_primary_key    = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by       = 'id';
    protected $_timestamps     = TRUE;

	public function query($where='',$order='',$limit=''){
		$sql = "SELECT * FROM {$this->db->protect_identifiers($this->_table_name, TRUE)} ";
		if($this->session->userdata('user')->group_name == 'Agency'){
			$users = array();
			$agencyId = $this->session->userdata('agency')->id;
			$stmt = "SELECT vicidial_user_id FROM agencies WHERE parent_agency={$agencyId}";
			$query = $this->db->query($stmt);
			$result = $query->result_array();
			if($result){
				foreach ($result as $row) {
					$user = $this->vusers_m->get_by(array('user_id' => $row['vicidial_user_id']), TRUE);
					if($user){
						$users[] = "'".$user->user."'";
					}
				}
			}
			$stmt = "SELECT vicidial_user_id FROM agents WHERE agency_id={$agencyId}";
			$query = $this->db->query($stmt);
			$result = $query->result_array();
			if($result){
				foreach ($result as $row) {
					$user = $this->vusers_m->get_by(array('user_id' => $row['vicidial_user_id']), TRUE);
					if($user){
						$users[] = "'".$user->user."'";
					}
				}
			}
			$string = implode(',', $users);
			if($where == ''){
				$where = " WHERE agent IN({$string})";
			}else{
				$where = " AND agent IN({$string})";
			}
		}
		if( $where != '' ){
			$sql.= "{$where}";
		}

		if( $order != '' )
		    $sql.= "{$order}";
		else
			$sql.= " ORDER BY {$this->_primary_key} DESC";

		if( $limit != '' )
		    $sql.= "{$limit} ";

		$query = $this->db->query($sql);

	    if( $query->num_rows() > 0 )
	        return $query->result_array();
	    else
	        return false;
	}
}
