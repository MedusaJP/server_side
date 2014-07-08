<?php
/**
 * APIアクセスのkeyチェック
 */
class CheckAccess {
	private $CI;

	public function __construct() {
		// CIオブジェクトを取得
		$this->CI =& get_instance();
	}

	function check_app_id() {
		print("chenfeng");
	}
}