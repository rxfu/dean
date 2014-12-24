<?php

/**
 * 用户控制器
 */
class StudentController extends Controller {

	/**
	 * 登录系统
	 * @return NULL
	 */
	public function login() {
		if (isPost()) {
			$username = $_POST['username'];
			$password = $_POST['password'];

			if (empty($username) || empty($password)) {
				Session::flash('error', '用户名或密码无效');
				break;
			}

			if (!(is_numeric($username) && isset($username{11}) && !isset($username{12}))) {
				Session::flash('error', '用户名必须是12位学号');
				break;
			}

			if ($this->auth($username, $password)) {

				$info = $this->info($username);

				Session::write('name', $info['xm']);
				Session::write('college', $info['xy']);
				Session::write('speciality', $info['zy']);
				Session::write('spno', $info['zyh']);
				Session::write('grade', $info['nj']);
				Session::write('season', $info['zsjj']);
				Session::write('plan', $info['byfa']);
				Session::write('system', $info['xz']);

				$electTerm = Configuration::get('XK_SJ');
				$term      = parseTerm($electTerm);
				Session::write('year', $term['year']);
				Session::write('term', $term['term']);

				Session::flash('success', '你已经成功登录系统');

				Redirect::to('student.profile');
			} else {
				Session::flash('error', '登录失败，请检查用户名和密码是否正确');
			}
		}

		return $this->view->render('student.login');
	}

	/**
	 * 通过用户名和密码验证学生登录
	 * @param  string $username 用户名
	 * @param  string $password 密码
	 * @return boolean           验证成功为TRUE，验证失败为FALSE
	 */
	public function auth($username, $password) {
		if (is_string($username) && is_string($password)) {
			$data = DB::getInstance()->searchRecord('t_xk_xsmm', array('xh' => $username, 'mm' => hashString($password)), array('xh'));

			if (is_array($data)) {
				if (1 == count($data)) {
					$username    = $data[0]['xh'];
					$currentTime = date('Y-m-d H:i:s');

					Session::write('id', hashString($username . $currentTime));
					Session::write('username', $username);

					Logger::write(array('xh' => Session::read('username'), 'czlx' => LOG_LOGIN));

					return true;
				}
			}
		}

		return false;
	}

	/**
	 * 登出系统
	 * @return NULL
	 */
	public function logout() {
		Logger::write(array('xh' => Session::read('username'), 'czlx' => LOG_LOGOUT));
		Session::destroy();
		Redirect::to('student.login');
	}

	/**
	 * 修改密码
	 * @return boolean            修改成功为TRUE，修改失败为FALSE
	 */
	public function password() {
		if (isPost()) {
			$old       = $_POST['oldPassword'];
			$new       = $_POST['newPassword'];
			$confirmed = $_POST['confirmedPassword'];

			if (is_string($old) && is_string($new)) {

				if (($new === $confirmed) && ($old !== $new)) {
					$db = DB::getInstance();

					$data = $db->searchRecord('t_xk_xsmm', array('xh' => Session::read('username'), 'mm' => hashString($old)), array('xh'));
					if (is_array($data)) {
						if (1 == count($data)) {
							$db->updateRecord('t_xk_xsmm', array('mm' => hashString($new)), array('xh' => Session::read('username')));
							Logger::write(array('xh' => Session::read('username'), 'czlx' => LOG_CHGPWD));

							Session::flash('success', '修改密码成功');
							break;
						}
					}
				}
			}

			Session::flash('error', '修改密码失败');
		}
		return $this->view->render('student.password');
	}

	/**
	 * 根据学号获取学生基本信息
	 * @param  string $id 学号
	 * @return array     学生基本信息
	 */
	public function info($id) {
		if (is_numeric($id) && isset($id{11}) && !isset($id{12})) {
			$sql  = 'SELECT * FROM v_xk_xsjbxx WHERE xh = ?';
			$data = DB::getInstance()->getRow($sql, $id);
		}

		return $data;
	}

	/**
	 * 获取当前学生详细信息
	 * @return array 学生详细信息
	 */
	public function profile() {
		$id = Session::read('username');
		if (is_numeric($id) && isset($id{11}) && !isset($id{12})) {
			$sql  = 'SELECT * FROM v_xk_xsxx WHERE xh = ?';
			$data = DB::getInstance()->getRow($sql, $id);
		}

		return $this->view->render('student.profile', array('profile' => $data));
	}
}
