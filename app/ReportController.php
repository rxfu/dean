<?php

/**
 * 成绩类
 */
class ReportController extends Controller {

	/**
	 * 列出当前学生所有成绩
	 *
	 * @return array     学生成绩
	 */
	protected function index() {
		$id   = Session::read('username');
		$data = DB::getInstance()->searchRecord('v_cj_xscj', array('xh' => $id));

		return $this->view->display('report.index', array('scores' => $data));
	}

	/**
	 * 根据年度、学期列出当前学生成绩
	 *
	 * @param string  $year 年度
	 * @param string  $term 学期
	 * @return array       学生成绩
	 */
	protected function term($year, $term) {
		$data = DB::getInstance()->searchRecord('v_cj_xscj', array('xh' => Session::read('username'), 'nd' => $year, 'xq' => $term));

		return $this->view->display('report.term', array('scores' => $data, 'year' => $year, 'term' => $term));
	}

	/**
	 * 获取成绩方式对应的组合
	 * @param  string $mid 成绩方式代码
	 * @return array      成绩方式组合，没有返回FALSE
	 */
	protected function ratio($mid) {
		$modes = DB::getInstance()->searchRecord('t_jx_cjfs', array('fs' => $mid));
		if (is_array($modes)) {
			$ratios = array();
			foreach ($modes as $mode) {
				$ratios['name']   = $mode['khmc'];
				$ratios['mode'][] = array('id' => $mode['id'], 'idm' => $mode['idm'], 'bl' => $mode['bl'] / $mode['mf']);
			}

			return $ratios;
		}

		return false;
	}

	/**
	 * 教师录入成绩
	 * @param  string $cno 课程序号
	 * @return array          学生成绩
	 */
	protected function input($cno) {
		$sql    = 'SELECT * FROM v_pk_kczyxx WHERE nd = ? AND xq = ? AND kcxh = ?';
		$course = DB::getInstance()->getRow($sql, array(Session::read('year'), Session::read('term'), $cno));

		$ratios = $this->ratio($course['cjfs']);

		$sql  = 'SELECT * FROM t_cj_lscj WHERE nd = ? AND xq = ? AND kcxh = ? ORDER BY xh';
		$data = DB::getInstance()->getAll($sql, array(Session::read('year'), Session::read('term'), $cno));

		return $this->view->display('report.input', array('info' => $course, 'scores' => $data, 'ratios' => $ratios));
	}

	/**
	 * 录入学生成绩，更新临时成绩表
	 * @param  string $cno 课程序号
	 * @return boolean         成功返回TRUE，失败返回FALSE
	 */
	protected function enter($cno) {
		if (isPost()) {
			$sno   = $_POST['sno'];
			$mode  = substr($_POST['mode'], 5);
			$score = $_POST['score'];

			$fields = array();
			$ratios = $this->mode();

			$sql   = 'SELECT * FROM t_cj_lscj WHERE nd = ? AND xq = ? AND kcxh = ? AND xh = ?';
			$item  = DB::getInstance()->getRow($sql, array(Session::read('year'), Session::read('term'), $cno, $sno));
			$total = $item['zpcj'] - $item['cj' . $mode] * Session::read('proportion.' . Session::read('grade') . '.' . $mode) + $score * Session::read('proportion.' . Session::read('grade') . '.' . $mode);

			$updated = DB::getInstance()->updateRecord('t_cj_lscj', array('cj' . $mode => $score, 'zpcj' => $total), array('nd' => $item['nd'], 'xq' => $item['xq'], 'xh' => $sno, 'kcxh' => $cno));

			if (isAjax()) {
				echo $updated ? $total : $item['zpcj'];
			}
			return $updated;
		}
	}

	/**
	 * 按年度按学期列出成绩单
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @return array       成绩单列表
	 */
	protected function summary($year, $term) {
		$sql  = 'SELECT DISTINCT kcxh, kcmc FROM t_cj_lscj WHERE nd = ? AND xq = ? AND jsgh = ?';
		$data = DB::getInstance()->getAll($sql, array($year, $term, Session::read('username')));

		return $this->view->display('report.summary', array('courses' => $data, 'year' => $year, 'term' => $term));
	}

	/**
	 * 列出课程成绩
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $cno 课程号
	 * @return array         成绩列表
	 */
	protected function score($year, $term, $cno) {
		$sql  = 'SELECT DISTINCT kch, kcmc, xy, nj, zy FROM v_pk_kczyxx WHERE nd = ? AND xq = ? AND kch = ?';
		$info = DB::getInstance()->getRow($sql, array($year, $term, $cno));

		$sql  = 'SELECT * FROM v_cj_xscj WHERE nd = ? AND xq = ? AND kch = ? ORDER BY xh';
		$data = DB::getInstance()->getAll($sql, array($year, $term, $cno));
		return $this->view->display('report.score', array('info' => $info, 'scores' => $data));
	}
}
