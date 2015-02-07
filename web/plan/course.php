<?php section('header') ?>
                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">课程基本信息</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th class="active">课程代码</th>
                                                <th class="active">课程名称</th>
                                                <th class="active">英文名称</th>
                                                <th class="active">学分</th>
                                                <th class="active">学时</th>
                                                <th class="active">主要内容</th>
                                                <th class="active">使用教材</th>
                                                <th class="active">参考书目</th>
                                                <th class="active">考核方式</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($courses as $course): ?>
                                            <tr>
                                                <td><?php echo $course['kch'] ?></td>
                                                <td><?php echo $course['kcmc'] ?></td>
                                                <td><?php echo $course['kcywmc'] ?></td>
                                                <td><?php echo $course['xf'] ?></td>
                                                <td><?php echo $course['xs'] ?></td>
                                                <td><?php echo $course['ff'] ?></td>
                                                <td><?php echo $course['jc'] ?></td>
                                                <td><?php echo $course['cks'] ?></td>
                                                <td><?php echo $course['kh'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
<?php section('footer') ?>
