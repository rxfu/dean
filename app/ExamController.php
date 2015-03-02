<?php

/**
 * 考试控制类
 */
class ExamController extends StudentAdminController {

	/**
	 * 学生考试报名
	 * @param  string $type 考试类型
	 * @return void
	 */
	protected function register($type) {
		$sql  = 'SELECT * FROM t_cj_kslxdm WHERE kslx = ?';
		$exam = $this->db->getRow($sql, $type);

		$sql     = 'SELECT xh, xm, sfzh FROM v_xk_xsxx WHERE xh = ?';
		$profile = $this->db->getRow($sql, $this->session->get('username'));

		$sql      = 'SELECT * FROM t_zd_xqh ORDER BY dm';
		$campus   = $this->db->getAll($sql);
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

		return $this->view->display('exam.register', array('type' => $type, 'exam' => $exam, 'profile' => $profile, 'campuses' => $campuses, 'name' => $this->session->get('name'), 'year' => $this->session->get('year'), 'term' => $this->session->get('term')));
	}

	protected function listing() {
		$sql  = 'SELECT b.ksmc, a.xq, a.kssj, a.bmsj FROM t_ks_qtksbm a LEFT JOIN t_cj_kslxdm b ON b.kslx = a.kslx WHERE xh = ? ORDER BY a.bmsj DESC';
		$data = $this->db->getAll($sql, $this->session->get('username'));

		return $this->view->display('exam.listing', array('exams' => $data));
	}

}