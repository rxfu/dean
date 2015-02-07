<?php section('header') ?>
                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">个人资料</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">基本资料</div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="active">工号</th>
                                            <td><?php echo $profile['jsgh'] ?></td>
                                            <th class="active">姓名</th>
                                            <td><?php echo $profile['xm'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">性别</th>
                                            <td><?php echo $profile['xb'] ?></td>
                                            <th class="active">出生日期</th>
                                            <td><?php echo $profile['csrq'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">证件类型</th>
                                            <td><?php echo $profile['zjlx'] ?></td>
                                            <th class="active">证件号码</th>
                                            <td><?php echo $profile['sfzh'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">国籍</th>
                                            <td><?php echo $profile['gj'] ?></td>
                                            <th class="active">民族</th>
                                            <td><?php echo $profile['zc'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">学历</th>
                                            <td><?php echo $profile['xl'] ?></td>
                                            <th class="active">学位</th>
                                            <td><?php echo $profile['xw'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">专业</th>
                                            <td><?php echo $profile['zy'] ?></td>
                                            <th class="active">学院</th>
                                            <td><?php echo $profile['xy'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">系所</th>
                                            <td><?php echo $profile['xs'] ?></td>
                                            <th class="active">教研室</th>
                                            <td><?php echo $profile['jys'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">简介</th>
                                            <td colspan="3"><?php echo $profile['jj'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
<?php section('footer') ?>
