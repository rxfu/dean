<?php

/**
 * 教师模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class TeacherModel extends TeacherAdminModel {

	/**
	 * 获取教师详细信息
	 * @param  string $tno 教师工号
	 * @return array 成功返回教师详细信息，否则返回FALSE
	 */
	public function getProfile($tno) {
		$sql  = 'SELECT * FROM v_pk_jsxx WHERE jsgh = ?';
		$data = $this->db->getRow($sql, $tno);

		return has($data) ? $data : false;
	}

	/**
	 * 验证教师密码
	 * @param  string $tno 教师工号
	 * @return mixed      成功返回TRUE，否则返回FALSE
	 */
	public function validate($tno, $password) {
		$sql  = 'SELECT * FROM t_pk_js WHERE jsgh = ? AND mm = ? AND zt = ?';
		$data = $this->db->getRow($sql, array($tno, encrypt($password), ENABLE));

		return has($data) ? true : false;
	}

	/**
	 * 修改教师密码
	 * @param  string $tno      教师工号
	 * @param  string $password 密码
	 * @return boolean          成功返回TRUE，否则返回FALSE
	 */
	public function changePassword($tno, $password) {
		$sql     = 'UPDATE t_pk_js SET mm = ? WHERE jsgh = ?';
		$updated = $this->db->update($sql, array(encrypt($password), $tno));

		return $updated ? true : false;
	}

	/**
	 * 获取可录入成绩的课程列表
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @param  string $tno  教师工号
	 * @return mixed       成功返回课程列表，否则返回空数组
	 */
	public function getCourses($year, $term, $tno) {
		$sql  = 'SELECT kcxh FROM v_cj_xscjlr WHERE jsgh = ? AND nd = ? AND xq = ? GROUP BY kcxh ORDER BY kcxh';
		$data = $this->db->getAll($sql, array($tno, $year, $term));

		return has($data) ? $data : array();
	}

	/**
	 * 获取具有成绩的学期
	 * @param  string $tno 教师工号
	 * @return mixed      成功返回学期列表，否则返回空数组
	 */
	public function getTerms($tno) {
		$sql  = 'SELECT nd, xq FROM v_cj_xsgccj WHERE jsgh = ? GROUP BY nd, xq ORDER BY nd DESC, xq DESC';
		$data = $this->db->getAll($sql, $tno);

		return has($data) ? $data : array();
	}

	/**
	 * 获取评教年度列表
	 * @param  string $tno 教师工号
	 * @return mixed 成功返回评教年度列表，否则返回空数组
	 */
	public function getAssessedTerms($tno) {
		$sql    = 'SELECT table_name FROM information_schema.tables WHERE table_schema = ? AND table_name LIKE ? ORDER BY table_name';
		$tables = $this->db->getAll($sql, array('public', '20%t'));
		$data   = array();

		foreach ($tables as $table) {
			$tableName = $table['table_name'];
			$sql       = 'SELECT COUNT(*) FROM ' . $tableName . ' WHERE c_jsgh = ?';
			$count     = $this->db->getColumn($sql, $tno);

			if (0 < $count) {
				$year   = substr($tableName, 0, 4);
				$term   = substr($tableName, 4, 1);
				$data[] = array(
					'nd' => $year,
					'xq' => $term,
				);
			}
		}

		return has($data) ? $data : array();
	}

}