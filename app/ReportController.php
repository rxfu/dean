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
	 * 教师录入成绩
	 * @param  string $cno 课程序号
	 * @return array          学生成绩
	 */
	protected function input($cno) {
		$sql    = 'SELECT * FROM v_pk_kczyxx WHERE nd = ? AND xq = ? AND kcxh = ?';
		$course = DB::getInstance()->getRow($sql, array(Session::read('year'), Session::read('term'), $cno));

		$grades = array();
		$items  = DB::getInstance()->searchRecord('t_jx_cjfs', array('fs' => $course['cjfs']));
		foreach ($items as $item) {
			$grades['name']   = $item['khmc'];
			$grades['mode'][] = array('id' => $item['id'], 'idm' => $item['idm']);
			Session::write('grade', $item['fs']);
			Session::write('proportion.' . $item['fs'] . '.' . $item['id'], $item['bl'] / $item['mf']);
		}

		$sql  = 'SELECT * FROM t_cj_lscj WHERE nd = ? AND xq = ? AND kcxh = ?';
		$data = DB::getInstance()->getAll($sql, array(Session::read('year'), Session::read('term'), $cno));

		return $this->view->display('report.input', array('course' => $course, 'scores' => $data, 'grades' => $grades));
	}

	/**
	 * 录入学生成绩，更新临时成绩表
	 * @param  string $cno 课程号
	 * @return boolean         成功返回TRUE，失败返回FALSE
	 */
	protected function enter($cno) {
		if (isPost()) {
			$sno   = $_POST['sno'];
			$mode  = $_POST['mode'];
			$score = $_POST['score'];

			$sql   = 'SELECT * FROM t_cj_lscj WHERE nd = ? AND xq = ? AND kcxh = ? AND xh = ?';
			$item  = DB::getInstance()->getRow($sql, array(Session::read('year'), Session::read('term'), $cno, $sno));
			$total = $item['zpcj'] + $score * Session::read('proportion.' . Session::read('grade') . '.' . $mode);

			$update = DB::getInstance()->updateRecord('t_cj_lscj', array('cj' . $mode => $score, 'zpcj' => $total), array('nd' => $year, 'xq' => $term, 'xh' => $sno, 'kcxh' => $cno));
			return $update;
		}
	}

	/**
	 * 确认成绩，写入在校生成绩表
	 * @return boolean      写入成功为TRUE，写入失败为FALSE
	 */
	protected function confirm() {
		if (isPost()) {
			$cno      = $_POST['course'];
			$inserted = false;

			$sql    = 'SELECT kch, zxf FROM t_jx_jxjh WHERE kch = (SELECT kch FROM t-pk_jxrw WHERE nd = ? AND xq = ? AND jsgh = ? AND kcxh = ?';
			$course = DB::getInstance()->getRow($sql, array(Session::read('year'), Session::read('xq'), Session::read('username'), $cno));
			$items  = DB::getInstance()->searchRecord('t_cj_lscj', array('nd' => Session::read('year'), 'xq' => Session::read('term'), 'kcxh' => $cno));
			foreach ($items as $item) {
				$score = array(
					'xh'   => $item['xh'],
					'xm'   => $item['xm'],
					'kch'  => $course['kch'],
					'kcxz' => $item['kcxz'],
					'kcpt' => $item['kcpt'],
					'xl'   => $item['xl'],
					'nd'   => $item['nd'],
					'xq'   => $item['xq'],
					'kh'   => $item['kh'],
					'cj'   => $item['zpcj'],
					'xf'   => PASSLINE < $item['zpcj'] ? $course['zxf'] : 0,
					'jd'   => gpa($item['zpcj']),
					'kszt' => $item['kszt'],
				);
				$inserted = DB::getInstance() - insertRecord('t_cj_zxscj', $score);}
		}
		return $inserted;
	}

	/**
	 * 按年度按学期列出成绩单
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @return array       成绩单列表
	 */
	protected function summary($year, $term) {
		$sql  = 'SELECT kcxh, kcmc FROM v_pk_kczyxx WHERE nd = ? AND xq = ? AND jsgh = ?';
		$data = DB::getInstance()->getAll($sql, array($year, $term, Session::read('username')));

		return $this->view->display('report.summary', array('courses' => $data, 'year' => $year, 'term' => $term));
	}

	/**
	 * 列出课程成绩
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $cno 课程序号
	 * @return array         成绩列表
	 */
	protected function score($year, $term, $cno) {
		$sql    = 'SELECT kch FROM t_pk_jxrw WHERE nd = ? AND xq = ? AND kcxh = ? AND jsgh = ?';
		$course = DB::getInstance()->getRow($sql, array($year, $term, $cno, Session::read('username')));

		$data = DB::getInstance()->getAll('v_cj_xscj', array('nd' => $year, 'xq' => $term, 'kch' => $course['kch']));
		return $this->view->display('report.score', array('scores' => $data));
	}
}