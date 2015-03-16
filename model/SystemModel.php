<?php

/**
 * 消息模型类
 */
class SystemModel extends StudentAdminModel {

	/**
	 * 获取系统消息
	 * @return mixed 成功返回系统消息，否则返回FALSE
	 */
	public function getSystemMessage() {
		$sql  = 'SELECT text FROM t_xt_message';
		$data = $this->db->getColumn($sql);

		return has($data) ? $data : false;
	}

	/**
	 * 获取学生短消息
	 * @param  string $sno 学号
	 * @return mixed      成功返回短消息列表，否则返回空数组
	 */
	public function getMessages($sno) {
		$sql  = 'SELECT * FROM t_xk_dxx WHERE xh = ? ORDER BY fssj DESC';
		$data = $this->db->getAll($sql, $sno);

		return has($data) ? $data : array();
	}

	/**
	 * 获取学生系统日志
	 * @param  string $sno 学号
	 * @return mixed      成功返回日志列表，否则返回空数组
	 */
	public function getLogs($sno) {
		$sql  = 'SELECT * FROM t_xk_log WHERE xh = ? ORDER BY czsj DESC';
		$data = $this->db->getAll($sql, $sno);

		return has($data) ? $data : array();
	}
}