<?php
class Shop_model extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	/**
	 * 店舗IDから検索する
	 *
	 * @param unknown $shop_id
	 * @return NULL
	 */
	function get_by_id($shop_id) {
		$query = $this->db->get_where ( 'shop', array (
				'id' => $shop_id
		) );

		if (count ( $query->result_array () ) > 0) {
			$result_array = $query->result_array ();
			return $result_array [0];
		}

		return NULL;
	}
}