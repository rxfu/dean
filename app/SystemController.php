<?php

/**
 * 系统控制器
 */
class SystemController extends Controller {

	/**
	 * 分页列出选课日志
	 *
	 * @param int     $current  当前页码
	 * @param int     $size 每页记录数
	 * @return array       选课日志列表
	 */
	public function log($current = PAGE_INIT, $size = PAGE_SIZE) {
		$count = 0;
		$sql   = 'SELECT * FROM t_xk_log WHERE xh = ? ORDER BY czsj DESC';

		$data            = DB::getInstance()->getPage($sql, Session::read('username'), $current, $size, $count);
		$data['pages']   = ceil($count / $size);
		$data['count']   = $count;
		$data['current'] = $current;

		return $this->view->render('system.logger', array('logs' => $data));
	}
	
}