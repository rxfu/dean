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
		$data = DB::getInstance()->searchRecord('v_cj_xscj', array('xh' => Session::read('username')));

		return $this->view->display('report.index', array('scores' => $data));
	}

	/**
	 * 根据课程号列出当前学生过程成绩清单
	 *
	 * @param string  $cno 课程号
	 * @return array       学生成绩
	 */
	protected function detail($cno) {
		$data = DB::getInstance()->searchRecord('v_cj_xsgccj', array('xh' => Session::read('username'), 'nd' => $year, 'xq' => $term));

		return $this->view->display('report.term', array('scores' => $data, 'year' => $year, 'term' => $term));
	}

	/**
	 * 列出当前学生未确认成绩表
	 * @return void
	 */
	protected function unconfirmed() {
		$sql  = 'SELECT * FROM v_cj_xsgccj WHERE nd = ? AND xq = ? AND xh = ? AND tjzt = ?ORDER BY kcxh';
		$data = DB::getInstance()->getAll($sql, array(Session::read('year'), Session::read('term'), Session::read('username'), COLLEGE_CONFIRMED));

		$ratios = array();
		$scores = array();
		foreach ($data as $score) {
			$scores[$score['cjfs']]['ratios']    = $this->ratio($score['cjfs']);
			$scores[$score['cjfs']]['courses'][] = $score;
		}
		return $this->view->display('report.unconfirmed', array('scores' => $scores));
	}

	/**
	 * 获取成绩方式对应的组合
	 * @param  string $grade 成绩方式代码
	 * @return array      成绩方式组合，没有返回FALSE
	 */
	protected function ratio($grade) {
		$modes = DB::getInstance()->searchRecord('t_jx_cjfs', array('fs' => $grade));
		if (is_array($modes)) {
			$ratios = array();
			foreach ($modes as $mode) {
				$ratios['name']              = $mode['khmc'];
				$ratios['mode'][$mode['id']] = array('idm' => $mode['idm'], 'bl' => $mode['bl'] / $mode['mf']);
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
		$sql  = 'SELECT kcxh, kcmc, kkxy, nj, zy FROM v_pk_kczyxx WHERE nd = ? AND xq = ? AND kcxh = ?';
		$info = DB::getInstance()->getRow($sql, array(Session::read('year'), Session::read('term'), $cno));

		$sql    = 'SELECT * FROM v_cj_xscjlr WHERE nd = ? AND xq = ? AND kcxh = ? ORDER BY xh';
		$data   = DB::getInstance()->getAll($sql, array(Session::read('year'), Session::read('term'), $cno));
		$ratios = $this->ratio($data[0]['cjfs']);

		Session::write('mode', $data[0]['cjfs']);
		Session::write('major_grade', max(array_keys($ratios['mode'])));

		return $this->view->display('report.input', array('info' => $info, 'scores' => $data, 'ratios' => $ratios));
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

			$ratios = $this->ratio(Session::read('mode'));
			$fields = array();
			foreach (array_keys($ratios['mode']) as $key) {
				$fields[] = 'cj' . $key;
			}
			$field = empty($fields) ? '*' : array_to_field($fields);

			// 计算总评成绩
			$sql                  = 'SELECT ' . $field . ' FROM t_cj_web WHERE nd = ? AND xq = ? AND kcxh = ? AND xh = ?';
			$grades               = DB::getInstance()->getRow($sql, array(Session::read('year'), Session::read('term'), $cno, $sno));
			$grades['cj' . $mode] = $score;
			$majorGrade           = Session::read('major_grade');
			if (PASSLINE > $grades['cj' . $majorGrade]) {
				$total = $grades['cj' . $majorGrade];
			} else {
				$total = 0;
				foreach ($ratios['mode'] as $key => $value) {
					$total += $grades['cj' . $key] * $value['bl'];
				}
				$total = round($total);
			}

			// 更新WEB成绩表
			$updated = DB::getInstance()->updateRecord('t_cj_web', array('cj' . $mode => $score, 'zpcj' => $total), array('nd' => Session::read('year'), 'xq' => Session::read('term'), 'xh' => $sno, 'kcxh' => $cno));
			if ($updated) {
				$data  = DB::getInstance()->searchRecord('t_cj_web', array('nd' => Session::read('year'), 'xq' => Session::read('term'), 'kcxh' => $cno, 'xh' => $sno), array('zpcj'));
				$total = $data[0]['zpcj'];
			}

			if (isAjax()) {
				echo $updated ? $total : 'failed';
			}

			return $updated;
		}
	}

	/**
	 * 确认成绩
	 * @param  string $cno 课程序号
	 * @return boolean      确认成功为TRUE，否则为FALSE
	 */
	protected function confirm($cno) {
		DB::getInstance()->updateRecord('t_cj_web', array('tjzt' => COMMITTED), array('nd' => Session::read('year'), 'xq' => Session::read('term'), 'kcxh' => $cno));
		return Redirect::to('report.input.' . $cno);
	}

	/**
	 * 按年度按学期列出成绩单
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @return array       成绩单列表
	 */
	protected function summary($year, $term) {
		$sql  = 'SELECT DISTINCT kcxh, kcmc FROM v_cj_xsgccj WHERE nd = ? AND xq = ? AND jsgh = ? ORDER BY kcxh';
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
		$sql  = 'SELECT kcxh, kcmc, kkxy, nj, zy FROM v_pk_kczyxx WHERE nd = ? AND xq = ? AND kcxh = ?';
		$info = DB::getInstance()->getRow($sql, array($year, $term, $cno));

		$sql    = 'SELECT * FROM v_cj_xsgccj WHERE nd = ? AND xq = ? AND kcxh = ? ORDER BY xh';
		$data   = DB::getInstance()->getAll($sql, array($year, $term, $cno));
		$ratios = is_array($data) ? $this->ratio($data[0]['cjfs']) : array();
		return $this->view->display('report.score', array('info' => $info, 'scores' => $data, 'ratios' => $ratios));
	}

}
