<?php

/**
 * 学生管理模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class StudentAdminModel extends Model {

	public function __construct() {
		$this->setRole(Config::get('user.role.student'));
		parent::__construct();
	}

}
