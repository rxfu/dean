                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="login-panel panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">教师入口</h3>
                            </div>
                            <div class="panel-body">
                                <form id="loginForm" name="loginForm" action="<?php echo Route::to('teacher.login') ?>" role="form" method="post" class="form-horizontal">
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
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="alert alert-warning" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> <strong>注意！</strong>请检查自己是否正在使用<strong>360浏览器</strong>。部分360浏览器在成绩提交时会导致<strong>“提交失败”</strong>的错误，请使用IE9+、Firefox、Google Chrome、Opera等现代浏览器录入成绩。</div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                