<?php
class MY_Controller extends CI_Controller {
	function output_json($data, $result_code = 200) {
		$output_data = array ();
		$output_data ["Status"] = $result_code;
		$output_data["Result"] = $data;
		$this->output->set_content_type ( 'application/json' )->set_output ( json_encode ( $output_data ) );
	}
}