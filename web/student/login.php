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
                    <div class="col-md-4 col-md-offset-4">
                        <div class="login-panel panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">学生入口</h3>
                            </div>
                            <div class="panel-body">
                                <?php Message::display(); ?>
                                <form id="loginForm" name="loginForm" action="<?php echo toLink('student.login') ?>" role="form" method="post" class="form-horizontal">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="username" class="col-md-3 control-label">用户名</label>
                                            <div class="col-md-9">
                                                <input type="text" name="username" id="username" placeholder="用户名" class="form-control" autofocus required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-md-3 control-label">密码</label>
                                            <div class="col-md-9">
                                                <input type="password" name="password" id="password" placeholder="密码" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-lg btn-success btn-block">登录</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
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
        <?php echo js('js/sb-admin-2.js') ?>
        <?php echo js('js/main.js') ?>
    </body>
</html>