<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Seat extends MY_Controller {
	public function create() {
		// パラメータ取得
		$user_id = $this->input->post ( 'user_id' );
		$shop_id = $this->input->post ( 'shop_id' );
		$freetext = $this->input->post ( 'freetext' );
		$endtime = $this->input->post ( 'endtime' );

		$this->output->set_content_type ( 'jpeg' )->set_output ( file_get_contents ( 'img/Chrysanthemum.jpg' ) );
	}
}