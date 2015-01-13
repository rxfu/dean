<?php

/**
 * 教学计划类
 */
class PlanController extends Controller {

	/**
	 * 列出当前学生的教学计划
	 *
	 * @return array         教学计划信息
	 */
	protected function index() {
		$data = DB::getInstance()->searchRecord('v_xk_jxjh', array('zy' => Session::read('spno'), 'nj' => Session::read('grade'), 'zsjj' => Session::read('season')));

		return $this->view->display('plan.index', array('plans' => $data));
	}

	/**
	 * 分页列出课程详细信息
	 *
	 * @param int     $current  当前页码
	 * @param int     $size 每页记录数
	 * @return array       课程详细信息列表
	 */
	protected function course($current = PAGE_INIT, $size = PAGE_SIZE) {
		$count = 0;
		$sql   = 'SELECT * FROM t_jx_kc_xx';

		$data            = DB::getInstance()->getPage($sql, null, $current, $size, $count);
		$data['pages']   = ceil($count / $size);
		$data['count']   = $count;
		$data['current'] = $current;

		return $this->view->display('plan.course', array('courses' => $data));
	}

	/**
	 * 列出当前学生的毕业要求
	 *
	 * @return array         毕业要求的学分数组
	 */
	protected function graduation() {
		$data         = false;
		$requirements = DB::getInstance()->searchRecord('t_jx_byyq', array('zy' => Session::read('spno'), 'nj' => Session::read('grade'), 'zsjj' => Session::read('season'), 'byfa' => Session::read('system')));

		if (is_array($requirements)) {
			foreach ($requirements as $requirement) {
				$data[$requirement['pt'] . $requirement['xz']] = $requirement['xf'];
			}
		}

		return $this->view->display('plan.graduation', array('require' => $data));
	}

}