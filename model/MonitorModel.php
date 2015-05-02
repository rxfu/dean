<?php

/**
 * 评教监控模型类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class MonitorModel extends ManagerAdminModel {

	/**
	 * 清空系统设置
	 * @return boolean 成功返回TRUE，否则返回FALSE
	 */
	public function clearSetting() {
		$deleted = $this->db->delete('DELETE FROM t_xt_jxpg');

		return $deleted;
	}

	/**
	 * 设置系统状态
	 * @param  string $year   年度
	 * @param  string $term   学期
	 * @param  string $status 评教状态，开放为1，关闭为0
	 * @return boolean         设置成功返回TRUE，否则返回FALSE
	 */
	public function setup($year, $term, $status) {
		$data['c_nd']   = $year;
		$data['c_xq']   = $term;
		$data['c_flag'] = $status;

		$inserted = $this->db->insertRecord('t_xt_jxpg', $data);

		return $inserted;
	}

	/**
	 * 获取系统设置
	 * @return mixed 成功返回系统设置数据，否则返回FALSE
	 */
	public function getSetting() {
		$sql  = 'SELECT * FROM t_xt_jxpg';
		$data = $this->db->getRow($sql);

		return has($data) ? $data : false;
	}

	/**
	 * 初始化统计表
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @return boolean       初始化成功返回TRUE，否则返回FALSE
	 */
	public function initialize($year, $term) {
		//创建课程评教得分总表
		$sql = 'TRUNCATE kctable, kcxhtable, xkxxtable';
		$this->db->delete($sql);
		//kcxhTable 临时表 记录各门课程序号的实评人数
		$sql = 'INSERT INTO kcxhtable SELECT DISTINCT c_kcxh, c_kcbh, COUNT(*) / 10 FROM t_zl_xspf WHERE c_nd = ? AND c_xq = ? GROUP BY c_kcxh';
		$this->db->insert($sql, array($year, $term));
		//kctable 临时表 记录某课程序号所有指标下各评分等级的人数
		$sql = 'INSERT INTO kctable SELECT c_kcxh, c_xm, rank_id, COUNT(*) FROM t_zl_xspf WHERE c_nd = ? and c_xq = ? GROUP BY c_kcxh, c_xm, rank_id';
		$this->db->insert($sql, array($year, $term));
		//xkxxtable 临时表 记录某课程的选课人数，也即课程的应评人数
		$sql = 'INSERT INTO xkxxtable SELECT c_kcxh, COUNT(*) FROM t_xk_xkxx WHERE c_nd = ? and c_xq = ? GROUP BY c_kcxh';
		$this->db->insert($sql, array($year, $term));
		//detailTable 存入二级指标得分 每个课程序号有10条记录
		$detailTable = $year . $term . "Mark";
		$sql         = "CREATE TABLE $detailTable(
	       c_kcxh VARCHAR(10) NOT NULL,
		   c_kcbh VARCHAR(10) NOT NULL,
		   c_jsgh VARCHAR(6) NOT NULL,
		   c_xm CHAR(2) NOT NULL,
		   s_mark NUMERIC(5,2)
    	)";
		$this->db->exec($sql);

		$tableName = $year . $term . "t";
		$sql       = "CREATE TABLE $tableName(
	       c_kcbh VARCHAR(10) NOT NULL,
	       c_kcxh VARCHAR(10) NOT NULL,
		   c_kcxz CHAR(2),
	       c_kcyx VARCHAR(20) NOT NULL,
		   c_skzy VARCHAR(40) NOT NULL,
		   c_jsgh CHAR(10) NOT NULL,
		   c_jsyx CHAR(20),
		   s_jxtd NUMERIC(5,2),
		   s_jxnr NUMERIC(5,2),
		   s_jxff NUMERIC(5,2),
		   s_jxxg NUMERIC(5,2),
		   s_zhpf NUMERIC(5,2),
		   s_cprs INTEGER(4),
		   s_sprs INTEGER(4)
    	)";
		$rowCount = $this->db->exec($sql);
		if (0 === $rowCount) {
			return false;
		}

		$sql = "CREATE INDEX c_kcxh ON $tableName(c_kcxh(10))";
		$this->db->exec($sql);

		$sql  = 'SELECT c_kcxh, c_kcbh, s_sprs FROM kcxhtable';
		$data = $this->db->search($sql);
		foreach ($data as $row) {
			$kcxh = $row[0]; //课程序号
			$kcxz = substr($row[0], 0, 2); //课程性质编号
			$sprs = $row[2]; //实评人数

			$nnn = array(); //nnn[i][j][k]统计第i个一级指标下的第j 个二级指标评分等级为k的学生人数
			for ($i = 1; $i <= $yjzb_num; $i++) {
				for ($j = 1; $j <= $ejzb_num[$i]; $j++) {
					$ejzb  = $ejzb_id[$i][$j];
					$sql   = 'SELECT rank_id, num FROM kctable WHERE c_kcxh = ? AND c_xm = ?';
					$ranks = $this->db->search($sql, array($kcxh, $ejzb));
					foreach ($ranks as $rank) {
						$nnn[$i][$j][$rank[0]] = $rank[1];
					}
				}
			}

			$sql     = 'SELECT DISTINCT c_jsgh FROM t_pk_kb WHERE c_kcxh = ? and c_nd = ? and c_xq = ?';
			$jsghRec = $this->db->getRow($sql, array($kcxh, $year, $term));
			$jsgh    = $jsghRec[0]; //教师工号
			$kcbh    = $row[1]; //课程编号

			$f   = array(); //存放一级指标得分
			$f_f = 0.0; //该门课程的最终评分
			for ($i = 1; $i <= $yjzb_num; $i++) {
				$f[$i] = 0;
				for ($j = 1; $j <= $ejzb_num[$i]; $j++) {
					$ejzb = $ejzb_id[$i][$j];
					$sum  = 0;
					for ($k = 1; $k <= $rank_num; $k++) {
						$sum = $sum + $zb_rank[$k] * $nnn[$i][$j][$k];
					}
					if ($sprs > 0) {
						$ff = $sum / $sprs;
					} else {
						$ff = 0;
					}

					$mark = $ff;

					$detail['c_kcxh'] = $kcxh;
					$detail['c_kcbh'] = $kcbh;
					$detail['c_jsgh'] = $jsgh;
					$detail['c_xm']   = $ejzb;
					$detail['s_mark'] = $mark;
					$this->db->insertRecord($detailTable, $detail);
					$f[$i] = $f[$i] + $ejzb_qz[$i][$j] * $ff;
				}
				$f_f = $f_f + $yjzb_qz[$i] * $f[$i];
			}
			$sql     = 'SELECT s_cprs FROM xkxxtable WHERE c_kcxh = ?';
			$cprsRec = $this->db->getRow($sql, $row[0]);
			$sql     = 'SELECT DISTINCT c_mc FROM t_xt_yxbh, t_pk_js1 WHERE t_xt_yxbh.c_xb = c_yx AND c_jsgh = ?';
			$jsyxRec = $this->db->getRow($sql, $jsgh);
			$sql     = 'SELECT DISTINCT c_zyh, c_nj, c_mc FROM t_xt_yxbh, t_xt_yxzy, t_pk_kb WHERE c_xb = c_yx AND c_zy = c_zyh AND c_kcxh = ? AND c_nd = ? AND c_xq = ?';
			$skzyRec = $this->db->getRow($sql, array($jsgh, $year, $term));
			$sql     = 'SELECT c_mc FROM t_xt_zybh WHERE c_zy = ?';
			$skmcRec = $this->db->getRow($sql, $skzyRec[0]);

			$jsyx = $jsyxrec[0]; //教师院系
			$cprs = $cprsrec[0]; //课程应评人数(即选课人数)

			$skzy = $skzyRec[1] . "级" . $skmcRec[0]; //授课年级、专业
			$kcyx = $skzyRec[2]; //课程开设院系

			$tj['c_kcbh'] = $kcbh;
			$tj['c_kcxh'] = $kcxh;
			$tj['c_kcxz'] = $kcxz;
			$tj['c_kcyx'] = $kcyx;
			$tj['c_skzy'] = $skzy;
			$tj['c_jsgh'] = $jsgh;
			$tj['c_jsyx'] = $jsyx;
			$tj['s_jxtd'] = $f[1];
			$tj['s_jxnr'] = $f[2];
			$tj['s_jxff'] = $f[3];
			$tj['s_jxxg'] = $f[4];
			$tj['s_zhpf'] = $f_f;
			$tj['s_cprs'] = $cprs;
			$tj['s_sprs'] = $sprs;
			$inserted     = $this->db->insertRecord($tableName, $tj);
			return has($data) ? $data : false;
		}
	}

	/**
	 * 删除统计数据表
	 * @param  string $year 年度
	 * @param  string $term 学期
	 * @return boolean       删除成功返回影响行数，否则返回FALSE
	 */
	public function drop($year, $term) {
		$table   = $year . $term . 't';
		$sql     = 'DROP TABLE ' . $table;
		$deleted = $this->db->exec($sql);

		return has($deleted) ? $deleted : false;
	}

	/**
	 * 获取院系信息列表
	 * @return mixed 成功返回院系信息，否则返回FALSE
	 */
	public function getDepartments() {
		$sql  = 'SELECT * FROM t_xt_yxbh';
		$data = $this->db->getAll($sql);

		return has($data) ? $data : false;
	}

	/**
	 * 获取课程信息
	 * @param  string $table 统计表名
	 * @return array        课程信息列表
	 */
	public function getCourses($table) {
		$sql    = 'SELECT DISTINCT c_kcbh, c_kcyx FROM ' . $table;
		$data   = $this->db->getAll($sql);
		$result = array();
		foreach ($data as $row) {
			$sql              = 'SELECT kcmc FROM t_jx_kc WHERE c_kcbh = ?';
			$result[]['kcmc'] = $this->db->getColumn($sql, $row['c_kcbh']);
			$result[]['kch']  = $row['c_kcbh'];
			$result[]['kkxy'] = $row['c_kcyx'];
		}

		return $result;
	}

	/**
	 * 获取用户列表
	 * @return mixed 成功返回用户信息，否则返回FALSE
	 */
	public function getUsers() {
		$sql  = 'SELECT * FROM t_xt_user';
		$data = $this->db->getAll($sql);

		return has($data) ? $data : false;
	}

	/**
	 * 获取用户信息
	 * @param  string $uid 用户ID
	 * @return mixed      成功返回用户信息，否则返回FALSE
	 */
	public function getUser($uid) {
		$sql  = 'SELECT * FROM t_xt_user WHERE username = ?';
		$data = $this->db->getRow($sql, $uid);

		return has($data) ? $data : false;
	}

	/**
	 * 添加用户
	 * @param string $username   用户名
	 * @param string $password   密码
	 * @param string $department 所在院系
	 * @param string $role       角色权限
	 * @return mixed 成功返回影响行数，否则返回FALSE
	 */
	public function addUser($username, $password, $department, $role) {
		$sql      = 'INSERT INTO t_xt_user VALUES(?, ?, ?, ?)';
		$inserted = $this->db->insert($sql, array($username, $password, $department, $role));

		return has($inserted) ? $inserted : false;
	}

	/**
	 * 删除用户
	 * @param  string $uid 用户ID
	 * @return mixed      成功返回影响行数，否则返回FALSE
	 */
	public function delUser($uid) {
		$sql     = 'DELETE FROM t_xt_user WHERE username = ?';
		$deleted = $this->db->delete($sql, $uid);

		return has($deleted) ? $deleted : false;
	}

	/**
	 * 修改用户
	 * @param  string $username 用户名
	 * @param  string $role     角色权限
	 * @return mixed           成功返回影响行数，否则返回FALSE
	 */
	public function modUser($username, $password, $department, $role) {
		$sql     = 'UPDATE t_xt_user SET username = ?, password = ?, dep = ?, user_role = ? WHERE username = ?';
		$updated = $this->db->update($sql, array($username, $password, $department, $role, $username));

		return has($updated) ? $updated : false;
	}

	/**
	 * 获取学生参评率
	 * @param  string $table      统计表名
	 * @param  string $department 学院
	 * @param  string $property   课程性质
	 * @param  string $order      排序字段
	 * @return array             参评率列表
	 */
	public function getXscpl($table, $department, $property, $order) {
		if ($department == "") {
			$sql = "SELECT c_kcbh, c_jsgh, c_jsyx, COUNT(c_kcxh) AS skzys, SUM(s_cprs) AS cprs, SUM(s_sprs) AS sprs FROM $table GROUP BY c_jsgh, c_kcbh ORDER BY '$order'";
		} else {
			$sql = "SELECT c_kcbh, c_jsgh, c_jsyx, COUNT(c_kcxh) AS skzys, SUM(s_cprs) AS cprs, SUM(s_sprs) AS sprs FROM $table WHERE c_jsyx = '$department' GROUP BY c_jsgh, c_kcbh ORDER BY '$order'";
		}
		$yprs   = 0;
		$sprs   = 0;
		$result = array();
		$data   = $this->db->getAll($sql);

		foreach ($data as $myrow) {
			$sql  = 'SELECT c_zwmc FROM t_jx_kc WHERE c_kcbh = ?'; //查询课程名称
			$row1 = $this->db->getRow($sql, $myrow[0]);
			$sql  = 'SELECT c_xm FROM t_pk_js1 WHERE c_jsgh = ?'; //查询教师姓名
			$row2 = $this->db->getRow($sql, $myrow[1]);
			$sql  = "SELECT c_kcxh, c_skzy FROM $table WHERE c_kcbh = ? AND c_jsgh = ?";
			$row3 = $this->db->getAll($sql, array($myrow[0], $myrow[1]));
			$kcxz = substr($row3[0][0], 0, 2);
			if ($property != "" && substr($row3[0], 0, 2) != $property) {
				continue;
			}

			$sql  = 'SELECT c_mc FROM t_xt_kcxz WHERE c_bh = ?';
			$row4 = $this->db->getRow($sql, $kcxz);
			if ($myrow[4] != 0) {
				$rate = ($myrow[5] / $myrow[4]) * 100;
			} else {
				$rate = 0;
			}
			$result[]['jsxy'] = $myrow[2]; //教师所在学院
			$result[]['jsgh'] = $myrow[1]; //教师工号
			$result[]['jsxm'] = $row2[0]; //教师姓名
			$result[]['kcmc'] = $row1[0]; //授课名称
			$result[]['kcxz'] = $row4[0]; //课程性质
			foreach ($row3 as $row) {
				$result[]['skzy'][] = $row[1]; //授课年级专业
			}
			$result[]['yprs'] = $myrow[4]; //应评人数
			$result[]['sprs'] = $myrow[5]; //实评人数
			$result[]['rate'] = $rate; //参评率
		}

		return $result;
	}

	/**
	 * 获取教师评教得分排名
	 * @param  string $table      统计表名
	 * @param  string $department 学院
	 * @param  string $property   课程性质
	 * @return array             排名列表
	 */
	public function getXyjspm($table, $department, $property) {
		if ($department == "") {
			$sql = "SELECT c_kcbh, c_jsgh, c_jsyx, COUNT(c_kcxh) AS skzys, SUM(s_sprs) AS sprs, AVG(s_zhpf) AS zhpf FROM $table GROUP BY c_jsgh, c_kcbh ORDER BY zhpf DESC";
		} else {
			$sql = "SELECT c_kcbh, c_jsgh, c_jsyx, COUNT(c_kcxh) AS skzys, SUM(s_sprs) AS sprs, AVG(s_zhpf) AS zhpf FROM $table WHERE c_jsyx = '$department' GROUP BY c_jsgh, c_kcbh ORDER BY zhpf DESC";
		}
		$zhpf   = 0; //获取第一条记录的综合评分
		$i      = 0;
		$result = array();
		$data   = $this->db->getAll($sql);

		foreach ($data as $myrow) {
			$sql  = "SELECT c_zwmc FROM t_jx_kc WHERE c_kcbh = ?"; //查询课程名称
			$row1 = $this->db->getRow($sql, $myrow[0]);
			$sql  = "SELECT c_xm, c_zc FROM t_pk_js1 WHERE c_jsgh = ?"; //查询教师姓名
			$row2 = $this->db->getRow($sql, $myrow[1]);
			$sql  = "SELECT c_kcxh, c_skzy FROM $table WHERE c_kcbh = ? AND c_jsgh = ?";
			$row3 = $this->db->getAll($sql, array($myrow[0], $myrow[1]));
			if ($property != "" and substr($row3[0], 0, 2) != $property) {
				continue;
			}

			$result[]['jsgh'] = $myrow[1]; //教师工号
			$result[]['jsxm'] = $row2[0]; //教师姓名
			$result[]['jszc'] = $row2[1]; //教师职称
			$result[]['kcmc'] = $row1[0]; //授课名称
			$result[]['kcxz'] = substr($row3[0][0], 0, 8); //课程性质代码
			foreach ($row3 as $row) {
				$result[]['skzy'] = $row3[1]; //授课年级专业
			}
			$result[]['sprs'] = $myrow[4]; //实评人数
			$result[]['pjdf'] = $myrow[5]; //评教得分
			if ($zhpf != $myrow[5]) {
				$i++;
				$zhpf = $myrow[5];
			}
			$result[]['pm'] = $i;
		}

		return $result;
	}

	/**
	 * 获取教师评教明细
	 * @param  string $table      统计表名
	 * @param  string $department 学院
	 * @return array             明细表
	 */
	public function getJspjmx($table, $department) {
		if ($department == "") {
			$sql = "SELECT DISTINCT c_jsgh, AVG(s_jxtd) AS jxtd, AVG(s_jxnr) AS jxnr, AVG(s_jxff) AS jxff, AVG(s_jxxg) AS jxxg, AVG(s_zhpf) AS zhpf FROM $table GROUP BY c_jsgh ORDER BY zhpf DESC";
		} else {
			$sql = "SELECT DISTINCT c_jsgh, AVG(s_jxtd) AS jxtd, AVG(s_jxnr) AS jxnr, AVG(s_jxff) AS jxff, AVG(s_jxxg) AS jxxg, AVG(s_zhpf) AS zhpf FROM $table where c_jsyx='$department' GROUP BY c_jsgh ORDER BY zhpf DESC";
		}
		$result = array();
		$data   = $this->db->getAll($sql);
		foreach ($data as $myrow) {
			$sql  = "SELECT c_xm, c_zc FROM t_pk_js1 WHERE c_jsgh = ?"; //查询教师姓名
			$row1 = $this->db->getRow($sql, $myrow[0]);

			$result[]['jsgh'] = $myrow[0];
			$result[]['jsxm'] = $row1[0];
			$result[]['jsgh'] = $row1[1];
			$result[]['jxtd'] = $myrow[1];
			$result[]['jxnr'] = $myrow[2];
			$result[]['jxff'] = $myrow[3];
			$result[]['jxxg'] = $myrow[4];
			$result[]['zhpf'] = $myrow[5];
		}

		return $result;
	}

	/**
	 * 获取课程评教明细
	 * @param  string $table      统计表名
	 * @param  string $department 学院
	 * @param  string $property 课程性质
	 * @return array             明细表
	 */
	public function getKcpjmx($table, $department, $property) {
		if ($department == "" and $property == "") {
			$sql = "SELECT DISTINCT c_kcbh, AVG(s_jxtd) AS jxtd, AVG(s_jxnr) AS jxnr, AVG(s_jxff) AS jxff, AVG(s_jxxg) AS jxxg, AVG(s_zhpf) AS zhpf FROM $table GROUP BY c_kcbh ORDER BY zhpf DESC";
		} else if ($department != "" and $property == "") {
			$sql = "SELECT DISTINCT c_kcbh, AVG(s_jxtd) AS jxtd, AVG(s_jxnr) AS jxnr, AVG(s_jxff) AS jxff, AVG(s_jxxg) AS jxxg, AVG(s_zhpf) AS zhpf FROM $table WHERE c_kcyx = '$department' GROUP BY c_kcbh ORDER BY zhpf DESC";
		} else if ($department == "" and $property != "") {
			$sql = "SELECT DISTINCT c_kcbh, AVG(s_jxtd) AS jxtd, AVG(s_jxnr) AS jxnr, AVG(s_jxff) AS jxff, AVG(s_jxxg) AS jxxg, AVG(s_zhpf) AS zhpf FROM $table WHERE c_kcxz = '$property' GROUP BY c_kcbh,c_kcxz ORDER BY zhpf DESC";
		} else if ($department != "" and $property != "") {
			$sql = "SELECT DISTINCT c_kcbh, AVG(s_jxtd) AS jxtd, AVG(s_jxnr) AS jxnr, AVG(s_jxff) AS jxff, AVG(s_jxxg) AS jxxg, AVG(s_zhpf) AS zhpf FROM $table WHERE c_kcyx = '$department' AND c_kcxz = '$property' GROUP BY c_kcbh,c_kcxz ORDER BY zhpf DESC";
		}
		$result = array();
		$data   = $this->db->getAll($sql);
		foreach ($data as $myrow) {
			$sql  = "SELECT c_zwmc FROM t_jx_kc where c_kcbh = ?"; //查询课程名称
			$row1 = $this->db->getRow($sql, $myrow[0]);

			$result[]['kcmc'] = $row1[0];
			$result[]['kcxz'] = $myrow[0];
			$result[]['jxtd'] = $myrow[1];
			$result[]['jxnr'] = $myrow[2];
			$result[]['jxff'] = $myrow[3];
			$result[]['jxxg'] = $myrow[4];
			$result[]['zhpf'] = $myrow[5];
		}

		return $result;
	}

	/**
	 * 获取教师评教课程得分
	 * @param  string $table      统计表名
	 * @param  string $department 学院
	 * @param  string $course     课程号
	 * @return array             评教课程得分表
	 */
	public function getKcpjdb($table, $department, $course) {
		$sql    = "SELECT c_jsgh, c_jsyx, c_kcbh, AVG(s_jxtd) AS jxtd, AVG(s_jxnr) AS jxnr, AVG(s_jxff) AS jxff, AVG(s_jxxg) AS jxxg, AVG(s_zhpf) AS zhpf FROM $table where c_kcbh = ? GROUP BY c_kcbh, c_jsgh ";
		$data   = $this->db->getAll($sql, $course);
		$result = array();
		foreach ($data as $myrow) {
			$sql              = "SELECT c_xm FROM t_pk_js1 WHERE c_jsgh = ?"; //查询教师姓名
			$row2             = $this->db->getRow($sql, $myrow[0]);
			$sql              = "SELECT c_skzy FROM $table WHERE c_jsgh = ? AND c_kcbh = ?"; // 教师授课专业
			$row3             = $this->db->getAll($sql, array($myrow[0], $course));
			$result[]['jsxm'] = $row2[0]; //教师姓名
			$result[]['jsyx'] = $myrow[1]; //教师所在学院
			foreach ($row3 as $row) {
				$result[]['skzy'] = $row[0]; //授课年级专业
			}
			$result[]['jxtd'] = $myrow[3];
			$result[]['jxnr'] = $myrow[4];
			$result[]['jxff'] = $myrow[5];
			$result[]['jxxg'] = $myrow[6];
			$result[]['zhpf'] = $myrow[7];
		}

		return $result;
	}

}
