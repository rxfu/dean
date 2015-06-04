<?php

/**
 * ��ʦ���̽��ģ����
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class AssessModel extends TeacherAdminModel {

	/**
	 * ��ʦ�������ݿ���
	 * @var null
	 */
	private $_adbh = null;

	public function __construct() {
		$this->_adbh = Database::connect(Config::get('db.tassess'));

		parent::__construct();
	}

	/**
	 * ��ȡ��ʦ���̿γ��б�
	 * @param  string $year ���
	 * @param  string $term ѧ��
	 * @param  string $tno  ��ʦ����
	 * @return array       �ɹ��������̿γ��б�ʧ�ܷ��ؿ�����
	 */
	public function getCourses($year, $term, $tno) {
		$table   = $year . $term . 't';
		$sql     = 'SELECT DISTINCT c_kcbh, c_kcyx FROM "' . $table . '" WHERE c_jsgh = ?';
		$courses = $this->_adbh->getAll($sql, $tno);

		$data = array();
		foreach ($courses as $course) {
			$sql    = 'SELECT kcmc FROM t_jx_kc WHERE kch = ?';
			$name   = $this->db->getColumn($sql, $course['c_kcbh']);
			$data[] = array(
				'kch'  => $course['c_kcbh'],
				'kcmc' => $name,
			);
		}

		return $data;
	}

	/**
	 * ��ȡ�γ���Ϣ
	 * @param  string $year ���
	 * @param  string $term ѧ��
	 * @param  string $cno  8λ�γ����
	 * @return mixed       �ɹ����ؿγ���Ϣ�����򷵻�FALSE
	 */
	public function getCourse($year, $term, $cno) {
		$sql  = 'SELECT kcxh, kcmc, kkxy, nj, zy FROM v_pk_kczyxx WHERE nd = ? AND xq = ? AND kch = ?';
		$data = $this->db->getRow($sql, array($year, $term, $cno));

		return has($data) ? $data : false;
	}

	/**
	 * ��ȡָ��÷�
	 * @param  string $year ���
	 * @param  string $term ѧ��
	 * @param  string $cno  8λ�γ̺�
	 * @param  string $tno  ��ʦ����
	 * @return mixed       �ɹ��������̷����б�ʧ�ܷ��ؿ�����
	 */
	public function getScores($year, $term, $cno, $tno) {
		$table = $year . $term . 't';
		$mark  = $year . $term . 'Mark';

		$sql   = 'SELECT AVG(s_jxtd) AS jxtd, AVG(s_jxnr) AS jxnr, AVG(s_jxff) AS jxff, AVG(s_jxxg) AS jxxg, AVG(s_zhpf) As zhpf FROM "' . $table . '" WHERE c_kcbh = ? and c_jsgh = ? GROUP BY c_kcbh, c_jsgh';
		$score = $this->_adbh->getRow($sql, array($cno, $tno));
		$data  = array(
			'1'    => sprintf('%.2f', $score['jxtd']),
			'2'    => sprintf('%.2f', $score['jxnr']),
			'3'    => sprintf('%.2f', $score['jxff']),
			'4'    => sprintf('%.2f', $score['jxxg']),
			'zhpf' => sprintf('%.2f', $score['zhpf']),
		);

		$sql     = 'SELECT a.zb_id, a.zb_mc, COUNT(*) AS total FROM t_zb_yjzb a, t_zb_ejzb b WHERE a.zb_id = b.zb_id GROUP BY a.zb_id, a.zb_mc ORDER BY a.zb_id';
		$indexes = $this->_adbh->getAll($sql);
		foreach ($indexes as $index) {
			$sql                         = 'SELECT ejzb_id, ejzb_mc, AVG(s_mark) AS mark FROM "' . $mark . '", t_zb_ejzb WHERE c_xm = CAST(ejzb_id AS TEXT) AND zb_id = ? AND c_kcbh = ? AND c_jsgh = ? GROUP BY ejzb_id, ejzb_mc, c_kcbh, c_jsgh, c_xm ORDER BY ejzb_id';
			$sec_indexes                 = $this->_adbh->getAll($sql, array($index['zb_id'], $cno, $tno));
			$data['zb'][$index['zb_id']] = array(
				'zb_mc' => $index['zb_mc'],
				'total' => $index['total'],
			);

			foreach ($sec_indexes as $sec_index) {
				$data['zb'][$index['zb_id']]['ejzb'][] = array(
					'ejzb_id' => $sec_index['ejzb_id'],
					'ejzb_mc' => $sec_index['ejzb_mc'],
					'score'   => sprintf('%.2f', $sec_index['mark']),
				);
			}
		}

		return $data;
	}

	/**
	 * ��ȡѧ������
	 * @param  string $year ���
	 * @param  string $term ѧ��
	 * @param  string $cno  8λ�γ̺�
	 * @param  string $tno  ��ʦ����
	 * @return mixed       �ɹ��������̷����б�ʧ�ܷ��ؿ�����
	 */
	public function getComments($year, $term, $cno, $tno) {
		$table = $year . $term . 't';
		$sql   = 'SELECT c_yd, c_qd, c_one, c_xh FROM t_zl_xspy a INNER JOIN "' . $table . '" b ON a.c_kcxh = b.c_kcxh WHERE a.c_nd = ? AND a.c_xq = ? AND b.c_jsgh = ? AND b.c_kcbh = ?';
		$data  = $this->_adbh->getAll($sql, array($year, $term, $tno, $cno));

		return has($data) ? $data : false;
	}

}