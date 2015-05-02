<?php

/**
 * 评教监控类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class MonitorController extends ManagerAdminController {

	/**
	 * 设置系统参数
	 * @return void
	 */
	protected function setting() {
		$data   = $this->model->getSetting();
		$year   = $data['c_nd'];
		$term   = $data['c_xq'];
		$status = $data['c_flag'];

		if (isPost()) {
			$_POST  = sanitize($_POST);
			$year   = $_POST['year'];
			$term   = $_POST['term'];
			$status = $_POST['status'];

			$this->model->clearSetting();
			$this->model->setup($year, $term, $status);
		}

		return $this->view->display('monitor.setting', array('year' => $year, 'term' => $term, 'status' => $status));
	}

	/**
	 * 初始化系统评教数据
	 * @return void
	 */
	protected function init() {
		$data = $this->model->getSetting();
		$year = $data['c_nd'];
		$term = $data['c_xq'];

		if (isPost()) {
			$_POST = sanitize($_POST);
			$year  = $_POST['year'];
			$term  = $_POST['term'];

			if (false == $this->model->initialize($year, $term)) {
				Message::add('danger', '系统初始化失败');
				return;
			}
		}

		return $this->view->display('monitor.init', array('year' => $year, 'term' => $term));
	}

	/**
	 * 列出用户信息
	 * @return void
	 */
	protected function user() {
		$users = $this->model->getUsers();

		return $this->view->display('monitor.user', array('users' => $users));
	}

	/**
	 * 新增用户
	 * @return void
	 */
	protected function adduser() {
		if (isPost()) {
			$_POST      = sanitize($_POST);
			$username   = $_POST['username'];
			$password   = $_POST['password'];
			$department = $_POST['department'];
			$role       = $_POST['role'];

			$success = $this->model->addUser($username, $password, $department, $role);
			if (!$success) {
				Message::add('danger', '新增用户失败');
				return;
			}

			return redirect('monitor.user');
		}

		return $this->view->display('monitor.adduser');
	}

	/**
	 * 修改用户
	 * @return void
	 */
	protected function moduser($uid) {
		$user = $this->model->getUser($uid);

		if (isPost()) {
			$_POST      = sanitize($_POST);
			$username   = $_POST['username'];
			$password   = $_POST['password'];
			$department = $_POST['department'];
			$role       = $_POST['role'];

			$success = $this->model->modUser($username, $password, $department, $role);
			if (!$success) {
				Message::add('danger', '新增用户失败');
				return;
			}

			return redirect('monitor.user');
		}

		return $this->view->display('monitor.moduser', array('user' => $user));
	}

	/**
	 * 删除用户
	 * @param  string $uid 用户ID
	 * @return void
	 */
	protected function deluser($uid) {
		$deleted = $this->model->delUser($uid);
		if (!$success) {
			Message::add('danger', '删除用户失败');
			return;
		}

		return redirect('monitor.user');
	}

	/**
	 * 列出学生参评率
	 * @return void
	 */
	protected function xscpl() {
		if (isPost()) {
			$_POST      = sanitize($_POST);
			$department = $_POST['department'];
			$property   = $_POST['property'];
			$table      = $this->session->get('year') . $this->session->get('term') . 't';
			switch ($_POST['order']) {
				case 'college':
					$order = 'c_jsyx';
					break;

				case 'teacher':
					$order = 'c_jsgh';
					break;

				default:
					$order = 'c_kcbh';
					break;
			}
			$data = $this->model->getXscpl($table, $department, $property, $order);
		}

		return $this->view->display('monitor.xscpl', array('department' => $department, 'property' => $property, 'order' => $order));
	}

}
