<?php

/**
 * 考试控制类
 */
class ExamController extends StudentAdminController {

	/**
	 * 继承自基类before方法
	 * @return NULL
	 */
	protected function before() {
		$student = new StudentModel();

		if (!$student->isUploadedPortrait($this->session->get('id'))) {
			return redirect('student.upload');
		}

		parent::before();
	}

	/**
	 * 学生考试报名
	 * @param  string $type 考试类型
	 * @return void
	 */
	protected function register($type) {
		$sql  = 'SELECT * FROM t_cj_kslxdm WHERE kslx = ?';
		$exam = $this->db->getRow($sql, $type);

		if ($this->model->isRegistered($this->session->get('username'), $type, $exam['kssj'])) {
			return redirect('exam.listing');
		}

		$sql      = 'SELECT * FROM t_zd_xqh ORDER BY dm';
		$campus   = Dictionary::getAll('xqh');
		$campuses = array();
		foreach ($campus as $c) {
			if (!isEmpty($c)) {
				$campuses[] = $c;
			}
		}

		if (isPost()) {
			$_POST = sanitize($_POST);

			$campus = $_POST['campus'];

			$data['xh']   = $this->session->get('username');
			$data['xq']   = $campus;
			$data['kslx'] = $type;
			$data['bklb'] = '00';
			$data['kssj'] = $exam['sj'];
			$data['clbz'] = '1';
			$data['bmsj'] = date('Y-m-d H:i:s');
			$this->db->insertRecord('t_ks_qtksbm', $data);

			return redirect('exam.listing');
		}

		return $this->view->display('exam.register', array('type' => $type, 'exam' => $exam, 'campuses' => $campuses, 'name' => $this->session->get('name'), 'year' => $this->session->get('year'), 'term' => $this->session->get('term')));
	}

	protected function listing() {
		$sql  = 'SELECT b.ksmc, a.xq, a.kssj, a.bmsj FROM t_ks_qtksbm a LEFT JOIN t_cj_kslxdm b ON b.kslx = a.kslx WHERE xh = ? ORDER BY a.bmsj DESC';
		$data = $this->db->getAll($sql, $this->session->get('username'));

		return $this->view->display('exam.listing', array('exams' => $data));
	}

}