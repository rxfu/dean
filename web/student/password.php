<?php section('header') ?>
<?php section('navigation') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">修改密码</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form id="passwordForm" name="passwordForm" action="<?php echo toLink('student.password') ?>" role="form" method="post" class="form-horizontal">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="oldPassword" class="col-md-3 control-label">旧密码</label>
                                            <div class="col-md-9">
                                                <input type="password" name="oldPassword" id="oldPassword" placeholder="旧密码" class="form-control" autofocus required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="newPassword" class="col-md-3 control-label">新密码</label>
                                            <div class="col-md-9">
                                                <input type="password" name="newPassword" id="newPassword" placeholder="新密码" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirmedPassword" class="col-md-3 control-label">确认密码</label>
                                            <div class="col-md-9">
                                                <input type="password" name="confirmedPassword" id="confirmedPassword" placeholder="确认密码" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-lg btn-success btn-block">确认修改</button>
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