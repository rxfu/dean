<?php

/**
 * 评教管理员控制器
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class ManagerController extends ManagerAdminController {

	/**
	 * 仪表盘
	 * @return void
	 */
	protected function dashboard() {
		return $this->view->display('manager.dashboard');
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

				$this->session->put('department', $info['user_dep']);
				$this->session->put('permission', $info['user_role']);

				$this->session->put('role', Config::get('user.role.manager'));
				$this->session->put('logged', true);

				Message::add('success', '你已经成功登录系统');

				return redirect('manager.dashboard');
			} else {
				Message::add('danger', '登录失败，请检查用户名和密码是否正确');
			}
		}

		return $this->view->display('manager.login');
	}

	/**
	 * 通过用户名和密码验证评教管理员登录
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

		return redirect('manager.login');
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
							return $this->view->display('manager.password');
						}
					}
				}
			}

			Message::add('danger', '修改密码失败');
		}
		return $this->view->display('manager.password');
	}

	/**
	 * 获取当前评教管理员详细信息
	 * @return array 评教管理员详细信息
	 */
	protected function profile() {
		$profile = $this->model->getProfile($this->session->get('username'));

		return $this->view->display('manager.profile', array('profile' => $profile));
	}

}
