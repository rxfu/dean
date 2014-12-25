<?php

/**
 * 课程类
 */
class CourseController extends Controller {

	/**
	 * 继承自基类before函数
	 * @return NULL
	 */
	protected function before() {
		parent::before();

		if ($this->unpaid()) {
			Redirect::to('course.unpaid');
		}
	}

	/**
	 * 判断当前学生是否欠费
	 *
	 * @return boolean     欠费为TRUE，未欠费为FALSE
	 */
	public function unpaid() {
		$sql  = 'SELECT xh FROM t_xk_xsqf WHERE xh = ?';
		$data = $db->getRow($sql, Session::read('username'));

		return strcasecmp($data['xh'], Session::read('username')) ? false : true;
	}

	/**
	 * 获取当前学生可选公选课程表
	 * @return mixed 公选课程数据包
	 */
	public function pub() {
		$sql  = 'SELECT * FROM p_xk_hqkcb(?, ?, ?, ?, ?, ?, ?, ?)';
		$data = DB::getInstance()->getAll($sql, array(Session::read('username'), Session::read('year'), Session::read('term'), Session::read('season'), Session::read('grade'), Session::read('spno'), 'T', 'B'));

		return $this->view->render('course.pub', array('courses' => $data));
	}

	/**
	 * 获取当前学生可选必修课程表
	 * @return mixed 必修课程数据包
	 */
	public function required() {
		$sql  = 'SELECT * FROM p_xk_hqkcb(?, ?, ?, ?, ?, ?, ?, ?)';
		$data = DB::getInstance()->getAll($sql, array(Session::read('username'), Session::read('year'), Session::read('term'), Session::read('season'), Session::read('grade'), Session::read('spno'), 'T', 'B'));

		return $this->view->render('course.required', array('courses' => $data));
	}

	/**
	 * 获取当前学生可选选修课程表
	 * @return mixed 选修课程数据包
	 */
	public function elective() {
		$sql  = 'SELECT * FROM p_xk_hqkcb(?, ?, ?, ?, ?, ?, ?, ?)';
		$data = DB::getInstance()->getAll($sql, array(Session::read('username'), Session::read('year'), Session::read('term'), Session::read('season'), Session::read('grade'), Session::read('spno'), 'T', 'B'));

		return $this->view->render('course.elective', array('courses' => $data));
	}

	/**
	 * 获取当前学生可选通识素质课程表
	 * @return mixed 通识素质课程数据包
	 */
	public function general() {
		$sql  = 'SELECT * FROM p_xk_hqkcb(?, ?, ?, ?, ?, ?, ?, ?)';
		$data = DB::getInstance()->getAll($sql, array(Session::read('username'), Session::read('year'), Session::read('term'), Session::read('season'), Session::read('grade'), Session::read('spno'), 'T', 'B'));

		return $this->view->render('course.general', array('courses' => $data));
	}

	/**
	 * 获取当前学生可选重修课程表
	 * @return mixed 重修课程数据包
	 */
	public function retake() {
		$sql  = 'SELECT * FROM p_xk_hqkcb(?, ?, ?, ?, ?, ?, ?, ?)';
		$data = DB::getInstance()->getAll($sql, array(Session::read('username'), Session::read('year'), Session::read('term'), Session::read('season'), Session::read('grade'), Session::read('spno'), 'T', 'B'));

		return $this->view->render('course.retake', array('courses' => $data));
	}

}