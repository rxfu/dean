<?php

/**
 * 视图类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class View {

	/**
	 * 视图模板路径
	 * @var string
	 */
	protected $templateDirectory = null;

	/**
	 * 初始化视图模板路径
	 * @param object $session 会话对象
	 * @param string $templateDirectory 视图模板路径
	 */
	public function __construct($templateDirectory = null) {
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
		$templateFile = strtr($template, '.', DS) . '.php';
		$templatePath = $this->templateDirectory . DS . ltrim($templateFile, DS);
		if (!is_file($templatePath)) {
			throw new RuntimeException('模板文件 ' . $templatePath . ' 不存在！');
		}
		$header = $this->templateDirectory . DS . 'header.php';
		$footer = $this->templateDirectory . DS . 'footer.php';

		$data['session'] = isset($data['session']) ? $data['session'] : $_SESSION;
		extract($data);
		ob_start();
		if (is_file($header)) {
			require $header;
		}
		require $templatePath;
		if (is_file($footer)) {
			require $footer;
		}
		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}

	/**
	 * 显示模板内容
	 * @param  string $template 视图模板名
	 * @param  array  $data     模板数据
	 * @return void
	 */
	public function display($template, array $data = array()) {
		print $this->render($template, $data);
		exit(0);
	}

}