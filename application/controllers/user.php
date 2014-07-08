<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class User extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * http://example.com/index.php/welcome
	 * - or -
	 * http://example.com/index.php/welcome/index
	 * - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 *
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
		$this->load->model ( 'User' );
		$data = $this->User->getAll ();
		$this->output->set_content_type ( 'application/json' )->set_output ( json_encode ( $data ) );
	}


	public function check_user($arg1) {
		echo $arg1;
	}

	/**
	 * クイック登録
	 */
	public function quick_apply() {
		// 端末識別番号
		$device_id = $this->input->post ( 'device_id' );

		// エラー判定
		if (is_null($device_id) || !$device_id) {
			$this->output_json(NULL, 100);
			return;
		}

		// データベースに挿入
		$this->load->model ( 'User_model', 'user' );
		$insert_data = array ();
		$insert_data ["device_id"] = $device_id;
		$insert_data ["created_at"] = date ( 'Y-m-d H:i:s' );

		$insert_id = $this->user->insert ( $insert_data );

		// 挿入したデータを取得する
		$user_data = $this->user->get_by_id($insert_id);

		$this->output_json(array("user" => $user_data));
	}

	public function get_img()
	{
		// ユーザーID
		$user_id = $this->input->post ( 'user_id' );

		$this->output->set_content_type ( 'jpeg' )->set_output ( file_get_contents ( 'img/Chrysanthemum.jpg' ) );
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */