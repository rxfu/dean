<?php

/**
 * 考试控制类
 */
class ExamController extends StudentAdminController {

	protected function register($type) {
		$sql = 'SELECT * FROM t_ks_kslx WHERE kslx = ?';
		$exam = $this->db->getRow($sql, $type);

		$sql = 'SELECT xh, xm, sfzh FROM v_xs_xsxx WHERE xh = ?';
		$profile = $this->db->getRow($sql, $this->session->get('username'));

		if (isPost()) {

		}

		return $this->view->display('exam.register', array('type' => $type, 'exam' => $exam, 'profile' => $profile));
	}

}