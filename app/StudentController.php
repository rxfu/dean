<?php

/**
 * 学生控制器
 */
class StudentController extends StudentAdminController {

	/**
	 * 仪表盘
	 * @return void
	 */
	protected function dashboard() {
		$message = $this->db->getColumn('SELECT text FROM t_xt_message');
		return $this->view->display('student.dashboard', array('message' => $message));
	}

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
				return;
			}

			if (!(is_numeric($username) && isset($username{11}) && !isset($username{12}))) {
				Message::add('danger', '用户名必须是12位学号');
				return;
			}

			if ($this->auth($username, $password)) {
				Logger::write(array('xh' => $this->session->get('username'), 'czlx' => LOG_LOGIN));

				$info = $this->getInfo($username);

				$this->session->put('name', $info['xm']);
				$this->session->put('college', $info['xy']);
				$this->session->put('speciality', $info['zy']);
				$this->session->put('spno', $info['zyh']);
				$this->session->put('grade', $info['nj']);
				$this->session->put('season', $info['zsjj']);
				$this->session->put('plan', $info['byfa']);
				$this->session->put('system', $info['xz']);
				$this->session->put('campus', $info['xqh']);

				$this->session->put('year', Configuration::get('XK_ND'));
				$this->session->put('term', Configuration::get('XK_XQ'));

				$this->session->put('role', STUDENT);
				$this->session->put('logged', true);

				$this->session->put('examTypes', $this->examTypes());

				Message::add('success', '你已经成功登录系统');

				return redirect('student.dashboard');
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
			$data = $this->db->searchRecord('t_xk_xsmm', array('xh' => $username, 'mm' => encrypt($password)), array('xh'));

			if (is_array($data)) {
				if (1 == count($data)) {
					$username    = $data[0]['xh'];
					$currentTime = date('Y-m-d H:i:s');

					$this->session->put('id', encrypt($username . $currentTime));
					$this->session->put('username', $username);

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
		Logger::write(array('xh' => $this->session->get('username'), 'czlx' => LOG_LOGOUT));
		$this->session->put('logged', false);
		$this->session->forget();

		return redirect('student.login');
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
					$db = $this->db;

					$data = $db->searchRecord('t_xk_xsmm', array('xh' => $this->session->get('username'), 'mm' => encrypt($old)), array('xh'));
					if (is_array($data)) {
						if (1 == count($data)) {
							$db->updateRecord('t_xk_xsmm', array('mm' => encrypt($new)), array('xh' => $this->session->get('username')));
							Logger::write(array('xh' => $this->session->get('username'), 'czlx' => LOG_CHGPWD));

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
	protected function getInfo($id) {
		if (is_numeric($id) && isset($id{11}) && !isset($id{12})) {
			$sql  = 'SELECT * FROM v_xk_xsjbxx WHERE xh = ?';
			$data = $this->db->getRow($sql, $id);
		}

		return $data;
	}

	/**
	 * 获取当前学生详细信息
	 * @return array 学生详细信息
	 */
	protected function profile() {
		$id = $this->session->get('username');
		if (is_numeric($id) && isset($id{11}) && !isset($id{12})) {
			$sql  = 'SELECT * FROM v_xk_xsxx WHERE xh = ?';
			$data = $this->db->getRow($sql, $id);
		}

		return $this->view->display('student.profile', array('profile' => $data));
	}

	/**
	 * 获取当前学生头像
	 * @param  string $file 头像文件名
	 * @return integer       头像文件
	 */
	protected function portrait($file) {
		$sql      = 'SELECT zp FROM t_xs_zxs WHERE xh = ?';
		$portrait = $this->db->getRow($sql, $this->session->get('username'));
		$path     = PORTRAIT . DS;
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
		$data = $this->db->getAll($sql, $id);

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
		$data = $this->db->getAll($sql, $id);

		return $data;
	}

	/**
	 * 学生欠费提示
	 * @return void
	 */
	protected function unpaid() {
		return $this->view->display('student.unpaid', array('name' => $this->session->get('name')));
	}

	/**
	 * 列出当年考试类型
	 * @return array 考试类型列表
	 */
	protected function examTypes() {
		$sql = 'SELECT a.kslx, a.ksmc, b.mc AS ksdl FROM t_cj_kslxdm a LEFT JOIN t_cj_ksdl b ON a.ksdl = b.ksdl WHERE a.zt = ? ORDER BY b.ksdl, a.kslx';
		$data = $this->db->getAll($sql, ENABLE);

		$types = array();
		if (is_array($data)) {
			foreach ($data as $type) {
				$types[$type['ksdl']]=$type;
			}
		}

		return $types;
	}

}
