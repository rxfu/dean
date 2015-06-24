<?php

/**
 * 学生控制器
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class StudentController extends StudentAdminController {

	/**
	 * 仪表盘
	 * @return void
	 */
	protected function dashboard() {
		$system  = new SystemModel();
		$message = $system->getSystemMessage();

		return $this->view->display('student.dashboard', array('message' => $message));
	}

	/**
	 * 登录系统
	 * @return NULL
	 */
	protected function login() {
		if ($this->session->get('logged')) {
			$this->session->forget();
		}
		$this->session->put('role', Config::get('user.role.student'));

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
				Logger::write(array('xh' => $this->session->get('username'), 'czlx' => Config::get('log.login')));

				$info = $this->model->getInfo($username);

				$this->session->put('id', $info['sfzh']);
				$this->session->put('name', $info['xm']);
				$this->session->put('college', $info['xy']);
				$this->session->put('speciality', $info['zy']);
				$this->session->put('spno', $info['zyh']);
				$this->session->put('grade', $info['nj']);
				$this->session->put('season', $info['zsjj']);
				$this->session->put('plan', $info['byfa']);
				$this->session->put('system', $info['xz']);
				$this->session->put('campus', $info['xqh']);

				$this->session->put('year', Setting::get('XK_ND'));
				$this->session->put('term', Setting::get('XK_XQ'));

				$this->session->put('role', Config::get('user.role.student'));
				$this->session->put('logged', true);

				$exam = new ExamModel();
				$this->session->put('examTypes', $exam->getTypes($username, $info['zyh']));

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
		Logger::write(array('xh' => $this->session->get('username'), 'czlx' => Config::get('log.logout')));
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
					$success = $this->model->validate($this->session->get('username'), $old);
					if ($success) {
						if ($this->model->changePassword($this->session->get('username'), $new)) {
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
	 * 获取当前学生详细信息
	 * @return array 学生详细信息
	 */
	protected function profile() {
		$profile = $this->model->getProfile($this->session->get('username'));
		$allow   = $this->model->isAllowedUploadPortrait();

		return $this->view->display('student.profile', array('profile' => $profile, 'allow' => $allow));
	}

	/**
	 * 获取当前学生考试照片
	 * @return integer       考试照片
	 */
	protected function portrait() {
		$file     = $this->session->get('id');
		$path     = PORTRAIT . DS;
		$portrait = $path . $file . '.jpg';
		if (file_exists($portrait)) {
			return readfile($portrait);
		} else {
			return readfile($path . 'untitled.jpg');
		}
	}

	/**
	 * 获取当前学生学历照片
	 * @return integer       学历照片
	 */
	protected function photo() {
		$file  = $this->session->get('username');
		$path  = PHOTO . DS;
		$photo = $path . $file . '.jpg';
		if (file_exists($photo)) {
			return readfile($photo);
		} else {
			return readfile($path . 'untitled.jpg');
		}
	}

	/**
	 * 上传当前学生头像
	 * @return void
	 */
	protected function upload() {
		if (!$this->model->isAllowedUploadPortrait()) {
			Error::display('现在不允许上传照片');
		}

		if (isPost()) {
			if (!isEmpty($_FILES['portrait'])) {
				$uploader = new ImageUploader(PORTRAIT);
				$mimes    = array('image/jpg', 'image/jpeg', 'image/pjpeg');

				$uploader->setFile($_FILES['portrait']);
				$uploader->setAllowedMimeTypes($mimes);
				$uploader->setMaxFileSize(Config::get('file.upload_max_filesize'));
				$uploader->setFilename($this->session->get('id'));
				$uploader->setWidth(Config::get('image.width'));
				$uploader->setHeight(Config::get('image.height'));

				$uploader->upload();
			}

			if ($this->model->isUploadedPortrait($this->session->get('id'))) {
				$this->model->setUploadedSuccess($this->session->get('username'));
				Message::add('success', '上传成功');
			} else {
				Message::add('danger', '上传失败');
			}
		}

		return $this->view->display('student.upload');
	}

	/**
	 * 学生欠费提示
	 * @return void
	 */
	protected function unpaid() {
		return $this->view->display('student.unpaid', array('name' => $this->session->get('name')));
	}

}
