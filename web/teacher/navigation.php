            <!-- 页面导航栏 -->
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
                            <li><a href="<?php echo Route::to('teacher.profile') ?>"><i class="fa fa-user fa-fw"></i> 个人资料</a></li>
                            <li><a href="<?php echo Route::to('teacher.password') ?>"><i class="fa fa-unlock fa-fw"></i> 修改密码</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo Route::to('teacher.logout') ?>"><i class="fa fa-sign-out fa-fw"></i> 登出</a></li>
                        </ul>
                    </li>
                </ul>

                <nav class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul id="side-menu" class="nav">
                            <li>
                                <a href="<?php echo Route::to('teacher.dashboard') ?>"><i class="fa fa-dashboard fa-fw"></i> 综合管理系统</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-tasks fa-fw"></i> 成绩管理<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <?php if (ENABLE == Setting::get('CJ_WEB_KG')): ?>
                                        <li>
                                            <a href="#"> 成绩录入<span class="fa arrow"></span></a>
                                            <ul class="nav nav-third-level">
                                                <?php foreach($session['scoreCourses'] as $item): ?>
                                                    <li>
                                                        <a href="<?php echo Route::to('score.input', $item['kcxh']) ?>"><?php echo $item['kcxh'] ?></a>
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
                                                    <a href="<?php echo Route::to('score.summary', $item['nd'], $item['xq']) ?>"><?php echo $item['nd'] ?>年度<?php echo Dictionary::get('xq', $item['xq']) ?>学期成绩单</a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-calendar fa-fw"></i> 课表管理<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Route::to('curriculum.timetable') ?>">课程表</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('curriculum.listing') ?>">课程列表</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-gear fa-fw"></i> 系统管理<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Route::to('teacher.profile') ?>">个人资料</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('teacher.password') ?>">修改密码</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo Route::to('teacher.logout') ?>"><i class="fa fa-sign-out fa-fw"></i> 登出</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </nav>