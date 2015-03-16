<?php

/**
 * 系统控制器
 */
class SystemController extends StudentAdminController {

	/**
	 * 列出选课日志
	 *
	 * @return array       选课日志列表
	 */
	protected function log() {
		$logs = $this->model->getLogs($this->session->get('username'));

		return $this->view->display('system.log', array('logs' => $logs));
	}

	/**
	 * 列出系统消息
	 *
	 * @return array       系统消息列表
	 */
	function message() {
		$messages = $this->model->getMessages($this->session->get('username'));

		return $this->view->display('system.message', array('messages' => $messages));
	}

}