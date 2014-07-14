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

	/**
	 * ユーザーが存在しているかどうか
	 *
	 * @param unknown $something_id
	 * @param unknown $flg
	 */
	public function check_user($something_id, $flg) {
		$this->load->model ( 'User_model', 'user' );
		$user_data = null;

		// フラグごとに取得する
		if ($flg == 1) {
			// IDでチェックする
			$user_data = $this->user->get_by_id ( $something_id );
		} else if ($flg == 2) {
			// デバイスIDでチェックする
			$user_data = $this->user->get_by_device_id ( array (
					"device_id" => $something_id
			) );
		} else if ($flg == 3) {
			// メールアドレスでチェックする
			$user_data = $this->user->get_by_device_id ( array (
					"mailaddress" => $something_id
			) );
		}

		if (is_null ( $user_data )) {
			// 存在していない場合
			$return_date = array ();
			$return_date ["is_exist"] = false;
		} else {
			// 存在していない場合
			$return_date = array ();
			$return_date ["is_exist"] = true;
			$return_date ["user"] = $user_data;
		}
	}

	/**
	 * クイック登録
	 */
	public function quick_apply() {
		// 端末識別番号
		$device_id = $this->input->post ( 'device_id' );
		$device_id = "hogehoge";
		// エラー判定
		if (is_null ( $device_id ) || ! $device_id) {
			$this->output_error ( "パラメータ不正：デバイスID", Constant::RESPONSE_CODE_ERROR_PAMAMETER );
			return;
		}

		// データベースに挿入
		$this->load->model ( 'User_model', 'user' );
		$insert_data = array ();
		$insert_data ["name"] = $this->get_random_user_name ();
		$insert_data ["device_id"] = $device_id;
		$insert_data ["created_at"] = date ( 'Y-m-d H:i:s' );

		$insert_id = $this->user->insert ( $insert_data );

		// 挿入したデータを取得する
		$user_data = $this->user->get_by_id ( $insert_id );

		$this->output_json_on_succeed ( array (
				"user" => $user_data
		) );
	}

	/**
	 * ユーザーIDからアイコン画像を取得する
	 *
	 * @param unknown $user_id
	 */
	public function get_img_by_user_id($user_id) {
		if (is_null ( $user_id ) || ! $user_id) {
			$this->output_error ( "パラメータ不正：ユーザーID", Constant::RESPONSE_CODE_ERROR_PAMAMETER );
			return;
		} else if (! check_user_exsit ( $user_id )) {
			$this->output_json ( NULL, 100 );
			return;
		}
		// ユーザー情報を取得する
		$this->load->model ( 'User_model', 'user' );
		$user_data = $this->user->get_by_id ( $user_id );

		$this->output->set_content_type ( $user_data ["img_type"] )->set_output ( file_get_contents ( 'img/' + $user_data ["img_name"] ) );
	}
	public function test() {
		$this->load->model ( 'User_model', 'user' );
		print_r ( $this->user->get_by_id ( 1 ) );
	}

	/**
	 * ランダムでユーザー名を生成する
	 */
	private function get_random_user_name() {
		// エラー判定
		$this->load->helper ( 'string' );
		return random_string ( 'alnum', 6 );
	}

	/**
	 * ユーザーが存在しているかどうか、チェックする
	 *
	 * @param unknown $user_id
	 * @return boolean
	 */
	private function check_user_exsit($user_id) {
		$this->load->model ( 'User_model', 'user' );
		$user_data = $this->user->get_by_id ( $user_id );

		if (is_null ( $user_data )) {
			return false;
		} else {
			return true;
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */