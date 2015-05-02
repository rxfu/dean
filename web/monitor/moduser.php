                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">修改用户“<?php echo $user['username'] ?>”</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form id="userForm" name="userForm" action="<?php echo Route::to('monitor.moduser') ?>" role="form" method="post" class="form-horizontal">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="username" class="col-md-3 control-label">用户名</label>
                                            <div class="col-md-9">
                                                <input type="text" name="username" id="username" placeholder="用户名" class="form-control" value="<?php echo $user['username'] ?>" autofocus required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-md-3 control-label">密码</label>
                                            <div class="col-md-9">
                                                <input type="password" name="password" id="password" placeholder="密码" class="form-control" value="<?php echo $user['password'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="department" class="col-md-3 control-label">所在部门</label>
                                            <div class="col-md-9">
                                                <select name="department" id="department">
                                                    <?php foreach ($departments as $department): ?>
                                                        <option value="<?php echo $department['c_mc'] ?>"<?php echo $department['c_mc'] == $user['dep'] ? ' selected' : '' ?>><?php echo $department['c_mc'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="role" class="col-md-3 control-label">权限</label>
                                            <div class="col-md-9">
                                                <select name="role" id="role">
                                                    <option value="<?php Config::get('quality.admin') ?>"<?php echo Config::get('quality.admin') == $user['user_role'] ? ' selected' : '' ?>>超级管理员</option>
                                                    <option value="<?php Config::get('quality.manager') ?>"<?php echo Config::get('quality.manager') == $user['user_role'] ? ' selected' : '' ?>>普通管理员</option>
                                                    <option value="<?php Config::get('quality.power_user') ?>"<?php echo Config::get('quality.power_user') == $user['user_role'] ? ' selected' : '' ?>>学院领导</option>
                                                    <option value="<?php Config::get('quality.user') ?>"<?php echo Config::get('quality.user') == $user['user_role'] ? ' selected' : '' ?>>教学秘书</option>
                                                </select>
                                            </div>
                                        </div>user
                                        <div class="form-group">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-lg btn-primary btn-block">修改</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
