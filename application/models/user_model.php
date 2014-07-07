<?php
class User_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function getAll()
	{
		$query = $this->db->get('user');
		return $query->result();
	}

	function insert($data)
	{
		$this->db->insert('user', $data);
		return $this->db->insert_id();
	}

	function get_by_id($user_id)
	{
		$query = $this->db->get_where('user', array('id' => $user_id));

		if(count($query->result()) > 0)
		{
			return $query->result();
		}

		return NULL;
	}
}