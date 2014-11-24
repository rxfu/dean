<body>
    <div id="wrapper">
        <header>
            <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom:0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a href="<?php echo getBaseUrl() ?>" class="navbar-brand">广西师范大学教务处学生选课系统</a>
                </div>                    

                <ul class="nav navbar-top-links navbar-right">
                    <li>欢迎<?php echo $session->get('college') ?><?php echo $session->get('grade') ?>级<?php echo $session->get('speciality') ?>专业的<?php echo $session->get('name') ?>同学使用选课系统！</li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user fa-fw"></i>
                            <span><?php echo $session->get('name') ?></span>
                            <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="<?php echo getRoute('profile.php') ?>"><i class="fa fa-user fa-fw"></i> 个人资料</a></li>
                            <li><a href="<?php echo getRoute('password.php') ?>"><i class="fa fa-unlock fa-fw"></i> 修改密码</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo getRoute('logout.php') ?>"><i class="fa fa-sign-out fa-fw"></i> 登出</a></li>
                        </ul>
                    </li>
                </ul>

                <nav class="navbar-default navbar-static-side" role="navigation">
                    <div class="sidebar-collapse">
                        <ul id="side-menu" class="nav">
                            <li class="sidebar-search">
                                <div class="input-group custom-search-form">
                                    <input type="search" name="search" id="search" class="form-control" placeholder="搜索...">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </li>
                            <li>
                                <a href="<?php echo getRoute('dashboard.php') ?>"><i class="fa fa-dashboard fa-fw"></i> 仪表盘</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-graduation-cap fa-fw"></i> 教学计划<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo getRoute('course.php') ?>">课程信息</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo getRoute('schedule.php') ?>">教学计划</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo getRoute('graduation.php') ?>">毕业要求</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-table fa-fw"></i> 课程管理<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo getRoute('elective.php') ?>">公共课程</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo getRoute('elective.php') ?>">必修课程</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo getRoute('elective.php') ?>">选修课程</a>
                                    </li>
                                    <li>
                                        <a href="#"> 通识素质课程<span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <li>
                                                <a href="<?php echo getRoute('elective.php') ?>">人文社科</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo getRoute('elective.php') ?>">自然科学</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo getRoute('elective.php') ?>">艺术体育</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo getRoute('elective.php') ?>">其他专项</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="<?php echo getRoute('elective.php') ?>">重修课程</a>
                                    </li>
                                </ul>
                            </li>
                            <?php $items = listCurriculumTerms($session->get('username')) ?>
                            <li>
                                <a href="#"><i class="fa fa-calendar fa-fw"></i> 课程表<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <?php foreach ($items as $item): ?>
                                    <li>
                                        <a href="<?php echo getRoute('curriculum.php?year=' . $item['nd'] . '&term=' . $item['xq']) ?>"><?php echo $item['nd'] ?>年度<?php echo parseDictCode('xq', $item['xq']) ?>学期课程表</a>
                                    </li>
                                    <?php endforeach ?>
                                </ul>
                            </li>
                            <?php $items = listReportTerms($session->get('username')) ?>
                            <li>
                                <a href="#"><i class="fa fa-tasks fa-fw"></i> 成绩管理<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo getRoute('report.php') ?>">综合成绩单</a>
                                    </li>
                                    <?php foreach ($items as $item): ?>
                                    <li>
                                        <a href="<?php echo getRoute('report.php?year=' . $item['nd'] . '&term=' . $item['xq']) ?>"><?php echo $item['nd'] ?>年度<?php echo parseDictCode('xq', $item['xq']) ?>学期成绩单</a>
                                    </li>
                                    <?php endforeach ?>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-tablet fa-fw"></i> 考试报名<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="#">四六级报名</a>
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
                                <a href="#"><i class="fa fa-pencil-square-o fa-fw"></i> 教学评价<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="#">教师评价</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-gear fa-fw"></i> 系统管理<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo getRoute('logger.php') ?>">选课日志</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo getRoute('message.php') ?>">系统消息</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo getRoute('password.php') ?>">修改密码</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </nav>
        </header>