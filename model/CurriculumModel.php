<?php

/**
 * 教师课程表模型类
 */
class CurriculumModel extends TeacherAdminModel {

	/**
	 * 获取教师上课课程列表
	 * @param  string $tno 教师工号
	 * @return mixed      成功返回教师上课课程列表，否则返回FALSE
	 */
	public function listCourses($tno) {
		$sql  = 'SELECT * FROM v_pk_jskcb WHERE jsgh = ? ORDER BY nd DESC, xq DESC, kcxh, ksz, zc, ksj';
		$data = $this->db->getAll($sql, $tno);

		return has($data) ? $data : false;
	}
	
}