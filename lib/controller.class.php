<?php

/**
 * 控制类
 */
class Controller {

	/**
	 * 控制器对应视图
	 * @var View
	 */
	protected $view = null;

	/**
	 * 控制器构造方法
	 */
	public function __construct() {
		$settings = Configuration::get('setting');
		$view     = new View($settings['views']);
	}
}