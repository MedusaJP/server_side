<?php
class MY_Controller extends CI_Controller {
	/**
	 * 処理成功する場合
	 *
	 * @param unknown $data
	 */
	function output_json_on_succeed($data) {
		$output_data = array ();
		$output_data ["Status"] = Constant::RESPONSE_CODE_SUCCEED;
		$output_data ["Result"] = $data;
		$this->output->set_content_type ( 'application/json' )->set_output ( json_encode ( $output_data ) );
	}

	/**
	 * エラーメッセージを返す
	 *
	 * @param unknown $error_msg
	 * @param unknown $result_code
	 */
	function output_error($error_msg, $result_code = Constant::RESPONSE_CODE_ERROR_UNKOWN) {
		$output_data = array ();
		$output_data ["Status"] = $result_code;
		$output_data ["Result"] = $data;
		$this->output->set_content_type ( 'application/json' )->set_output ( json_encode ( $output_data ) );
	}
}