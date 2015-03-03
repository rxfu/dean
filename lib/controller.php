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
	 * 当前会话
	 * @var Session
	 */
	protected $session = null;

	/**
	 * 控制器对应模型类
	 * @var Model
	 */
	protected $model = null;

	/**
	 * 数据库句柄
	 * @var Database
	 */
	protected $db = null;

	/**
	 * 前过滤器排除列表
	 * @var array
	 */
	protected $before_excepts = array();

	/**
	 * 后过滤器排除列表
	 * @var array
	 */
	protected $after_excepts = array();

	/**
	 * 控制器构造方法
	 */
	public function __construct() {
		$this->session = Session::getInstance(SESSION_KEY);
		$this->session->start();

		$this->view = new View();
	}

	/**
	 * 方法前过滤提交变量
	 * @param  string $method    方法名
	 * @param  array $arguments 方法参数
	 * @return mixed            方法返回值
	 */
	public function __call($method, $arguments) {
		if (method_exists($this, $method)) {
			if (!in_array($method, $this->before_excepts)) {
				$this->before();
			}

			$beforeMethod = 'before' . snakeToCamel($method);
			if (method_exists($this, $beforeMethod)) {
				if (call_user_func_array(array($this, $beforeMethod), $arguments)) {
					call_user_func_array(array($this, $method), $arguments);
				}
			} else {
				call_user_func_array(array($this, $method), $arguments);
			}

			$afterMethod = 'after' . snakeToCamel($method);
			if (method_exists($this, $afterMethod)) {
				call_user_func_array(array($this, $afterMethod), $arguments);
			}

			if (!in_array($method, $this->after_excepts)) {
				$this->after();
			}
		}
	}

	/**
	 * 预先执行函数
	 * @return NULL
	 */
	protected function before() {
		// TODO::
	}

	/**
	 * 事后执行函数
	 * @return NULL
	 */
	protected function after() {
		// TODO:
	}

	/**
	 * 加载模型类
	 * @param  string $model 模型名称
	 * @return void        
	 */
	public function loadModel($name) {
		$modelPath = MODROOT . DS . $name . '.php';

		if (file_exists($modelPath)) {
			$model = $name . 'Model';
			$this->model = new $model;
		}
	}

}