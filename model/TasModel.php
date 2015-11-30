<?php

/**
 * 教师评学模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class TasModel extends TeacherAdminModel {

	public function save($year, $term, $tno, $cno, $college, $special, $grade, $scores) {
		$data['nd']   = $year;
		$data['xq']   = $term;
		$data['jsgh'] = $tno;
		$data['kcxh'] = $cno;
		$data['kch']  = substr($cno, 2, 8);
		$data['kkxy'] = $college;
		$data['zy']   = $special;
		$data['nj']   = $grade;

		$inserted = false;
		foreach ($scores as $score) {
			$data['pjbz_id'] = $score['pjzb'];
			$data['fz']      = $score['fz'];
			$inserted        = $this->db->insertRecord('t_px_pfjg', $data);
		}

		return $inserted;
	}

	public function listStandards($year, $term, $jsgh, $cno) {
		$sql  = 'SELECT a.id AS pjbz_id, a.xh AS xh, a.mc AS bzmc, b.mc AS zbmc, a.fz AS zgfz, a.fz FROM t_px_pjbz a INNER JOIN t_px_pjzb b ON b.id = a.pjzb_id LEFT JOIN t_px_pfjg c ON c.pjbz_id = a.id WHERE a.zt = ?';
		$data = $this->db->getAll($sql, array(ENABLE));

		return has($data) ? $data : false;
	}

	public function getCourseInfo($year, $term, $cno) {
		$sql  = 'SELECT DISTINCT(jsgh), * FROM v_pk_kczyxx WHERE nd = ? AND xq = ? AND kcxh = ?';
		$data = $this->db->getRow($sql, array($year, $term, $cno));

		return has($data) ? $data : false;
	}
}