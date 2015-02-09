<?php section('header'); ?>
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
<?php section('footer') ?>