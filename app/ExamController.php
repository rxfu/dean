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
		$sql  = 'SELECT * FROM t_ks_kslx WHERE kslx = ?';
		$exam = $this->db->getRow($sql, $type);

		$sql     = 'SELECT xh, xm, sfzh FROM v_xs_xsxx WHERE xh = ?';
		$profile = $this->db->getRow($sql, $this->session->get('username'));

		if (isPost()) {
			$_POST = sanitize($_POST);

			$campus = $_POST['campus'];

			$data['xh']   = $this->session->get('username');
			$data['xq']   = $campus;
			$data['kslx'] = $type;
			$data['bklb'] = '00';
			$data['kssj'] = $exam['kssj'];
			$data['clbz'] = '1';
			$data['bmsj'] = date('Y-m-d H:i:s');
			$this->db->insertRecord('t_ks_qtksbm', $data);

			return redirect('exam.listing');
		}

		return $this->view->display('exam.register', array('type' => $type, 'exam' => $exam, 'profile' => $profile));
	}

	protected function listing() {
		return $this->view->display('exam.listing');
	}

}