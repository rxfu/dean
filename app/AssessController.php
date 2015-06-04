<?php

/**
 * 教师评教结果控制器
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class AssessController extends TeacherAdminController {

	/**
	 * 按年度按学期列出评教课程
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @return array       评教结果列表
	 */
	protected function summary($year, $term) {
		$courses = $this->model->getCourses($year, $term, $this->session->get('username'));

		return $this->view->display('assess.summary', array('courses' => $courses, 'year' => $year, 'term' => $term));
	}

	/**
	 * 按年度按学期列出评教得分结果
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $cno  8位课程号
	 * @return void
	 */
	protected function result($year, $term, $cno) {
		$info     = $this->model->getCourse($year, $term, $cno);
		$indexes  = $this->model->getScores($year, $term, $cno, $this->session->get('username'));
		$comments = $this->model->getComments($year, $term, $cno, $this->session->get('username'));

		return $this->view->display('assess.result', array('info' => $info, 'indexes' => $indexes, 'comments' => $comments));
	}

}