<?php

/**
 * 评教模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class ManagerModel extends ManagerAdminModel {

	/**
	 * 获取评教管理员详细信息
	 * @param  string $username 教师工号
	 * @return array 成功返回教师详细信息，否则返回FALSE
	 */
	public function getProfile($username) {
		$sql  = 'SELECT * FROM t_xt_user WHERE username = ?';
		$data = $this->db->getRow($sql, $username);

		return has($data) ? $data : false;
	}

	/**
	 * 验证评教管理员密码
	 * @param  string $username 用户名
	 * @return mixed      成功返回TRUE，否则返回FALSE
	 */
	public function validate($username, $password) {
		$sql  = 'SELECT * FROM t_xt_user WHERE username = ? AND password = ?';
		$data = $this->db->getRow($sql, array($username, encrypt($password)));

		return has($data) ? true : false;
	}

	/**
	 * 修改评教管理员密码
	 * @param  string $username      用户名
	 * @param  string $password 密码
	 * @return boolean          成功返回TRUE，否则返回FALSE
	 */
	public function changePassword($username, $password) {
		$sql     = 'UPDATE t_xt_user SET password = ? WHERE username = ?';
		$updated = $this->db->update($sql, array(encrypt($password), $username));

		return $updated ? true : false;
	}

}