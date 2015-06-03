<?php

/**
 * 模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class Model {

	/**
	 * 模型类对应的数据库句柄
	 * @var object
	 */
	protected $db = null;

	/**
	 * 模型类构造方法
	 * @param string $cfgname 数据库配置名
	 */
	public function __construct($cfgname) {
		$this->activate($cfgname);
	}

	/**
	 * 激活数据库
	 * @param  string $cfgname 数据库配置名
	 * @return void          
	 */
	protected function activate($cfgname = 'default') {
		$config   = Config::get('db');
		$dsn      = $config[$cfgname];
		$this->db = Database::connect($dsn);
	}

}