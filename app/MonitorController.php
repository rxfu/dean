<?php

/**
 * 评教监控类
 *
 * @author Fu Rongxin <rxfu@mailbox.gxnu.edu.cn>
 */
class MonitorController extends ManagerAdminController {

	/**
	 * 设置系统参数
	 * @return void
	 */
	protected function setting() {
		$data   = $this->model->getSetting();
		$year   = $data['c_nd'];
		$term   = $data['c_xq'];
		$status = $data['c_flag'];

		if (isPost()) {
			$_POST  = sanitize($_POST);
			$year   = $_POST['year'];
			$term   = $_POST['term'];
			$status = $_POST['status'];

			$this->model->clearSetting();
			$this->model->setup($year, $term, $status);
		}

		return $this->view->display('monitor.setting', array('year' => $year, 'term' => $term, 'status' => $status));
	}

	/**
	 * 初始化系统评教数据
	 * @return void
	 */
	protected function init() {
		$data = $this->model->getSetting();
		$year = $data['c_nd'];
		$term = $data['c_xq'];

		if (isPost()) {
			$_POST = sanitize($_POST);
			$year  = $_POST['year'];
			$term  = $_POST['term'];

			if (false == $this->model->initialize($year, $term)) {
				Message::add('danger', '系统初始化失败');
				return;
			}
		}

		return $this->view->display('monitor.init', array('year' => $year, 'term' => $term));
	}

	/**
	 * 列出用户信息
	 * @return void
	 */
	protected function user() {
		$users = $this->model->getUsers();

		return $this->view->display('monitor.user', array('users' => $users));
	}

	/**
	 * 新增用户
	 * @return void
	 */
	protected function adduser() {
		if (isPost()) {
			$_POST      = sanitize($_POST);
			$username   = $_POST['username'];
			$password   = $_POST['password'];
			$department = $_POST['department'];
			$role       = $_POST['role'];

			$success = $this->model->addUser($username, $password, $department, $role);
			if (!$success) {
				Message::add('danger', '新增用户失败');
				return;
			}

			return redirect('monitor.user');
		}

		return $this->view->display('monitor.adduser');
	}

	/**
	 * 修改用户
	 * @return void
	 */
	protected function moduser($uid) {
		$user = $this->model->getUser($uid);

		if (isPost()) {
			$_POST      = sanitize($_POST);
			$username   = $_POST['username'];
			$password   = $_POST['password'];
			$department = $_POST['department'];
			$role       = $_POST['role'];

			$success = $this->model->modUser($username, $password, $department, $role);
			if (!$success) {
				Message::add('danger', '新增用户失败');
				return;
			}

			return redirect('monitor.user');
		}

		return $this->view->display('monitor.moduser', array('user' => $user));
	}

	/**
	 * 删除用户
	 * @param  string $uid 用户ID
	 * @return void
	 */
	protected function deluser($uid) {
		$success = $this->model->delUser($uid);
		if (!$success) {
			Message::add('danger', '删除用户失败');
			return;
		}

		return redirect('monitor.user');
	}

	/**
	 * 新增指标
	 * @return void
	 */
	protected function addindex() {
		if (isPost()) {
			$_POST     = sanitize($_POST);
			$index     = $_POST['index'];
			$indexname = $_POST['indexname'];
			$weight    = $_POST['weight'];

			$success = $this->model->addIndex($index, $indexname, $weight);
			if (!$success) {
				Message::add('danger', '新增指标失败');
				return;
			}

			return redirect('monitor.index');
		}

		return $this->view->display('monitor.addindex');
	}

	/**
	 * 修改指标
	 * @return void
	 */
	protected function modindex($uid) {
		$index = $this->model->getindex($uid);

		if (isPost()) {
			$_POST     = sanitize($_POST);
			$index     = $_POST['index'];
			$indexname = $_POST['indexname'];
			$weight    = $_POST['weight'];

			$success = $this->model->modIndex($indexno, $indexname, $weigh);
			if (!$success) {
				Message::add('danger', '新增指标失败');
				return;
			}

			return redirect('monitor.index');
		}

		return $this->view->display('monitor.modindex', array('index' => $index));
	}

	/**
	 * 删除指标
	 * @param  string $index 指标ID
	 * @return void
	 */
	protected function delindex($index) {
		$success = $this->model->delIndex($index);
		if (!$success) {
			Message::add('danger', '删除指标失败');
			return;
		}

		return redirect('monitor.index');
	}

	/**
	 * 列出评教等级
	 * @return void
	 */
	protected function grade() {
		$ranks = $this->model->getRanks();

		return $this->view->display('monitor.grade', array('ranks' => $ranks));
	}

	/**
	 * 列出学生参评率
	 * @return void
	 */
	protected function xscpl() {
		$departments = $this->model->getDepartments();

		if (isPost()) {
			$_POST      = sanitize($_POST);
			$department = $_POST['department'];
			$property   = $_POST['property'];
			$table      = $this->session->get('year') . $this->session->get('term') . 't';
			switch ($_POST['order']) {
				case 'college':
					$order = 'c_jsyx';
					break;

				case 'teacher':
					$order = 'c_jsgh';
					break;

				default:
					$order = 'c_kcbh';
					break;
			}
			$data = $this->model->getXscpl($table, $department, $property, $order);

			return $this->view->display('monitor.xscpl', array('departments' => $departments, 'department' => $department, 'property' => $property, 'order' => $order, 'data' => $data));
		}
		return $this->view->display('monitor.xscpl', array('departments' => $departments));
	}

	/**
	 * 列出教师评教排名
	 * @return void
	 */
	protected function xyjspm() {
		$departments = $this->model->getDepartments();

		if (isPost()) {
			$_POST      = sanitize($_POST);
			$department = $_POST['department'];
			$property   = $_POST['property'];
			$table      = $this->session->get('year') . $this->session->get('term') . 't';
			$data       = $this->model->getXyjspm($table, $department, $property);

			return $this->view->display('monitor.xyjspm', array('departments' => $departments, 'department' => $department, 'property' => $property, 'data' => $data));
		}
		return $this->view->display('monitor.xyjspm', array('departments' => $departments));
	}

	/**
	 * 列出教师评教明细
	 * @return void
	 */
	protected function jspjmx() {
		$departments = $this->model->getDepartments();

		if (isPost()) {
			$_POST      = sanitize($_POST);
			$department = $_POST['department'];
			$table      = $this->session->get('year') . $this->session->get('term') . 't';
			$data       = $this->model->getJspjmx($table, $department);

			$js_num    = 0; //统计学院教师总人数
			$jxtd_num  = 0; //统计学院教师所授多门课程的教学态度分数之和；
			$jxnr_num  = 0; //统计学院教师所授多门课程的教学内容分数之和；
			$jxff_num  = 0; //统计学院教师所授多门课程的教学方法分数之和；
			$jxxg_num  = 0; //统计学院教师所授多门课程的教学效果分数之和；
			$zhpf_num  = 0; //统计学院教师所授多门课程的教学综合评分之和；
			$yxjs_num  = 0; //统计学院优秀教师数
			$lhjs_num  = 0; //统计学院良好教师数
			$zdjs_num  = 0; //统计学院中等教师数
			$jgjs_num  = 0; //统计学院及格教师数
			$bjgjs_num = 0; //统计学院不及格教师数
			$jxtd_bz   = array(); //统计标准分用
			$jxnr_bz   = array();
			$jxff_bz   = array();
			$jxxg_bz   = array();
			$zhpf_bz   = array();
			$avg       = array();
			$zscore    = array();
			$grade     = array();

			foreach ($data as $row) {
				$js_num++;

				switch (intval($row['zhpf'] / 10)) {
					case 9:
						$yxjs_num++;
						break;
					case 8:
						$lhjs_num++;
						break;
					case 7:
						$zdjs_num++;
						break;
					case 6:
						$jgjs_num++;
						break;
					default:
						$bjgjs_num++;
				}
				$jxtd_num += $row['jxtd'];
				$jxnr_num += $row['jxnr'];
				$jxff_num += $row['jxff'];
				$jxxg_num += $row['jxxg'];
				$zhpf_num += $row['zhpf'];
				$jxtd_bz[$js_num] = $row['jxtd'];
				$jxnr_bz[$js_num] = $row['jxnr'];
				$jxff_bz[$js_num] = $row['jxff'];
				$jxxg_bz[$js_num] = $row['jxxg'];
				$zhpf_bz[$js_num] = $row['zhpf'];
			}

			$grade['yxjs']  = $yxjs_num; //统计学院优秀教师数
			$grade['lhjs']  = $lhjs_num; //统计学院良好教师数
			$grade['zdjs']  = $zdjs_num; //统计学院中等教师数
			$grade['jgjs']  = $jgjs_num; //统计学院及格教师数
			$grade['bjgjs'] = $bjgjs_num; //统计学院不及格教师数

			if (0 != $js_num) {
				//求平均分
				$jxtd_av = $jxtd_num / $js_num;
				$jxnr_av = $jxnr_num / $js_num;
				$jxff_av = $jxff_num / $js_num;
				$jxxg_av = $jxxg_num / $js_num;
				$zhpf_av = $zhpf_num / $js_num;

				//求标准分
				$jxtd_bzf = 0;
				$jxnr_bzf = 0;
				$jxff_bzf = 0;
				$jxxg_bzf = 0;
				$zhpf_bzf = 0;
				for ($i = 1; $i <= $js_num; $i++) {
					$jxtd_bzf += ($jxtd_bz[$i] - $jxtd_av) * ($jxtd_bz[$i] - $jxtd_av);
					$jxnr_bzf += ($jxnr_bz[$i] - $jxnr_av) * ($jxnr_bz[$i] - $jxnr_av);
					$jxff_bzf += ($jxff_bz[$i] - $jxff_av) * ($jxff_bz[$i] - $jxff_av);
					$jxxg_bzf += ($jxxg_bz[$i] - $jxxg_av) * ($jxxg_bz[$i] - $jxxg_av);
					$zhpf_bzf += ($zhpf_bz[$i] - $zhpf_av) * ($zhpf_bz[$i] - $zhpf_av);
				}

				$jxtd_bzf = sqrt($jxtd_bzf / $js_num);
				$jxnr_bzf = sqrt($jxnr_bzf / $js_num);
				$jxff_bzf = sqrt($jxff_bzf / $js_num);
				$jxxg_bzf = sqrt($jxxg_bzf / $js_num);
				$zhpf_bzf = sqrt($zhpf_bzf / $js_num);

				$avg['jxtd'] = $jxtd_av;
				$avg['jxnr'] = $jxnr_av;
				$avg['jxff'] = $jxff_av;
				$avg['jxxg'] = $jxxg_av;
				$avg['zhpf'] = $zhpf_av;

				$zscore['jxtd'] = $jxtd_bzf;
				$zscore['jxnr'] = $jxnr_bzf;
				$zscore['jxff'] = $jxff_bzf;
				$zscore['jxxg'] = $jxxg_bzf;
				$zscore['zhpf'] = $zhpf_bzf;
			}

			return $this->view->display('monitor.jspjmx', array('departments' => $departments, 'department' => $department, 'data' => $data, 'avg' => $avg, 'zscore' => $zscore, 'grade' => $grade, 'total' => $js_num));
		}
		return $this->view->display('monitor.jspjmx', array('departments' => $departments));
	}

	/**
	 * 列出课程评教明细
	 * @return void
	 */
	protected function kcpjmx() {
		$departments = $this->model->getDepartments();

		if (isPost()) {
			$_POST      = sanitize($_POST);
			$department = $_POST['department'];
			$property   = $_POST['property'];
			$table      = $this->session->get('year') . $this->session->get('term') . 't';
			$data       = $this->model->getKcpjmx($table, $department, $property);

			$js_num    = 0; //统计学院教师总人数
			$jxtd_num  = 0; //统计学院教师所授多门课程的教学态度分数之和；
			$jxnr_num  = 0; //统计学院教师所授多门课程的教学内容分数之和；
			$jxff_num  = 0; //统计学院教师所授多门课程的教学方法分数之和；
			$jxxg_num  = 0; //统计学院教师所授多门课程的教学效果分数之和；
			$zhpf_num  = 0; //统计学院教师所授多门课程的教学综合评分之和；
			$yxjs_num  = 0; //统计学院优秀教师数
			$lhjs_num  = 0; //统计学院良好教师数
			$zdjs_num  = 0; //统计学院中等教师数
			$jgjs_num  = 0; //统计学院及格教师数
			$bjgjs_num = 0; //统计学院不及格教师数
			$jxtd_bz   = array(); //统计标准分用
			$jxnr_bz   = array();
			$jxff_bz   = array();
			$jxxg_bz   = array();
			$zhpf_bz   = array();
			$avg       = array();
			$zscore    = array();
			$grade     = array();

			foreach ($data as $row) {
				$js_num++;

				switch (intval($row['zhpf'] / 10)) {
					case 9:
						$yxjs_num++;
						break;
					case 8:
						$lhjs_num++;
						break;
					case 7:
						$zdjs_num++;
						break;
					case 6:
						$jgjs_num++;
						break;
					default:
						$bjgjs_num++;
				}
				$jxtd_num += $row['jxtd'];
				$jxnr_num += $row['jxnr'];
				$jxff_num += $row['jxff'];
				$jxxg_num += $row['jxxg'];
				$zhpf_num += $row['zhpf'];
				$jxtd_bz[$js_num] = $row['jxtd'];
				$jxnr_bz[$js_num] = $row['jxnr'];
				$jxff_bz[$js_num] = $row['jxff'];
				$jxxg_bz[$js_num] = $row['jxxg'];
				$zhpf_bz[$js_num] = $row['zhpf'];
			}

			$grade['yxjs']  = $yxjs_num; //统计学院优秀教师数
			$grade['lhjs']  = $lhjs_num; //统计学院良好教师数
			$grade['zdjs']  = $zdjs_num; //统计学院中等教师数
			$grade['jgjs']  = $jgjs_num; //统计学院及格教师数
			$grade['bjgjs'] = $bjgjs_num; //统计学院不及格教师数

			if (0 != $js_num) {
				//求平均分
				$jxtd_av = $jxtd_num / $js_num;
				$jxnr_av = $jxnr_num / $js_num;
				$jxff_av = $jxff_num / $js_num;
				$jxxg_av = $jxxg_num / $js_num;
				$zhpf_av = $zhpf_num / $js_num;

				//求标准分
				$jxtd_bzf = 0;
				$jxnr_bzf = 0;
				$jxff_bzf = 0;
				$jxxg_bzf = 0;
				$zhpf_bzf = 0;
				for ($i = 1; $i <= $js_num; $i++) {
					$jxtd_bzf += ($jxtd_bz[$i] - $jxtd_av) * ($jxtd_bz[$i] - $jxtd_av);
					$jxnr_bzf += ($jxnr_bz[$i] - $jxnr_av) * ($jxnr_bz[$i] - $jxnr_av);
					$jxff_bzf += ($jxff_bz[$i] - $jxff_av) * ($jxff_bz[$i] - $jxff_av);
					$jxxg_bzf += ($jxxg_bz[$i] - $jxxg_av) * ($jxxg_bz[$i] - $jxxg_av);
					$zhpf_bzf += ($zhpf_bz[$i] - $zhpf_av) * ($zhpf_bz[$i] - $zhpf_av);
				}

				$jxtd_bzf = sqrt($jxtd_bzf / $js_num);
				$jxnr_bzf = sqrt($jxnr_bzf / $js_num);
				$jxff_bzf = sqrt($jxff_bzf / $js_num);
				$jxxg_bzf = sqrt($jxxg_bzf / $js_num);
				$zhpf_bzf = sqrt($zhpf_bzf / $js_num);

				$avg['jxtd'] = $jxtd_av;
				$avg['jxnr'] = $jxnr_av;
				$avg['jxff'] = $jxff_av;
				$avg['jxxg'] = $jxxg_av;
				$avg['zhpf'] = $zhpf_av;

				$zscore['jxtd'] = $jxtd_bzf;
				$zscore['jxnr'] = $jxnr_bzf;
				$zscore['jxff'] = $jxff_bzf;
				$zscore['jxxg'] = $jxxg_bzf;
				$zscore['zhpf'] = $zhpf_bzf;
			}

			return $this->view->display('monitor.kcpjmx', array('departments' => $departments, 'department' => $department, 'property' => $property, 'data' => $data, 'avg' => $avg, 'zscore' => $zscore, 'grade' => $grade, 'total' => $js_num));
		}
		return $this->view->display('monitor.kcpjmx', array('departments' => $departments));
	}

	/**
	 * 列出学院评教结果对比表
	 * @return void
	 */
	protected function xypbjg() {
		$table = $this->session->get('year') . $this->session->get('term') . 't';
		$data  = $this->model->getXypbjg($table);

		$i    = 0;
		$pjjs = 0;
		$pjkc = 0;
		$pjjs = 0;
		$avge = 0;
		foreach ($data as $row) {
			$pjjs += $row[1];
			$pjkc += $row[2];
			$pjrs += $row[4];
			$avge += $row[0];
			++$i;
		}
		$avge /= $i;
		rsort($data);

		return $this->view->display('monitor.xypbjg', array('data' => $data, 'pjjs' => $pjjs, 'pjkc' => $pjkc, 'pjrs' => $pjrs, 'avge' => $avge));
	}

	/**
	 * 列出“一名教师讲授多门课程”评教结果横向对比表
	 * @return void
	 */
	protected function jskcdb() {
		$departments = $this->model->getDepartments();
		$teachers    = $this->model->getTeachers();

		if (isPost()) {
			$_POST      = sanitize($_POST);
			$department = $_POST['department'];
			$teacher    = $_POST['teacher'];
			$table      = $this->session->get('year') . $this->session->get('term') . 't';
			$data       = $this->model->getJskcdb($table, $department, $teacher);

			$PF_SUM = 0;
			$td     = 0;
			$nr     = 0;
			$ff     = 0;
			$xg     = 0;
			$n      = count($data);
			$avg    = array();

			foreach ($data as $row) {
				$td += $row['jxtd'];
				$nr += $row['jxnr'];
				$ff += $row['jxff'];
				$xg += $row['jxxg'];
				$PF_SUM += $row['zhpf'];
			}

			if (0 < $n) {
				$avg['jxtd'] = $td / $n;
				$avg['jxnr'] = $nr / $n;
				$avg['jxff'] = $ff / $n;
				$avg['jxxg'] = $xg / $n;
				$avg['zhpf'] = $PF_SUM / $n;
			}

			return $this->view->display('monitor.jskcdb', array('departments' => $departments, 'teachers' => $teachers, 'department' => $department, 'teacher' => $teacher, 'data' => $data, 'avg' => $avg));
		}
		return $this->view->display('monitor.jskcdb', array('departments' => $departments, 'teachers' => $teachers));
	}

	/**
	 * 列出“一门课程多名教师讲授”评教结果横向对比表
	 * @return void
	 */
	protected function kcpjdb() {
		$departments = $this->model->getDepartments();
		$courses     = $this->model->getCourses();

		if (isPost()) {
			$_POST      = sanitize($_POST);
			$department = $_POST['department'];
			$course     = $_POST['course'];
			$table      = $this->session->get('year') . $this->session->get('term') . 't';
			$data       = $this->model->getKcpjdb($table, $department, $course);

			$PF_SUM = 0;
			$td     = 0;
			$nr     = 0;
			$ff     = 0;
			$xg     = 0;
			$n      = count($data);
			$avg    = array();

			foreach ($data as $row) {
				$td += $row['jxtd'];
				$nr += $row['jxnr'];
				$ff += $row['jxff'];
				$xg += $row['jxxg'];
				$PF_SUM += $row['zhpf'];
			}

			if (0 < $n) {
				$avg['jxtd'] = $td / $n;
				$avg['jxnr'] = $nr / $n;
				$avg['jxff'] = $ff / $n;
				$avg['jxxg'] = $xg / $n;
				$avg['zhpf'] = $PF_SUM / $n;
			}

			return $this->view->display('monitor.kcpjdb', array('departments' => $departments, 'courses' => $courses, 'department' => $department, 'course' => $course, 'data' => $data, 'avg' => $avg));
		}
		return $this->view->display('monitor.kcpjdb', array('departments' => $departments, 'courses' => $courses));
	}

	/**
	 * 列出公共课评教结果对比表
	 * @return void
	 */
	protected function ggkpjdb() {
		$courses = $this->model->getBasicCourses();

		if (isPost()) {
			$_POST  = sanitize($_POST);
			$course = $_POST['course'];
			$table  = $this->session->get('year') . $this->session->get('term') . 't';
			$data   = $this->model->getGggkpjdb($table, $course);

			return $this->view->display('monitor.ggkpjdb', array('courses' => $courses, 'course' => $course, 'data' => $data));
		}
		return $this->view->display('monitor.ggkpjdb', array('courses' => $courses));
	}

	/**
	 * 列出评教排名优秀教师得分统计表
	 * @return void
	 */
	protected function yxjstj() {
		if (isPost()) {
			$_POST  = sanitize($_POST);
			$course = $_POST['course'];
			$number = $_POST['teacher'];
			$table  = $this->session->get('year') . $this->session->get('term') . 't';
			$data   = $this->model->getYxjstj($table, $course, $number);

			$PF_SUM = 0;
			$td     = 0;
			$nr     = 0;
			$ff     = 0;
			$xg     = 0;
			$avg    = array();

			foreach ($data as $row) {
				foreach ($row['kcmc'] as $value) {

					$td += $value['jxtd'];
					$nr += $value['jxnr'];
					$ff += $value['jxff'];
					$xg += $value['jxxg'];
					$PF_SUM += $value['zhpf'];
				}
			}

			if (0 < $number) {
				$avg['jxtd'] = $td / $number;
				$avg['jxnr'] = $nr / $number;
				$avg['jxff'] = $ff / $number;
				$avg['jxxg'] = $xg / $number;
				$avg['zhpf'] = $PF_SUM / $number;
			}

			return $this->view->display('monitor.yxjstj', array('courses' => $courses, 'course' => $course, 'data' => $data, 'avg' => $avg));
		}
		return $this->view->display('monitor.yxjstj', array('courses' => $courses));
	}

	/**
	 * 列出单名教师单门课程评教得分明细表
	 * @return void
	 */
	protected function jspjjg() {
		$departments = $this->model->getDepartments();
		$teachers    = $this->model->getTeachers();
		$courses     = $this->model->getCourses();

		if (isPost()) {
			$_POST      = sanitize($_POST);
			$department = $_POST['department'];
			$course     = $_POST['course'];
			$number     = $_POST['teacher'];
			$table      = $this->session->get('year') . $this->session->get('term') . 't';
			$data       = $this->model->getJspjjg($table, $course, $number);

			$quality = new QualityModel();
			$indexes = $quality->getIndexes();

			return $this->view->display('monitor.jspjjg', array('departments' => $departments, 'department' => $department, 'teachers' => $teachers, 'teacher' => $teacher, 'courses' => $courses, 'course' => $course, 'data' => $data, '$indexes' => $indexes));
		}
		
		return $this->view->display('monitor.jspjjg', array('department' => $departments, 'teachers' => $teachers, 'courses' => $courses));
	}

	/**
	 * 监控评教数据
	 * @return void
	 */
	protected function monitor() {
		$data = $this->model->getMonitor();

		return $this->view->display('monitor.monitor', array('monitors' => $data));
	}

}
