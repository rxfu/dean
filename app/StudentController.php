<?php

/**
 * 学生控制器
 */
class StudentController extends StudentAdminController {

	/**
	 * 登录系统
	 * @return NULL
	 */
	protected function login() {
		if (isPost()) {
			$_POST = sanitize($_POST);

			$username = $_POST['username'];
			$password = $_POST['password'];

			if (empty($username) || empty($password)) {
				Message::add('danger', '用户名或密码无效');
				break;
			}

			if (!(is_numeric($username) && isset($username{11}) && !isset($username{12}))) {
				Message::add('danger', '用户名必须是12位学号');
				break;
			}

			if ($this->auth($username, $password)) {
				Logger::write(array('xh' => Session::get('username'), 'czlx' => LOG_LOGIN));

				$info = $this->info($username);

				Session::set('name', $info['xm']);
				Session::set('college', $info['xy']);
				Session::set('speciality', $info['zy']);
				Session::set('spno', $info['zyh']);
				Session::set('grade', $info['nj']);
				Session::set('season', $info['zsjj']);
				Session::set('plan', $info['byfa']);
				Session::set('system', $info['xz']);
				Session::set('campus', $info['xqh']);

				Session::set('year', Configuration::get('XK_ND'));
				Session::set('term', Configuration::get('XK_XQ'));

				Session::set('role', STUDENT);

				Session::set('courseTerms', $this->courseTerms($username));
				Session::set('reportTerms', $this->reportTerms($username));

				Message::add('success', '你已经成功登录系统');

				return Redirect::to('home.student');
			} else {
				Message::add('danger', '登录失败，请检查用户名和密码是否正确');
			}
		}

		return $this->view->display('student.login');
	}

	/**
	 * 通过用户名和密码验证学生登录
	 * @param  string $username 用户名
	 * @param  string $password 密码
	 * @return boolean           验证成功为TRUE，验证失败为FALSE
	 */
	protected function auth($username, $password) {
		if (is_string($username) && is_string($password)) {
			$data = DB::getInstance()->searchRecord('t_xk_xsmm', array('xh' => $username, 'mm' => encrypt($password)), array('xh'));

			if (is_array($data)) {
				if (1 == count($data)) {
					$username    = $data[0]['xh'];
					$currentTime = date('Y-m-d H:i:s');

					Session::set('id', encrypt($username . $currentTime));
					Session::set('username', $username);

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
	protected function logout() {
		Logger::write(array('xh' => Session::get('username'), 'czlx' => LOG_LOGOUT));
		Session::destroy();

		return Redirect::to('student.login');
	}

	/**
	 * 修改密码
	 * @return boolean            修改成功为TRUE，修改失败为FALSE
	 */
	protected function password() {
		if (isPost()) {
			$_POST = sanitize($_POST);
			
			$old       = $_POST['oldPassword'];
			$new       = $_POST['newPassword'];
			$confirmed = $_POST['confirmedPassword'];

			if (is_string($old) && is_string($new)) {

				if (($new === $confirmed) && ($old !== $new)) {
					$db = DB::getInstance();

					$data = $db->searchRecord('t_xk_xsmm', array('xh' => Session::get('username'), 'mm' => encrypt($old)), array('xh'));
					if (is_array($data)) {
						if (1 == count($data)) {
							$db->updateRecord('t_xk_xsmm', array('mm' => encrypt($new)), array('xh' => Session::get('username')));
							Logger::write(array('xh' => Session::get('username'), 'czlx' => LOG_CHGPWD));

							Message::add('success', '修改密码成功');
							return $this->view->display('student.password');
						}
					}
				}
			}

			Message::add('danger', '修改密码失败');
		}
		return $this->view->display('student.password');
	}

	/**
	 * 根据学号获取学生基本信息
	 * @param  string $id 学号
	 * @return array     学生基本信息
	 */
	protected function info($id) {
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
	protected function profile() {
		$id = Session::get('username');
		if (is_numeric($id) && isset($id{11}) && !isset($id{12})) {
			$sql  = 'SELECT * FROM v_xk_xsxx WHERE xh = ?';
			$data = DB::getInstance()->getRow($sql, $id);
		}

		return $this->view->display('student.profile', array('profile' => $data));
	}

	/**
	 * 获取当前学生头像
	 * @param  string $file 头像文件名
	 * @return integer       头像文件
	 */
	protected function portrait($file) {
		$sql = 'SELECT zp FROM t_xs_zxs WHERE xh = ?';
		$portrait = DB::getInstance()->getRow($sql, Session::get('username'));
		$path     = PORTRAIT . DS;;
		if (ENABLE == $portrait['zp']) {
			return readfile($path . $file . '.jpg');
		} else {
			return readfile($path . 'untitled.jpg');
		}
	}

	/**
	 * 根据学号列出学生具有课程的学期
	 *
	 * @param string  $id 学号
	 * @return array     年度学期数组
	 */
	protected function courseTerms($id) {
		$sql  = 'SELECT nd, xq FROM t_xk_xkxx WHERE xh = ? GROUP BY nd, xq ORDER BY nd DESC, xq DESC';
		$data = DB::getInstance()->getAll($sql, $id);

		return $data;
	}

	/**
	 * 根据学号列出学生具有成绩的学期
	 *
	 * @param string  $id 学号
	 * @return array     年度学期数组
	 */
	protected function reportTerms($id) {
		$sql  = 'SELECT nd, xq FROM t_cj_zxscj WHERE xh = ? GROUP BY nd, xq ORDER BY nd DESC, xq DESC';
		$data = DB::getInstance()->getAll($sql, $id);

		return $data;
	}

	/**
	 * 学生欠费提示
	 * @return void
	 */
	protected function unpaid() {
		return $this->view->display('student.unpaid');
	}

}
