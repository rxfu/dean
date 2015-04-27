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

	protected function init() {
		if (isPost()) {
			
		}
	}

}
