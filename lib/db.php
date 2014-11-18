<?php

/**
 * 数据库类
 */
class DB extends PDO {

	/**
	 * UUID
	 * @var string
	 */
	protected $uuid;
	/**
	 * 数据库DSN
	 * @var string
	 */
	protected $dsn;
	/**
	 * 数据库引擎
	 * @var string
	 */
	protected $engine;
	/**
	 * 数据库名
	 * @var string
	 */
	protected $dbname;
	/**
	 * 事务标志
	 * @var boolean
	 */
	protected $trans = false;
	/**
	 * 查询返回行数
	 * @var integer
	 */
	protected $rows = 0;
	/**
	 * SQL日志
	 * @var string
	 */
	protected $log;

	/**
	 * 实例化数据库类
	 * @param array $dsn      DSN数组
	 * @param string $username 用户名
	 * @param string $password 密码
	 * @param array  $options  选项
	 */
	public function __construct($dsn, $username = NULL, $password = NULL, array $options) {
		$bee          = Base::instance();
		$this->dsn    = $dsn['prefix'] . ':host=' . $dsn['host'] . ';port=' . $dsn['port'] . ';dbname=' . $dsn['dbname'];
		$this->uuid   = $bee->hash($this->dsn);
		$this->dbname = $dsn['dbname'];
		if (!$options) {
			$options = array();
		}
		if (isset($dsn['prefix']) && $dsn['prefix'] == 'mysql') {
			$options += array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . strtolower(isset($dsn['charset']) ? $dsn['charset'] : 'gbk') . ';');
		}
		parent::__construct($dsn, $username, $password, $options);

		parent::setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
		parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		parent::setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

		$this->engine = parent::getAttribute(parent::ATTR_DRIVER_NAME);
	}

	/**
	 * 开始事务
	 * @return boolean 成功为TRUE，失败为FALSE
	 */
	public function begin() {
		$this->trans = true;
		return parent::beginTransaction();
	}

	/**
	 * 回滚事务
	 * @return boolean 成功为RUE，失败为FALSE
	 */
	public function rollback() {
		$this->trans = false;
		return parent::rollback();
	}

	/**
	 * 提交事务
	 * @return boolean 成功为TRUE，失败为FALSE
	 */
	public function commit() {
		$this->trans = false;
		return parent::commit();
	}

	/**
	 * 映射数据类型到对应的PDO类型常量
	 * @param  string $val 数据
	 * @return int       PDO数据类型常量
	 */
	public function type($val) {
		switch (gettype($val)) {
			case 'NULL':
				return PDO::PARAM_NULL;
			case 'boolean':
				return PDO::PARAM_BOOL;
			case 'integer':
				return PDO::PARAM_INT;
			default:
				return PDO::PARAM_STR;
		}
	}

	/**
	 * 转换PDO数据类型为PHP数据类型
	 * @param  string $type PDO数据类型
	 * @param  scalar $val  标量数据
	 * @return scalar       转换后数据
	 */
	public function value($type, $val) {
		switch ($type) {
			case PDO::PARAM_NULL:
				return (unset) $val;
			case PDO::PARAM_INT:
				return (int) $val;
			case PDO::PARAM_BOOL:
				return (boolean) $val;
			case PDO::PARAM_STR:
				return (string) $val;
		}
	}

	/**
	 * 获取查询影响行数
	 * @return int 查询影响行数
	 */
	public function count() {
		return $this->rows;
	}

	/**
	 * 获取SQL日志
	 * @return string SQL日志
	 */
	public function log() {
		return $this->log;
	}

	/**
	 * 数据加引号
	 * @param  mixed $val  数据
	 * @param  int $type 数据类型
	 * @return string       条加引号后数据
	 */
	public function quote($val, $type = PDO::PARAM_STR) {
		return parent::quote($val, $type);
	}

	/**
	 * 获取UUID
	 * @return string UUID值
	 */
	public function uuid() {
		return $this->uuid;
	}

	/**
	 * 获取数据库引擎
	 * @return string 数据库引擎
	 */
	public function driver() {
		return $this->engine;
	}

	/**
	 * 获取服务器版本
	 * @return string 服务器版本
	 */
	public function version() {
		return parent::getAttribute(parent::ATTR_SERVER_VERSION);
	}

	/**
	 * 获取数据库名称
	 * @return string 数据库名称
	 */
	public function name() {
		return $this->dbname;
	}

	/**
	 * 添加列引号
	 * @param  string $key 列名
	 * @return string      天加引号后列名
	 */
	function quotekey($key) {
		switch ($this->engine) {
			case 'mysql':
				$key = "`" . implode('`.`', explode('.', $key)) . "`";
				break;
			case 'sybase':
			case 'dblib':
				$key = "'" . implode("'.'", explode('.', $key)) . "'";
				break;
			case 'sqlite':
			case 'pgsql':
			case 'oci':
				$key = '"' . implode('"."', explode('.', $key)) . '"';
				break;
			case 'mssql':
			case 'sqlsrv':
			case 'odbc':
				$key = "[" . implode('].[', explode('.', $key)) . "]";
				break;
		}

		return $key;
	}

	public function exec() {}
}