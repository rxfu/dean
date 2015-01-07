<?php

/**
 * 数据库访问类，单例模式
 */
class DB extends Prefab {

	/**
	 * 保存数据库查询语句
	 *
	 * @var string
	 */
	private $_sql = null;

	/**
	 * 唯一的数据库连接标识符
	 *
	 * @var PDO对象
	 */
	private static $_dbh = null;

	/**
	 * 数据库引擎标识
	 * @var string
	 */
	private static $_engine = null;

	/**
	 * 覆盖__clone()方法，禁止克隆
	 */
	private function __clone() {
	}

	/**
	 * 析构方法
	 */
	public function __destruct() {

		$this->_close();
	}

	/**
	 * 连接数据库
	 */
	protected function init() {
		try {
			$dsn     = DB_PREFIX . ':host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME;
			$options = array();
			if (DB_PREFIX == 'mysql') {
				$options += array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . strtolower(defined(DB_CHARSET) ? DB_CHARSET : 'gbk') . ';');
			}

			self::$_dbh = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
			self::$_dbh->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
			self::$_dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			self::$_dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

			self::$_engine = self::$_dbh->getAttribute(PDO::ATTR_DRIVER_NAME);
		} catch (PDOException $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
		}
	}

	/**
	 * 关闭数据库
	 */
	private function _close() {

		self::$_dbh = null;
	}

	/**
	 * 执行数据库查询语句
	 *
	 * @param string  $sql    SQL语句
	 * @param array   $params 绑定参数值
	 * @return PDOStatement   PDO状态句柄
	 */
	private function _execute($sql, $params) {
		try {
			$sth = self::$_dbh->prepare($sql);
			if (is_object($sth)) {
				if (null !== $params) {
					if (is_array($params) || is_object($params)) {
						foreach ($params as $key => $param) {
							$sth->bindValue($key + 1, $param, $this->type($param));
						}
					} else {
						$sth->bindValue(1, $params, $this->type($params));
					}
				}
			}

			if ($sth->execute()) {
				$this->sql = $sql;
				return $sth;
			} else {
				$error = $sth->errorInfo();
				if (PDO::ERR_NONE != $error[0]) {
					trigger_error($error[2], E_USER_ERROR);
				}
			}
		} catch (PDOException $e) {
			trigger_error($e->getMessage(), E_USER_ERROR);
		}
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
	 * 数据加引号
	 * @param  mixed $val  数据
	 * @param  int $type 数据类型
	 * @return string       条加引号后数据
	 */
	public function quote($val, $type = PDO::PARAM_STR) {
		return self::$_dbh->quote($val, $type);
	}

	/**
	 * 添加列引号
	 * @param  string $key 列名
	 * @return string      添加引号后列名
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

	/**
	 * 插入查询
	 *
	 * @param string  $sql    SQL语句
	 * @param array   $params 绑定参数值
	 * @return serial   最后插入记录序号
	 */
	public function insert($sql, $params = null) {
		$sth = $this->_execute($sql, $params);
		return self::$_dbh->lastInsertId();
	}

	/**
	 * 插入一条记录
	 *
	 * @param string  $table 表名
	 * @param array   $data  插入数据数组
	 * @return serial  最后插入记录序号
	 */
	public function insertRecord($table, $data) {
		$props  = array();
		$marks  = array();
		$params = array();
		$prop   = '';
		$mark   = '';

		if (!empty($data)) {
			foreach ($data as $key => $value) {
				$props[]  = $key;
				$params[] = $value;
				$marks[]  = '?';
			}
			$prop = implode(',', $props);
			$mark = implode(',', $marks);
		}

		$sql = 'INSERT INTO ' . $table . ' (' . $prop . ') VALUES (' . $mark . ')';

		return $this->insert($sql, $params);
	}

	/**
	 * 更新查询
	 *
	 * @param string  $sql    SQL语句
	 * @param array   $params 绑定参数值
	 * @return int   影响行数
	 */
	public function update($sql, $params = null) {
		$sth = $this->_execute($sql, $params);
		return $sth->rowCount();
	}

	/**
	 * 更新符合条件的记录
	 *
	 * @param string  $table 表名
	 * @param array   $data  更新数据数组
	 * @param array   $where 更新条件数组
	 * @return int  影响行数
	 */
	public function updateRecord($table, $data, $where = array()) {
		$marks      = array();
		$params     = array();
		$conditions = array();
		$mark       = '';
		$condition  = '';

		if (!empty($data)) {
			foreach ($data as $key => $value) {
				$marks[]  = $key . '=?';
				$params[] = $value;
			}
			$mark = implode(',', $marks);
		}
		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$conditions[] = $key . '=?';
				$params[]     = $value;
			}
			$condition = ' WHERE ' . implode(' AND ', $conditions);
		}
		$sql = 'UPDATE ' . $table . ' SET ' . $mark . $condition;

		return $this->update($sql, $params);
	}

	/**
	 * 删除查询
	 *
	 * @param string  $sql    SQL语句
	 * @param array   $params 绑定参数值
	 * @return int   影响行数
	 */
	public function delete($sql, $params = null) {
		$sth = $this->_execute($sql, $params);
		return $sth->rowCount();
	}

	/**
	 * 删除符合条件的记录
	 *
	 * @param string  $table 表名
	 * @param array   $where 删除条件数组
	 * @return int  影响行数
	 */
	public function deleteRecord($table, $where) {
		$params     = array();
		$conditions = array();
		$condition  = '';

		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$conditions[] = $key . '=?';
				$params[]     = $value;
			}

			$condition = ' WHERE ' . implode(' AND ', $conditions);
		}
		$sql = 'DELETE FROM ' . $table . $condition;

		return $this->delete($sql, $params);
	}

	/**
	 * 查询记录
	 *
	 * @param string  $sql    SQL语句
	 * @param array   $params 绑定参数值
	 * @return PDOStatement   PDO状态句柄
	 */
	public function search($sql, $params = null) {
		return $this->_execute($sql, $params);
	}

	/**
	 * 查询符合条件的记录
	 *
	 * @param string  $table  表名
	 * @param array   $where  查询条件数组
	 * @param array   $fields 查询域数组
	 * @return PDOStatement   PDO状态句柄
	 */
	public function searchRecord($table, $where = array(), $fields = array()) {
		$params     = array();
		$conditions = array();
		$condition  = '';

		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$conditions[] = $key . '=?';
				$params[]     = $value;
			}

			$condition = ' WHERE ' . implode(' AND ', $conditions);
		}
		$field = empty($fields) ? '*' : implode(',', $fields);
		$sql   = 'SELECT ' . $field . ' FROM ' . $table . $condition;

		return $this->search($sql, $params)->fetchAll();
	}

	/**
	 * 用原始SQL语句查询记录
	 * @param  string $sql SQL语句
	 * @return PDOStatement      PDO状态句柄
	 */
	public function query($sql) {
		return self::$_dbh->query($sql)->fetchAll();
	}

	/**
	 * 获取一行记录
	 *
	 * @param string  $sql    SQL语句
	 * @param array   $params 绑定参数值
	 * @return array   查询一行结果
	 */
	public function getRow($sql, $params = null) {
		$sth = $this->search($sql, $params);
		return $sth->fetch();
	}

	/**
	 * 获取所有记录
	 *
	 * @param string  $sql    SQL语句
	 * @param array   $params 绑定参数值
	 * @return array   查询所有结果
	 */
	public function getAll($sql, $params = null) {
		$sth = $this->_execute($sql, $params);
		return $sth->fetchAll();
	}

	/**
	 * 获取一列数据
	 *
	 * @param string  $sql    SQL语句
	 * @param array   $params 绑定参数值
	 * @return array   查询一列结果
	 */
	public function getColumn($sql, $params = null) {
		$sth = $this->search($sql, $params);
		return $sth->fetchColumn();
	}

	/**
	 * 开始执行事务
	 *
	 * @return boolean 成功为TRUE，失败为FALSE
	 */
	public function begin() {
		return self::$_dbh->beginTransaction();
	}

	/**
	 * 提交事务
	 *
	 * @return boolean 成功为TRUE，失败为FALSE
	 */
	public function commit() {
		return self::$_dbh->commit();
	}

	/**
	 * 回滚事务
	 *
	 * @return boolean 成功为TRUE，失败为FALSE
	 */
	public function rollBack() {
		return self::$_dbh->rollBack();
	}

	/**
	 * 获取最后一次SQL语句
	 *
	 * @return string SQL语句
	 */
	public function getLastSQL() {
		return $this->_sql;
	}

	/**
	 * 查询结果计数
	 *
	 * @param string  $sql    SQL语句
	 * @param array   $params 绑定参数值
	 * @return int   查询结果总数
	 */
	public function count($sql, $params) {
		return $this->getColumn($this->countQuery($sql), $params);
	}

	/**
	 * 分页查询
	 *
	 * @param string  $sql    SQL语句
	 * @param array   $params 绑定参数值
	 * @param int     $page   当前页码
	 * @param int     $size   每页记录数
	 * @param int     $count  总记录数
	 * @return array   分页查询结果
	 */
	public function getPage($sql, $params = null, &$page, &$size, &$count) {
		// 每页记录数
		$size = (0 <= $size) ? $size : 1;
		// 总记录数
		$count = $this->count($sql, $params);
		// 总页数
		$pages = ceil($count / $size);
		// 当前页码
		$page = $page > $pages ? $pages : $page;
		$page = 1 < $page ? $page : 1;
		// 偏移量
		$offset = ($page - 1) * $size;

		// 限制查询结果数量
		$limit = $sql . ' LIMIT ' . $size . ' OFFSET ' . $offset;

		return $this->search($limit, $params)->fetchAll();
	}

	/**
	 * 替换SQL语句，计算符合查询条件的记录数
	 *
	 * @param string  $sql SQL语句
	 * @return string   统计相应查询条件记录数的SQL语句
	 */
	public function countQuery($sql) {
		$query = $sql;
		if ((0 === stripos($query, 'SELECT')) && (6 < ($pos = stripos($query, 'FROM')))) {
			$rpos   = stripos($query, 'ORDER BY');
			$select = substr($query, 0, 6);
			$from   = $rpos ? substr($query, $pos, $rpos - $pos) : substr($query, $pos);
			$query  = $select . ' COUNT(*) ' . $from;
		}

		return $query;
	}
}
