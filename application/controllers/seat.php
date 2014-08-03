<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 席クラス
 *
 * @author david
 *
 */
class Seat extends MY_Controller {
	public function create() {
		// パラメータ取得
		$promoter_id = $this->input->post ( "promoter_id" );
		$shop_id = $this->input->post ( "shop_id" );
		$freetext = $this->input->post ( "freetext" );
		$endtime = $this->input->post ( "endtime" );

		$promoter_id = 1; // TODO
		$shop_id = 1; // TODO
		$endtime = date ( "Y-m-d H:i:s", strtotime ( date ( "Y-m-d" ) . " +5 day" ) );// TODO

		// 店舗の位置情報を取得する
		$this->load->model ( "Shop_model", "shop" );
		$shop_data = $this->shop->get_by_id ( $shop_id );

		// 席の情報を作成する
		$seat_data = array ();
		$seat_data ["shop_id"] = $shop_id;
		$seat_data ["lon"] = $shop_data ["lon"];
		$seat_data ["lat"] = $shop_data ["lat"];
		$seat_data ["promoter_id"] = $promoter_id;
		$seat_data ["applicant_id"] = "";
		$seat_data ["freetext"] = $freetext;
		$seat_data ["endtime"] = $endtime;
		$seat_data ["created_at"] = date ( 'Y-m-d H:i:s' );

		$this->load->model ( "Seat_model", "seat" );
		$seat_id = $this->seat->insert ( $seat_data );

		$this->output_json_on_succeed ( array (
				"shop" => $shop_data
		) );
	}

	/**
	 * 位置情報から席情報を取得する
	 *
	 */
	function search_seat_info_by_geo()
	{
		// パラメータ取得
		$promoter_id = $this->input->post ( "lon" );
		$shop_id = $this->input->post ( "lat" );
	}
}