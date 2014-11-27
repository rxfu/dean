<?php

/**
 * 用户控制器
 */
class UserController extends Controller {

	public function login() {
		if ($this->isPost()) {
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			$app = App::getInstance();

			if (empty($username) || empty($password)) {
				Session::flash('error', '用户名或密码无效');
				$app->redirect('index.php');
			}

			if (!(is_numeric($username) && isset($username{11}) && !isset($username{12}))) {
				Session::flash('error', '用户名必须是12位学号');
				$app->redirect('index.php');
			}

			if ($this->auth($username, $password)) {}
		}
	}

	public function auth($username, $password) {
		if ( is_string( $username ) && is_string( $password ) ) {
		$data = DB::getInstance()->searchRecord( TBL_STU_AUTH, array( 'xh' => $username, 'mm' => hashString( $password ) ), array( 'xh' ) );

		if ( is_array( $data ) ) {
			if ( 1 == count( $data ) ) {
				$username = $data[0]['xh'];
				$currentTime = date( 'Y-m-d H:i:s' );

				Session::write('id', App::getInstance()->hash($username . date()));
				Session::write( 'username', $username );

				Logger::write( array( 'xh' => Session::read( 'username' ), 'czlx' => LOG_LOGIN ) );

				return true;
			}
		}
	}

	return false;
	}
}