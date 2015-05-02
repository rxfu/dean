            <!-- 页面导航栏 -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom:0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a href="<?php echo getBaseUrl() ?>" class="navbar-brand">广西师范大学教务处评教管理系统</a>
                </div>                    

                <ul class="nav navbar-top-links navbar-right">
                    <li>欢迎<?php echo $session['username'] ?>用户使用评教管理系统！</li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user fa-fw"></i>
                            <span><?php echo $session['name'] ?></span>
                            <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="<?php echo Route::to('manager.profile') ?>"><i class="fa fa-user fa-fw"></i> 个人资料</a></li>
                            <li><a href="<?php echo Route::to('manager.password') ?>"><i class="fa fa-unlock fa-fw"></i> 修改密码</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo Route::to('manager.logout') ?>"><i class="fa fa-sign-out fa-fw"></i> 登出</a></li>
                        </ul>
                    </li>
                </ul>

                <nav class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul id="side-menu" class="nav">
                            <li>
                                <a href="<?php echo Route::to('manager.dashboard') ?>"><i class="fa fa-dashboard fa-fw"></i> 综合管理系统</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-tasks fa-fw"></i> 数据维护<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Route::to('monitor.setting') ?>">评教状态设置</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('monitor.init') ?>">系统初始化表</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('monitor.user') ?>">用户信息管理</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-tasks fa-fw"></i> 评教结果统计表<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Route::to('monitor.xscpl') ?>">学生参评率统计表</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('monitor.xyjspm') ?>">教师评教得分排名表</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('monitor.jspjmx') ?>">教师评教结果明细表</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('monitor.kcpjmx') ?>">课程评教结果明细表</a>
                                    </li>
                                    <li>
                                        <a href="#">各学院评教结果对比表</a>
                                    </li>
                                    <li>
                                        <a href="#">“一名教师讲授多门课程”评教结果横向对比表</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('monitor.kcpjdb') ?>">“一门课程多名教师讲授”评教结果横向对比表</a>
                                    </li>
                                    <li>
                                        <a href="#">公共课评教结果对比表</a>
                                    </li>
                                    <li>
                                        <a href="#">评教排名优秀教师得分统计表</a>
                                    </li>
                                    <li>
                                        <a href="#">“单名教师单门课程”评教得分明细表</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-tasks fa-fw"></i> 评教系统参数<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="#">系统指标权重设置</a>
                                    </li>
                                    <li>
                                        <a href="#">评教评分等级设置</a>
                                    </li>
                                    <li>
                                        <a href="#">系统指标权重</a>
                                    </li>
                                    <li>
                                        <a href="#">评教评分等级</a>
                                    </li>
                                    <li>
                                        <a href="#">评教监控</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-gear fa-fw"></i> 系统管理<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="<?php echo Route::to('manager.profile') ?>">个人资料</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo Route::to('manager.password') ?>">修改密码</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo Route::to('manager.logout') ?>"><i class="fa fa-sign-out fa-fw"></i> 登出</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </nav>