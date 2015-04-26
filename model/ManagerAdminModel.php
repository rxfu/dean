<?php

/**
 * 评教管理模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class ManagerAdminModel extends Model {

	public function __construct() {
		$this->setRole(Config::get('user.role.manager'));
		parent::__construct();
	}

}
