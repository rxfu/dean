<?php

/**
 * 系统控制器
 */
class SystemController extends Controller {

	/**
	 * 列出选课日志
	 *
	 * @return array       选课日志列表
	 */
	protected function log() {
		$sql  = 'SELECT * FROM t_xk_log WHERE xh = ? ORDER BY czsj DESC';
		$data = DB::getInstance()->getAll($sql, array(Session::read('username')));

		return $this->view->display('system.log', array('logs' => $data));
	}

	/**
	 * 列出系统消息
	 *
	 * @return array       系统消息列表
	 */
	function message() {
		$sql  = 'SELECT * FROM t_xk_dxx WHERE xh = ? ORDER BY fssj DESC';
		$data = DB::getInstance()->getAll($sql, array(Session::read('username')));

		return $this->view->display('system.message', array('messages' => $data));
	}

}