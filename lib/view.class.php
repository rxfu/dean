<?php

/**
 * 视图类
 */
class View {

	/**
	 * 视图模板路径
	 * @var string
	 */
	protected $templateDirectory = null;

	/**
	 * 初始化视图模板路径
	 * @param string $templateDirectory 视图模板路径
	 */
	public function __construct($templateDirectory = NULL) {
		$templateDirectory       = is_null($templateDirectory) ? WEBROOT : $templateDirectory;
		$this->templateDirectory = rtrim($templateDirectory, DS);
	}

	/**
	 * 渲染模板
	 * @param  string $template 视图模板名
	 * @param  array  $data     模板数据
	 * @return string           渲染后的模板
	 */
	public function render($template, array $data = array()) {
		$templateFile = str_replace('.', DS, $template) . '.php';
		$templatePath = $this->templateDirectory . DS . ltrim($templateFile, DS);
		if (!is_file($templatePath)) {
			throw new RuntimeException('模板文件 ' . $templatePath . ' 不存在！');
		}

		extract($data);
		ob_start();
		require $templatePath;

		return ob_get_contents();
	}
}