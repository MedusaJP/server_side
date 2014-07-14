<?php
class MY_Controller extends CI_Controller {
	/**
	 * 処理成功する場合
	 * @param unknown $data
	 * @param number $result_code
	 */
	function output_json_on_succeed($data, $result_code = 200) {
		$output_data = array ();
		$output_data ["Status"] = $result_code;
		$output_data ["Result"] = $data;
		$this->output->set_content_type ( 'application/json' )->set_output ( json_encode ( $output_data ) );
	}

	/**
	 * エラーメッセージを返す
	 *
	 * @param unknown $error_msg
	 * @param number $result_code
	 */
	function output_error($error_msg, $result_code = 999) {
		$output_data = array ();
		$output_data ["Status"] = $result_code;
		$output_data ["Result"] = $data;
		$this->output->set_content_type ( 'application/json' )->set_output ( json_encode ( $output_data ) );
	}
}