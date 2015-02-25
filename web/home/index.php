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
        <link rel="shortcut icon" href="favicon.ico">
        <?php echo css('css/bootstrap.min.css') ?>
        <?php echo css('css/formValidation.min.css') ?>
        <?php echo css('css/bootstrap-select.css') ?>
        <?php echo css('css/bootstrap-theme.css') ?>
        <?php echo css('font-awesome/css/font-awesome.min.css') ?>
        <?php echo css('css/plugins/dataTables/dataTables.bootstrap.css') ?>
        <?php echo css('css/sb-admin-2.css') ?>
        <?php echo css('css/style.css') ?>

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
        <!--[if lt IE 9]>
            <?php echo js('js/html5shiv.js') ?>
            <?php echo js('js/respond.min.js') ?>
        <![endif]-->
    </head>

    <body>
        <div id="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="front-logo">
                            <img src="<?php echo img('images/logo.png') ?>" alt="广西师范大学教务管理系统">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-md-offset-2">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-md-9 text-right">
                                        <div class="huge">学生入口</div>
                                    </div>
                                </div>
                            </div>

                            <a href="<?php echo toLink('student.login') ?>">
                                <div class="panel-footer">
                                    <span class="pull-left">进入系统</span>
                                    <span class="pull-right">
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-md-9 text-right">
                                        <div class="huge">教师入口</div>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="<?php echo toLink('teacher.login') ?>">
                                <div class="panel-footer">
                                    <span class="pull-left">进入系统</span>
                                    <span class="pull-right">
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 页脚版权信息 -->
            <footer class="footer" role="contentinfo">
                © <?php print (date('Y') == '2014') ? '2014' : '2014 - ' . date('Y') ?> <a href="http://www.dean.gxnu.edu.cn">广西师范大学教务处</a>.版权所有.
            </footer>
        </div>

        <!-- Load JS here for greater good -->
        <?php echo js('js/jquery-1.11.0.min.js') ?>
        <?php echo js('js/jquery-ui-1.10.4.custom.min.js') ?>
        <?php echo js('js/bootstrap.min.js') ?>
        <?php echo js('js/formValidation.min.js') ?>
        <?php echo js('js/framework/bootstrap.min.js') ?>
        <?php echo js('js/language/zh_CN.js') ?>
        <?php echo js('js/bootstrap-typeahead.js') ?>
        <?php echo js('js/jquery.placeholder.js') ?>
        <?php echo js('js/jquery.stacktable.js') ?>
        <?php echo js('js/main.js') ?>
    </body>
</html>
