<?php

/**
 * 教师评学控制器
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class TasController extends TeacherAdminController {

	/**
	 * 录入教师评学数据
	 * @param  string $cno 12位课程序号
	 * @return mixed      view对象
	 */
	protected function input($cno) {
		$info = $this->model->getCourseInfo($this->session->get('year'), $this->session->get('term'), $cno);

		if (isPost()) {
			$_POST = sanitize($_POST);

			$this->model->save(
				$this->session->get('year'),
				$this->session->get('term'),
				$this->session->get('username'),
				$info['kcxh'],
				$info['kkxy'],
				$info['zy'],
				$info['nj'],
				$_POST['scores']
			);

			Message::add('success', '评学成功');

			return redirect('tas.input', $cno);
		}

		$results = $this->model->listResults($this->session->get('year'), $this->session->get('term'), $this->session->get('username'), $cno);
		$total   = 0;
		foreach ($results as $result) {
			$total += $result['fz'];
		}
		$grade = $this->model->getGrade($total);

		return $this->view->display('tas.input', array('info' => $info, 'total' => $total, 'grade' => $grade['mc'], 'results' => $results));
	}

	/**
	 * 教师评学课程列表
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @return Object       view对象
	 */
	protected function summary($year, $term) {
		$courses = $this->model->listCourses($year, $term, $this->session->get('username'));

		return $this->view->display('tas.summary', array('year' => $year, 'term' => $term, 'courses' => $courses));
	}

	/**
	 * 显示评学结果
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $cno  12位课程序号
	 * @return object       view对象
	 */
	protected function result($year, $term, $cno) {
		$info    = $this->model->getCourseInfo($year, $term, $cno);
		$results = $this->model->listResults($year, $term, $this->session->get('username'), $cno);
		$total   = 0;
		foreach ($results as $result) {
			$total += $result['fz'];
		}
		$grade = $this->model->getGrade($total);

		return $this->view->display('tas.result', array('info' => $info, 'total' => $total, 'grade' => $grade['mc'], 'results' => $results));
	}

}