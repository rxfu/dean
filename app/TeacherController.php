<?php

/**
 * 用户控制器
 */
class TeacherController extends Controller {

	/**
	 * 登录系统
	 * @return NULL
	 */
	protected function login() {
		if (isPost()) {
			$username = $_POST['username'];
			$password = $_POST['password'];

			if (empty($username) || empty($password)) {
				Session::flash('danger', '用户名或密码无效');
				break;
			}

			if ($this->auth($username, $password)) {
				Logger::write(array('jsgh' => Session::read('username'), 'czlx' => LOG_LOGIN));

				$info = $this->info($username);

				Session::write('name', $info['xm']);
				Session::write('college', $info['xy']);
				Session::write('speciality', $info['zy']);

				$electTerm = Configuration::get('CJ_WEBSJ');
				$term      = parseTerm($electTerm);
				Session::write('year', $term['year']);
				Session::write('term', $term['term']);

				Session::write('reportCourses', $this->reportCourses($username));
				Session::write('reportTerms', $this->reportTerms($username));

				Session::flash('success', '你已经成功登录系统');

				return Redirect::to('home.teacher');
			} else {
				Session::flash('danger', '登录失败，请检查用户名和密码是否正确');
			}
		}

		return $this->view->display('teacher.login');
	}

	/**
	 * 通过用户名和密码验证教师登录
	 * @param  string $username 用户名
	 * @param  string $password 密码
	 * @return boolean           验证成功为TRUE，验证失败为FALSE
	 */
	protected function auth($username, $password) {
		if (is_string($username) && is_string($password)) {
			$data = DB::getInstance()->searchRecord('t_pk_js', array('jsgh' => $username, 'mm' => hashString($password)), array('jsgh', 'zt'));

			if (is_array($data)) {
				if (1 == count($data)) {
					if (ENABLE == $data[0]['zt']) {
						$username    = $data[0]['jsgh'];
						$currentTime = date('Y-m-d H:i:s');

						Session::write('id', hashString($username . $currentTime));
						Session::write('username', $username);

						return true;
					}
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
		Logger::write(array('jsgh' => Session::read('username'), 'czlx' => LOG_LOGOUT));
		Session::destroy();

		return Redirect::to('teacher.login');
	}

	/**
	 * 修改密码
	 * @return boolean            修改成功为TRUE，修改失败为FALSE
	 */
	protected function password() {
		if (isPost()) {
			$old       = $_POST['oldPassword'];
			$new       = $_POST['newPassword'];
			$confirmed = $_POST['confirmedPassword'];

			if (is_string($old) && is_string($new)) {

				if (($new === $confirmed) && ($old !== $new)) {
					$db = DB::getInstance();

					$data = $db->searchRecord('t_pk_js', array('jsgh' => Session::read('username'), 'mm' => hashString($old)), array('jsgh'));
					if (is_array($data)) {
						if (1 == count($data)) {
							$db->updateRecord('t_pk_js', array('mm' => hashString($new)), array('jsgh' => Session::read('username')));
							Logger::write(array('jsgh' => Session::read('username'), 'czlx' => LOG_CHGPWD));

							Session::flash('success', '修改密码成功');
							break;
						}
					}
				}
			}

			Session::flash('danger', '修改密码失败');
		}
		return $this->view->display('teacher.password');
	}

	/**
	 * 根据教师工号获取教师基本信息
	 * @param  string $id 教师工号
	 * @return array     教师基本信息
	 */
	protected function info($id) {
		if (is_numeric($id)) {
			$sql  = 'SELECT * FROM v_pk_jsxx WHERE jsgh = ?';
			$data = DB::getInstance()->getRow($sql, $id);
		}

		return $data;
	}

	/**
	 * 获取当前教师详细信息
	 * @return array 教师详细信息
	 */
	protected function profile() {
		$id = Session::read('username');
		if (is_numeric($id)) {
			$sql  = 'SELECT * FROM v_pk_jsxx WHERE jsgh = ?';
			$data = DB::getInstance()->getRow($sql, $id);
		}

		return $this->view->display('teacher.profile', array('profile' => $data));
	}

	/**
	 * 根据教师工号列出教师所上课程
	 *
	 * @param string  $id 教师工号
	 * @return array     课程数组
	 */
	protected function reportCourses($id) {
		$sql  = 'SELECT kcxh FROM t_pk_jxrw WHERE jsgh = ? AND nd = ? AND xq = ? GROUP BY kcxh ORDER BY kcxh';
		$data = DB::getInstance()->getAll($sql, array($id, Session::read('year'), Session::read('term')));

		return $data;
	}

	/**
	 * 根据教师工号列出教师授课的学期
	 *
	 * @param string  $id 学号
	 * @return array     学期数据
	 */
	protected function reportTerms($id) {
		$sql  = 'SELECT nd, xq FROM t_pk_jxrw WHERE jsgh = ? GROUP BY nd, xq ORDER BY nd, xq DESC';
		$data = DB::getInstance()->getAll($sql, $id);

		return $data;
	}

}
