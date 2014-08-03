<?php
class User_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	function getAll() {
		$query = $this->db->get ( 'user' );
		return $query->result ();
	}

	/**
	 * 挿入する
	 *
	 * @param unknown $data
	 */
	function insert($data) {
		$this->db->insert ( 'user', $data );
		return $this->db->insert_id ();
	}

	/**
	 * ユーザーIDから検索する
	 *
	 * @param unknown $user_id
	 * @return NULL
	 */
	function get_by_id($user_id) {
		$query = $this->db->get_where ( 'user', array (
				'id' => $user_id
		) );

		if (count ( $query->result_array () ) > 0) {
			$result_array = $query->result_array ();
			return $result_array[0];
		}

		return NULL;
	}

	/**
	 * 配列の条件から検索する
	 *
	 * @param unknown $user_id
	 * @return NULL
	 */
	function get_by_column_name($cond_arr) {
		$query = $this->db->get_where ( 'user', $cond_arr );

		if (count ( $query->result () ) > 0) {
			return $query->result ();
		}

		return NULL;
	}
}