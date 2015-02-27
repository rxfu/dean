<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="用于广西师范大学教务管理，学生选课，录入成绩">
        <meta name="keywords" content="广西师范大学,教务处,学生选课,教师管理,成绩管理">
        <meta name="author" content="Fu Rongxin,符荣鑫">
        <title>广西师范大学教务管理系统</title>
        <!--link rel="shortcut icon" href="favicon.ico"-->
        <?php echo css('css/bootstrap.min.css') ?>
        <?php echo css('css/formValidation.min.css') ?>
        <?php echo css('css/bootstrap-select.css') ?>
        <?php echo css('css/bootstrap-theme.css') ?>
        <?php echo css('font-awesome/css/font-awesome.min.css') ?>
        <?php echo css('css/plugins/dataTables/dataTables.bootstrap.css') ?>
        <?php echo css('css/sb-admin-2.css') ?>
        <?php echo css('css/timeline.css') ?>
        <?php echo css('css/style.css') ?>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
        <!--[if lt IE 9]>
            <?php echo js('js/html5shiv.js') ?>
            <?php echo js('js/respond.min.js') ?>
        <![endif]-->
    </head>

    <body>
        <div id="wrapper">
            <!-- 页面头部Logo -->
            <header role="banner"></header>

            <?php if (isset($session['logged']) && true == $session['logged']): ?>
                <!-- 页面导航栏 -->
                <?php if (STUDENT == $session['role']): ?>
                    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom:0">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                              <span class="sr-only">Toggle navigation</span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                            </button>
                            <a href="<?php echo getBaseUrl() ?>" class="navbar-brand">广西师范大学教务处学生选课系统</a>
                        </div>                    

                        <ul class="nav navbar-top-links navbar-right">
                            <li>欢迎<?php echo $session['college'] ?><?php echo $session['grade'] ?>级<?php echo $session['speciality'] ?>专业<?php echo $session['name'] ?>同学使用选课系统！</li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-user fa-fw"></i>
                                    <span><?php echo $session['name'] ?></span>
                                    <i class="fa fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="<?php echo toLink('student.profile') ?>"><i class="fa fa-user fa-fw"></i> 个人资料</a></li>
                                    <li><a href="<?php echo toLink('student.password') ?>"><i class="fa fa-unlock fa-fw"></i> 修改密码</a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo toLink('student.logout') ?>"><i class="fa fa-sign-out fa-fw"></i> 登出</a></li>
                                </ul>
                            </li>
                        </ul>

                        <!-- 应用程序导航栏 -->
                        <nav class="navbar-default sidebar" role="navigation">
                            <div class="sidebar-nav navbar-collapse">
                                <ul id="side-menu" class="nav">
                                    <li>
                                        <a href="<?php echo toLink('home.student') ?>"><i class="fa fa-dashboard fa-fw"></i> 综合管理系统</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-graduation-cap fa-fw"></i> 教学计划<span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <li>
                                                <a href="<?php echo toLink('plan.course') ?>">课程信息</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo toLink('plan.plan') ?>">教学计划</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo toLink('plan.graduation') ?>">毕业要求</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-table fa-fw"></i> 选课管理<span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <?php if (ENABLE == Configuration::get('XK_KG')): ?>
                                                <li>
                                                    <a href="<?php echo toLink('course.course', BASIC) ?>">公共课程</a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo toLink('course.course', REQUIRED) ?>">必修课程</a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo toLink('course.course', ELECTIVE) ?>">选修课程</a>
                                                </li>
                                                <?php if (ENABLE == Configuration::get('XK_TS')): ?>
                                                    <li>
                                                        <a href="#"> 通识素质课程<span class="fa arrow"></span></a>
                                                        <ul class="nav nav-third-level">
                                                            <li>
                                                                <a href="<?php echo toLink('course.course', HUMANITY) ?>">人文社科</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo toLink('course.course', NATURAL) ?>">自然科学</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo toLink('course.course', ART) ?>">艺术体育</a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo toLink('course.course', SPECIAL) ?>">其他专项</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if (ENABLE == Configuration::get('XK_QT')): ?>
                                                    <li>
                                                        <a href="<?php echo toLink('course.search', OTHERS) ?>">其他课程</a>
                                                    </li>
                                                <?php endif; ?>
                                                <li>
                                                    <a href="<?php echo toLink('course.search', RETAKE) ?>">重修课程</a>
                                                </li>
                                            <?php endif; ?>
                                            <li>
                                                <a href="<?php echo toLink('course.process') ?>">课程申请进度</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-calendar fa-fw"></i> 课表管理<span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <li>
                                                <a href="<?php echo toLink('schedule.timetable') ?>">课程表</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo toLink('schedule.current') ?>">已选课程列表</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo toLink('schedule.speciality') ?>">本学期专业课程表</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-tasks fa-fw"></i> 成绩管理<span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <li>
                                                <a href="<?php echo toLink('report.unconfirmed') ?>">待确认成绩单</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo toLink('report.report') ?>">综合成绩单</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-tablet fa-fw"></i> 考试报名<span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <li>
                                                <a href="<?php echo toLink('exam.cet') ?>">英语等级考试</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo toLink('exam.ncre') ?>">计算机等级考试</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo toLink('exam.psc') ?>">普通话水平测试</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo toLink('exam.tkt') ?>">教师职业能力测试</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-pencil-square-o fa-fw"></i> 教学评价<span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <li>
                                                <a href="#">教师评价</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-university fa-fw"></i> 创新学分申请<span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <li>
                                                <a href="#">学科竞赛获奖</a>
                                                <a href="#">发表科研论文</a>
                                                <a href="#">专利授权</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-university fa-fw"></i> 教室管理<span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <li>
                                                <a href="#">空教室查询</a>
                                                <a href="#">空教室申请</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-gear fa-fw"></i> 系统管理<span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <li>
                                                <a href="<?php echo toLink('student.profile') ?>">个人资料</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo toLink('system.log') ?>">选课日志</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo toLink('system.message') ?>">系统消息</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo toLink('student.password') ?>">修改密码</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?php echo toLink('student.logout') ?>"><i class="fa fa-sign-out fa-fw"></i> 登出</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </nav>
                <?php elseif (TEACHER == $session['role']): ?>
                    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom:0">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                              <span class="sr-only">Toggle navigation</span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                            </button>
                            <a href="<?php echo getBaseUrl() ?>" class="navbar-brand">广西师范大学教务处教师管理系统</a>
                        </div>                    

                        <ul class="nav navbar-top-links navbar-right">
                            <li>欢迎<?php echo $session['college'] ?><?php echo $session['name'] ?>老师使用教师管理系统！</li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-user fa-fw"></i>
                                    <span><?php echo $session['name'] ?></span>
                                    <i class="fa fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="<?php echo toLink('teacher.profile') ?>"><i class="fa fa-user fa-fw"></i> 个人资料</a></li>
                                    <li><a href="<?php echo toLink('teacher.password') ?>"><i class="fa fa-unlock fa-fw"></i> 修改密码</a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo toLink('teacher.logout') ?>"><i class="fa fa-sign-out fa-fw"></i> 登出</a></li>
                                </ul>
                            </li>
                        </ul>

                        <nav class="navbar-default sidebar" role="navigation">
                            <div class="sidebar-nav navbar-collapse">
                                <ul id="side-menu" class="nav">
                                    <li>
                                        <a href="<?php echo toLink('home.teacher') ?>"><i class="fa fa-dashboard fa-fw"></i> 综合管理系统</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-tasks fa-fw"></i> 成绩管理<span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <?php if (ENABLE == Configuration::get('CJ_WEB_KG')): ?>
                                                <li>
                                                    <a href="#"> 成绩录入<span class="fa arrow"></span></a>
                                                    <ul class="nav nav-third-level">
                                                        <?php foreach($session['scoreCourses'] as $item): ?>
                                                            <li>
                                                                <a href="<?php echo toLink('score.input', $item['kcxh']) ?>"><?php echo $item['kcxh'] ?></a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </li>
                                            <?php endif; ?>
                                            <li>
                                                <a href="#"> 成绩查询<span class="fa arrow"></span></a>
                                                <ul class="nav nav-third-level">
                                                    <?php foreach($session['scoreTerms'] as $item): ?>
                                                        <li>
                                                            <a href="<?php echo toLink('score.summary', $item['nd'], $item['xq']) ?>"><?php echo $item['nd'] ?>年度<?php echo Dictionary::get('xq', $item['xq']) ?>学期成绩单</a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-gear fa-fw"></i> 系统管理<span class="fa arrow"></span></a>
                                        <ul class="nav nav-second-level">
                                            <li>
                                                <a href="<?php echo toLink('teacher.profile') ?>">个人资料</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo toLink('teacher.password') ?>">修改密码</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?php echo toLink('teacher.logout') ?>"><i class="fa fa-sign-out fa-fw"></i> 登出</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </nav>
                <?php endif; ?>
                <!-- 页面主体 -->
                <main id="page-wrapper">
            <?php else: ?>
                <!-- 页面主体 -->
                <main class="container">
            <?php endif; ?>
            
            <?php if (Message::has()): ?>
                <!-- 页面消息 -->
                <section class="row">
                    <div class="col-lg-12">
                        <?php Message::display() ?>
                    </div>
                </section>
            <?php endif; ?>
