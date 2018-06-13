<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Model extends CI_Model
{
	protected $_table_name     = '';
	protected $_primary_key    = '';
	protected $_primary_filter = 'intval';
	protected $_order_by       = '';
	protected $_timestamps     = FALSE;

	/**
	 * intialize parent constructor.
	 * @return type
	 */
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * set the post data in related columns in data tables.
	 * @param type $fields
	 * @return array()
	 */
	public function array_from_post($fields)
	{
		$data = array();
		foreach($fields as $field){
			$data[$field] = $this->input->post($field);
		}
		return $data;
	}

	/**
	 * get the result set from the database table according to the passed parameter.
	 * @param type|null $id
	 * @param type|null $single
	 * @return resultset object or array of resultset
	 */
	public function get($id = NULL, $single = NULL)
	{
		if( $id != NULL ){
			$filter = $this->_primary_filter;
			$id     = $filter($id);
			$this->db->where($this->_primary_key, $id);
			$method = 'row';
		}elseif( $single == TRUE ){
			$method = 'row';
		}else{
			$method = 'result';
		}

		if(!count($this->db->order_by($this->_order_by))) {
			$this->db->order_by($this->_order_by);
		}

		return $this->db->get($this->_table_name)->$method();
	}

	/**
	 * return resultset according to the passed parameter.
	 * @param type $where
	 * @param type|bool $single
	 * @return object array()
	 */
	public function get_by($where, $single = FALSE )
	{
		$this->db->where($where);
		return $this->get(NULL, $single);
	}

	/**
	 * Save and update the data table according to the passed parameter.
	 * @param type $data
	 * @param type|null $id
	 * @return type
	 */
	public function save($data, $id = NULL)
	{
		if($this->_timestamps == TRUE){
			$now = date('Y-m-d H:i:s');
			$id || $data['created'] = $now;
			$data['modified'] = $now;
		}

		if( $id === NULL ){
			!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
			$this->db->set($data);
			$this->db->insert($this->_table_name);
			$id = $this->db->insert_id();
		}else{
			$filter = $this->_primary_filter;
			$id = $filter($id);
			$this->db->set($data);
			$this->db->where($this->_primary_key, $id);
			$this->db->update($this->_table_name);
		}
		return $id;
	}

	/**
	 * Delete record from the table according to the given parameter.
	 * @param type $id
	 * @return type
	 */
	public function delete($id)
	{
		$filter = $this->_primary_filter;
		$id = $filter($id);

		if(!$id){
			return FALSE;
		}

		$this->db->where($this->_primary_key, $id);
		$this->db->limit(1);
		return $this->db->delete($this->_table_name);

	}

	public function query($where='',$order='',$limit='')
	{
		$sql = "SELECT * FROM {$this->db->protect_identifiers($this->_table_name, TRUE)} ";

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
	/**
     * Get relational array
     * @param type $options
     * @return type
     */
    public function get_relation($table, $options = null) {
        if($table == ''){
        	$table = $this->_table_name;
        }
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
}