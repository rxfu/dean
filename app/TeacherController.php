<?php

/**
 * 用户控制器
 */
class TeacherController extends TeacherAdminController {

	/**
	 * 仪表盘
	 * @return void
	 */
	protected function dashboard() {
		return $this->view->display('teacher.dashboard');
	}

	/**
	 * 登录系统
	 * @return NULL
	 */
	protected function login() {
		if ($this->session->get('logged')) {
			$this->session->forget();
		}

		if (isPost()) {
			$_POST = sanitize($_POST);

			$username = $_POST['username'];
			$password = $_POST['password'];

			if (empty($username) || empty($password)) {
				Message::add('danger', '用户名或密码无效');
				return;
			}

			if ($this->auth($username, $password)) {
				$info = $this->model->getProfile($username);

				$this->session->put('name', $info['xm']);
				$this->session->put('college', $info['xy']);
				$this->session->put('speciality', $info['zy']);

				$this->session->put('year', Setting::get('CJ_WEB_ND'));
				$this->session->put('term', Setting::get('CJ_WEB_XQ'));

				$this->session->put('role', Config::get('user.role.teacher'));
				$this->session->put('logged', true);

				$this->session->put('scoreCourses', $this->model->getCourses($this->session->get('year'), $this->session->get('term'), $username));
				$this->session->put('scoreTerms', $this->model->getTerms($username));

				Message::add('success', '你已经成功登录系统');

				return redirect('teacher.dashboard');
			} else {
				Message::add('danger', '登录失败，请检查用户名和密码是否正确');
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
			$success = $this->model->validate($username, $password);

			if ($success) {
				$this->session->put('username', $username);

				return true;
			}
		}

		return false;
	}

	/**
	 * 登出系统
	 * @return NULL
	 */
	protected function logout() {
		$this->session->put('logged', false);
		$this->session->forget();

		return redirect('teacher.login');
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
					$success = $this->model->validate($this->session->get('username'), $old);
					if ($success) {
						if ($this->model->changePassword($this->session->get('username'), $new)) {
							Message::add('success', '修改密码成功');
							return $this->view->display('teacher.password');
						}
					}
				}
			}

			Message::add('danger', '修改密码失败');
		}
		return $this->view->display('teacher.password');
	}

	/**
	 * 获取当前教师详细信息
	 * @return array 教师详细信息
	 */
	protected function profile() {
		$profile = $this->model->getProfile($this->session->get('username'));

		return $this->view->display('teacher.profile', array('profile' => $profile));
	}

}
