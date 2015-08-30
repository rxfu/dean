            <!-- 页面导航栏 -->
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
                            <li><a href="<?php echo Route::to('student.profile') ?>"><i class="fa fa-user fa-fw"></i> 个人资料</a></li>
                            <li><a href="<?php echo Route::to('student.password') ?>"><i class="fa fa-unlock fa-fw"></i> 修改密码</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo Route::to('student.logout') ?>"><i class="fa fa-sign-out fa-fw"></i> 登出</a></li>
                        </ul>
                    </li>
                </ul>

                <!-- 应用程序导航栏 -->
                <nav class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul id="side-menu" class="nav">
                            <li>
                                <a href="<?php echo Route::to('student.dashboard') ?>"><i class="fa fa-dashboard fa-fw"></i> 综合管理系统</a>
                                <a href="<?php echo Route::to('student.fresh') ?>"><i class="fa fa-ticket fa-fw"></i> 新生信息核对</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-graduation-cap fa-fw"></i> 教学计划<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Route::to('plan.course') ?>">课程信息</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('plan.plan') ?>">教学计划</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('plan.graduation') ?>">毕业要求</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('plan.selected') ?>">选课情况表</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-table fa-fw"></i> 选课管理<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <?php if (ENABLE == Setting::get('XK_KG')): ?>
                                        <li>
                                            <a href="<?php echo Route::to('course.listing', 'bsc') ?>"><?php echo Config::get('course.type.bsc.name') ?></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo Route::to('course.listing', 'req') ?>"><?php echo Config::get('course.type.req.name') ?></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo Route::to('course.listing', 'lct') ?>"><?php echo Config::get('course.type.lct.name') ?></a>
                                        </li>
                                        <?php if (ENABLE == Setting::get('XK_TS')): ?>
                                            <li>
                                                <a href="#"> 通识素质课程<span class="fa arrow"></span></a>
                                                <ul class="nav nav-third-level">
                                                    <li>
                                                        <a href="<?php echo Route::to('course.listing', 'hs') ?>"><?php echo Config::get('course.type.hs.name') ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo Route::to('course.listing', 'ns') ?>"><?php echo Config::get('course.type.ns.name') ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo Route::to('course.listing', 'as') ?>"><?php echo Config::get('course.type.as.name') ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo Route::to('course.listing', 'os') ?>"><?php echo Config::get('course.type.os.name') ?></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (ENABLE == Setting::get('XK_QT')): ?>
                                            <li>
                                                <a href="<?php echo Route::to('course.search', 'others') ?>"><?php echo Config::get('course.type.others.name') ?></a>
                                            </li>
                                        <?php endif; ?>
                                        <li>
                                            <a href="<?php echo Route::to('course.search', 'retake') ?>"><?php echo Config::get('course.type.retake.name') ?></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo Route::to('course.current') ?>">可退选课程列表</a>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <a href="<?php echo Route::to('course.process') ?>">课程申请进度</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-calendar fa-fw"></i> 课表管理<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Route::to('schedule.timetable') ?>">课程表</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('schedule.current') ?>">已选课程列表</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('schedule.speciality') ?>">本学期专业课程表</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-tasks fa-fw"></i> 成绩管理<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Route::to('report.unconfirmed') ?>">待确认成绩单</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('report.report') ?>">综合成绩单</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('report.exam') ?>">国家考试成绩单</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-tablet fa-fw"></i> 考试报名<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <?php foreach ($session['examTypes'] as $examTypes): ?>
                                        <li>
                                            <a href="#"><?php echo $examTypes[0]['ksdlmc'] ?><span class="fa arrow"></span></a>
                                            <ul class="nav nav-third-level">
                                                <?php foreach ($examTypes as $examType): ?>
                                                    <li>
                                                        <a href="<?php echo Route::to('exam.register', $examType['kslx']) ?>"><?php echo $examType['ksmc'] ?></a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php endforeach; ?>
                                    <li>
                                        <a href="<?php echo Route::to('exam.listing') ?>">历史报名信息</a>
                                    </li>
                                </ul>
                            </li>
                            <!--li>
                                <a href="#"><i class="fa fa-pencil-square-o fa-fw"></i> 教学评价<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Route::to('quality.course', Config::get('quality.assessing')) ?>">未评课程</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('quality.course', Config::get('quality.assessed')) ?>">已评课程</a>
                                    </li>
                                </ul>
                            </li-->
                            <!--li>
                                <a href="#"><i class="fa fa-apple fa-fw"></i> 学分申请<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="#">课程转换申请<span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <li>
                                                <a href="<?php echo Route::to('report.transfer') ?>">课程转换</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo Route::to('report.process') ?>">申请进度</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">创新学分申请<span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <li>
                                                <a href="#">学科竞赛获奖</a>
                                                <a href="#">发表科研论文</a>
                                                <a href="#">专利授权</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li-->
                            <!--li>
                                <a href="#"><i class="fa fa-university fa-fw"></i> 教室管理<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="#">空教室查询</a>
                                        <a href="#">空教室申请</a>
                                    </li>
                                </ul>
                            </li-->
                            <li>
                                <a href="#"><i class="fa fa-gear fa-fw"></i> 系统管理<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Route::to('student.profile') ?>">个人资料</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('system.log') ?>">选课日志</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('system.message') ?>">系统消息</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('student.password') ?>">修改密码</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo Route::to('student.logout') ?>"><i class="fa fa-sign-out fa-fw"></i> 登出</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </nav>