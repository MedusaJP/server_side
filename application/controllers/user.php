<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * ユーザーラクス
 *
 * @author david
 *
 */
class User extends MY_Controller {
	/**
	 * ユーザー登録
	 */
	public function apply() {
		// パラメータ取得
		$user_name = $this->input->post ( 'user_name' );
		$device_id = $this->input->post ( 'device_id' );
		$password = $this->input->post ( 'password' );
		$mailaddress = $this->input->post ( 'mailaddress' );
		$twitter_id = $this->input->post ( 'twitter_id' );

		// validation
		if (is_null ( $user_name ) || ! $user_name) {
			$this->output_error ( "パラメータ不正：ユーザー名", Constant::RESPONSE_CODE_ERROR_PAMAMETER );
			return;
		}

		if (is_null ( $device_id ) || ! $device_id) {
			$this->output_error ( "パラメータ不正：デバイスID", Constant::RESPONSE_CODE_ERROR_PAMAMETER );
			return;
		}
		if (is_null ( $password ) || ! $password) {
			$this->output_error ( "パラメータ不正：パスワード", Constant::RESPONSE_CODE_ERROR_PAMAMETER );
			return;
		}
		if (is_null ( $mailaddress ) || ! $mailaddress) {
			$this->output_error ( "パラメータ不正：メールアドレス", Constant::RESPONSE_CODE_ERROR_PAMAMETER );
			return;
		}

		// パスワード処理
		$this->load->helper ( 'security' );
		$salt = $this->get_random_string ( 20 );
		$encryption_password = do_hash ( $password . $salt, 'md5' );

		// 挿入データ
		$user_data = array ();
		$user_data ["name"] = $user_name;
		$user_data ["device_id"] = $device_id;
		$user_data ["salt"] = $salt;
		$user_data ["password"] = $encryption_password;
		$user_data ["mailaddress"] = $mailaddress;
		$user_data ["twitter_id"] = $twitter_id;
		$user_data ["created_at"] = date ( 'Y-m-d H:i:s' );

		// 挿入する
		$this->load->model ( 'User_model', 'user' );
		$insert_id = $this->user->insert ( $user_data );

		// 挿入したデータを取得する
		$insert_data = $this->user->get_by_id ( $insert_id );

		// 返却する
		$this->output_json_on_succeed ( array (
				"user" => $insert_data
		) );
	}

	/**
	 * ユーザーが存在しているかどうか
	 *
	 * @param unknown $something_id
	 * @param unknown $flg
	 */
	public function check_is_applied($something_id, $flg) {
		$this->load->model ( 'User_model', 'user' );
		$user_data = null;

		// フラグごとに取得する
		if ($flg == 1) {
			// IDでチェックする
			$user_data = $this->user->get_by_id ( $something_id );
		} else if ($flg == 2) {
			// デバイスIDでチェックする
			$user_data = $this->user->get_by_column_name ( array (
					"device_id" => $something_id
			) );
		} else if ($flg == 3) {
			// メールアドレスでチェックする
			$user_data = $this->user->get_by_column_name ( array (
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

		// エラー判定
		if (is_null ( $device_id ) || ! $device_id) {
			$this->output_error ( "パラメータ不正：デバイスID", Constant::RESPONSE_CODE_ERROR_PAMAMETER );
			return;
		}

		// ユーザー名
		$user_name = $this->input->post ( 'user_name' );

		// エラー判定
		if (is_null ( $user_name ) || ! $user_name) {
			$this->output_error ( "パラメータ不正：ユーザー名", Constant::RESPONSE_CODE_ERROR_PAMAMETER );
			return;
		}

		// データベースに挿入
		$this->load->model ( 'User_model', 'user' );
		$insert_data = array ();
		$insert_data ["name"] = $user_name;
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
	 * ユーザー情報を取得する
	 *
	 * @param unknown $user_id
	 */
	public function show($user_id) {
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

	/**
	 * ログイン
	 */
	public function login() {
		$mailaddress = $this->input->post ( 'mailaddress' );
		$password = $this->input->post ( 'password' );
		if (is_null ( $mailaddress ) || ! $mailaddress) {
			$this->output_error ( "パラメータ不正：メールアドレス", Constant::RESPONSE_CODE_ERROR_PAMAMETER );
			return;
		}

		// メールアドレスでユーザー取得する
		$this->load->model ( 'User_model', 'user' );
		$user_data = $this->user->get_by_column_name ( array (
				"mailaddress" => $mailaddress
		) );

		if (is_null ( $user_data )) {
			$this->output_error ( "このユーザーが存在していません。", Constant::RESPONSE_CODE_ERROR_NOTHING );
			return;
		}

		// 入力したパスワードと比較する
		$this->load->helper ( 'security' );
		$encryption_password = do_hash ( $password . $user_data ["salt"], 'md5' );
		if (strcmp ( $encryption_password, $user_data ["password"] ) != 0) {
			// ログイン失敗
			$this->output_json_on_succeed ( array (
					"login_succeeded" => false
			) );
			return;
		} else {
			// ログイン成功
			$this->output_json_on_succeed ( array (
					"login_succeeded" => true,
					"user" => $user_data,
			) );
		}
	}

	/**
	 * テスト
	 */
	public function test() {
		$chen = "chenfeng";
		$this->load->library ( 'encrypt' );
		print_r ( $this->encrypt->sha1 ( $chen + "chenfeng" ) );
		echo "<br>";
		print_r ( $this->encrypt->encode ( $chen ) );
	}

	/**
	 * ランダムでユーザー名を生成する
	 */
	private function get_random_string($length = 10) {
		// エラー判定
		$this->load->helper ( 'string' );
		return random_string ( 'alnum', $length );
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