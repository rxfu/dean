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
			return Redirect::to('student.unpaid');
		}
	}

	/**
	 * 判断当前学生是否欠费
	 *
	 * @return boolean     欠费为TRUE，未欠费为FALSE
	 */
	protected function unpaid() {
		$sql  = 'SELECT xh FROM t_xk_xsqf WHERE xh = ?';
		$data = DB::getInstance()->getRow($sql, Session::read('username'));

		return strcasecmp($data['xh'], Session::read('username')) ? false : true;
	}

	/**
	 * 获取当前学生可选公选课程表
	 * @return mixed 公选课程数据包
	 */
	protected function pub() {
		$sql  = 'SELECT * FROM p_xk_hqkcb(?, ?, ?, ?, ?, ?, ?, ?)';
		$data = DB::getInstance()->getAll($sql, array(Session::read('username'), Session::read('year'), Session::read('term'), Session::read('season'), Session::read('grade'), Session::read('spno'), 'T', 'B'));

		return $this->view->render('course.pub', array('courses' => $data));
	}

	/**
	 * 获取当前学生可选必修课程表
	 * @return mixed 必修课程数据包
	 */
	protected function required() {
		$sql  = 'SELECT * FROM p_xk_hqkcb(?, ?, ?, ?, ?, ?, ?, ?)';
		$data = DB::getInstance()->getAll($sql, array(Session::read('username'), Session::read('year'), Session::read('term'), Session::read('season'), Session::read('grade'), Session::read('spno'), 'T', 'B'));

		return $this->view->render('course.required', array('courses' => $data));
	}

	/**
	 * 获取当前学生可选选修课程表
	 * @return mixed 选修课程数据包
	 */
	protected function elective() {
		$sql  = 'SELECT * FROM p_xk_hqkcb(?, ?, ?, ?, ?, ?, ?, ?)';
		$data = DB::getInstance()->getAll($sql, array(Session::read('username'), Session::read('year'), Session::read('term'), Session::read('season'), Session::read('grade'), Session::read('spno'), 'T', 'B'));

		return $this->view->render('course.elective', array('courses' => $data));
	}

	/**
	 * 获取当前学生可选通识素质课程表
	 * @return mixed 通识素质课程数据包
	 */
	protected function general() {
		$sql  = 'SELECT * FROM p_xk_hqkcb(?, ?, ?, ?, ?, ?, ?, ?)';
		$data = DB::getInstance()->getAll($sql, array(Session::read('username'), Session::read('year'), Session::read('term'), Session::read('season'), Session::read('grade'), Session::read('spno'), 'T', 'B'));

		return $this->view->render('course.general', array('courses' => $data));
	}

	/**
	 * 获取当前学生可选重修课程表
	 * @return mixed 重修课程数据包
	 */
	protected function retake() {
		$sql  = 'SELECT * FROM p_xk_hqkcb(?, ?, ?, ?, ?, ?, ?, ?)';
		$data = DB::getInstance()->getAll($sql, array(Session::read('username'), Session::read('year'), Session::read('term'), Session::read('season'), Session::read('grade'), Session::read('spno'), 'T', 'B'));

		return $this->view->render('course.retake', array('courses' => $data));
	}

	/**
	 * 选择课程
	 *
	 * @return boolean       选课成功为TRUE，不成功为FALSE
	 */
	protected function elect() {
		$sql           = 'SELECT pt, xz, xl, bz, kkxy, jsgh FROM t_pk_kczy a LEFT JOIN t_xk_xsqf b ON a.kcxh = b.kcxh WHERE a.nd = ? AND a.xq = ? AND a.kcxh = ?';
		$course        = $db->getRow($sql, array($data['nd'], $data['xq'], $data['kcxh']));
		$data['pt']    = $course['pt'];
		$data['xz']    = $course['xz'];
		$data['xl']    = $course['xl'];
		$data['lb']    = null;
		$data['jsgh']  = $course['jsgh'];
		$data['sf']    = isArrearage($data['xh']);
		$data['zg']    = $course['bz'];
		$data['bz']    = 0;
		$data['tdkch'] = null;
		$data['tdyy']  = null;
		$data['qz']    = 0;
		$data['sj']    = date('Y-m-d H:i:s');
		$data['kkxy']  = $course['kkxy'];

		$sql        = 'SELECT zxf FROM t_jx_jxjh WHERE kch = ?';
		$course     = $db->getRow($sql, parseCourse($data['kcxh']));
		$data['xf'] = $course['zxf'];

		$db->insertRecord('t_xk_xkxx', $data);

		$log['xh']   = $data['xh'];
		$log['kcxh'] = $data['kcxh'];
		$log['czlx'] = LOG_INSERT;
		writeLog($log);

		return true;
	}

	/**
	 * 选课申请
	 * @return NULL 
	 */
	protected function apply() {
		if (isPost()) {
			$data['xh'] = Session::read('username');
			$data['xm'] = Session::read('name');
			$data['nd'] = Session::read('year');
			$data['xq']=Session::read('term');
			$data['kcxh'] = $_POST['cno'];
			DB::getInstance()->insertRecord('t_xk_xksq', $data);

			Logger::write(array('xh'=>Session::read('username'), 'kcxh' =>$data['kcxh'], 'czlx'=>LOG_APPLY));
		}
	}

}
