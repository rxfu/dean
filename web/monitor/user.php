                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">用户管理</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <a href="<?php echo Route::to('monitor.adduser') ?>" role="button" class="btn btn-success">新增用户</a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th class="active">用户名</th>
                                                <th class="active">密码</th>
                                                <th class="active">所在部门</th>
                                                <th class="active">用户权限</th>
                                                <th class="active">操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td><?php echo $user['username'] ?></td>
                                                <td><?php echo $user['password'] ?></td>
                                                <td><?php echo $user['dep'] ?></td>
                                                <td><?php echo $user['user_role'] ?></td>
                                                <td>
                                                    <a href="<?php echo Route::to('monitor.moduser', $user['username']) ?>" role="button" class="btn btn-primary">修改</a>
                                                    <form name="deluserForm" method="post" action="<?php echo Route::to('monitor.deluser', $user['username']) ?>" role="form">
                                                        <buttom type="submit" class="btn btn-danger">删除</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
