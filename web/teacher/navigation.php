<body>
    <div id="wrapper">
        <header>
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
                    <li>欢迎<?php echo Session::read('college') ?><?php echo Session::read('name') ?>老师使用教师管理系统！</li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user fa-fw"></i>
                            <span><?php echo Session::read('name') ?></span>
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
                                <a href="<?php echo toLink('home.teacher') ?>"><i class="fa fa-dashboard fa-fw"></i> 仪表盘</a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-tasks fa-fw"></i> 成绩管理<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="#"> 成绩录入<span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <?php foreach(Session::read('reportCourses') as $item): ?>
                                                <li>
                                                    <a href="<?php echo toLink('report.input', $item['kcxh']) ?>"><?php echo $item['kcxh'] ?></a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#"> 成绩查询<span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <?php foreach(Session::read('reportTerms') as $item): ?>
                                                <li>
                                                    <a href="<?php echo toLink('report.summary', $item['nd'], $item['xq']) ?>"><?php echo $item['nd'] ?>年度<?php echo Dictionary::get('xq', $item['xq']) ?>学期成绩单</a>
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
                                        <a href="<?php echo toLink('teacher.password') ?>">修改密码</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </nav>
        </header>
<?php section('message') ?>
