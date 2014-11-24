<?php include 'header.php';?>
<body>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">登录系统</h3>
                        </div>
                        <div class="panel-body">
<?php if ($session->has('flash_error')):?>
<div id="flash_error" class="alert alert-danger alert-dismissable">
                                <button class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<?php echo $session->get('flash_error')?>
</div>
<?php endif;?>
                            <form id="loginForm" name="loginForm" action="login.php" role="form" method="post" class="form-horizontal">
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
                        <div class="panel-footer">
                            © <?php print(date('Y') == '2014') ? '2014' : '2014 - ' . date('Y')?> <a href="http://www.dean.gxnu.edu.cn">广西师范大学教务处</a>.版权所有.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load JS here for greater good -->
        <script src="js/jquery-1.11.0.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrapValidator.min.js"></script>
        <script src="js/jquery.placeholder.js"></script>
        <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="js/sb-admin.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>