<?php
class Seat_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}

	/**
	 * 挿入する
	 *
	 * @param unknown $data
	 */
	function insert($data) {
		$this->db->insert ( 'seat', $data );
		return $this->db->insert_id ();
	}

}