<?php

/**
 * 教师课程表类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class CurriculumController extends TeacherAdminController {

	/**
	 * 列出当前教师课程表
	 * @return void
	 */
	protected function listing() {
		$courses = $this->model->listCourses($this->session->get('username'));

		$coursesByTerm = array();
		foreach ($courses as $course) {
			$coursesByTerm[$course['nd'] . $course['xq']][$course['kcxh']][] = $course;
		}
		krsort($coursesByTerm);

		return $this->view->display('curriculum.listing', array('courses' => $coursesByTerm));
	}

	/**
	 * 列出当前教师课程表
	 * @return array 教师课程表
	 */
	protected function timetable() {
		$courses = $this->model->listCourses($this->session->get('username'));
		$years   = array_values(array_unique(array_column($courses, 'nd')));
		$terms   = array_values(array_unique(array_column($courses, 'xq')));

		foreach ($years as $year) {
			foreach ($terms as $term) {
				$coursesByClass[$year . $term] = array_fill(1, 12, array_fill(1, 7, '&nbsp;'));
			}
		}

		foreach ($courses as $course) {
			$begClass = $course['ksj'];
			$endClass = $course['jsj'];
			$week     = $course['zc'];

			if ('&nbsp;' == $coursesByClass[$course['nd'] . $course['xq']][$begClass][$week]) {
				$coursesByClass[$course['nd'] . $course['xq']][$begClass][$week] = array();
			}
			$coursesByClass[$course['nd'] . $course['xq']][$begClass][$week][] = array(
				'kcxh'   => $course['kcxh'],
				'kcmc'   => $course['kcmc'],
				'kcywmc' => $course['kcywmc'],
				'ksz'    => $course['ksz'],
				'jsz'    => $course['jsz'],
				'ksj'    => $course['ksj'],
				'jsj'    => $course['jsj'],
				'zc'     => $course['zc'],
				'xqh'    => $course['xqh'],
				'jsmc'   => $course['jsmc'],
			);

			for ($i = $begClass + 1; $i <= $endClass; ++$i) {
				$coursesByClass[$course['nd'] . $course['xq']][$i][$week] = null;
			}
		}
		krsort($coursesByClass);

		return $this->view->display('curriculum.timetable', array('courses' => $coursesByClass));
	}

	/**
	 * 列出所上课程的学生
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $cno 课程序号
	 * @return void
	 */
	protected function student($year, $term, $cno) {
		$students = $this->model->listStudents($year, $term, $this->session->get('username'), $cno);

		return $this->view->display('curriculum.student', array('students' => $students, 'year' => $year, 'term' => $term));
	}

	/**
	 * 下载上课学生名单
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $cno  12位课程序号
	 * @return void
	 */
	protected function download($year, $term, $cno) {
		$students = $this->model->listStudents($year, $term, $this->session->get('username'), $cno);

		/** Include PHPExcel */
		require_once VENDOR . DS . 'PHPExcel' . DS . 'PHPExcel.php';

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator('Dean')
		            ->setLastModifiedBy("Dean")
		            ->setTitle("Student List of Course")
		            ->setSubject("Guangxi Normal University Student List")
		            ->setDescription("Student List of Guangxi Normal University Course")
		            ->setKeywords("student list course")
		            ->setCategory("student list");

		$objPHPExcel->setActiveSheetIndex(0)
		            ->setCellValue('A1', '学号')
		            ->setCellValue('B1', '姓名');

		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle($students[0]['kcmc']);

		$data = array();
		foreach ($students as $student) {
			$data[] = array_slice($student, 0, 2);
		}
		$objPHPExcel->getActiveSheet()->fromArray($data, null, 'A2');

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="students' . $this->session->get('year') . $this->session->get('term') . $students[0]['kcxh'] . '.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}

}
