<?php section('header') ?>
                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">选课日志</h1>
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
                                                <th class="active">操作时间</th>
                                                <th class="active">IP地址</th>
                                                <th class="active">课程序号</th>
                                                <th class="active">操作类型</th>
                                                <th class="active">备注</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($logs as $log): ?>
                                            <tr>
                                                <td><?php echo $log['czsj'] ?></td>
                                                <td><?php echo $log['ip'] ?></td>
                                                <td><?php echo $log['kcxh'] ?></td>
                                                <td><?php echo parseType($log['czlx']) ?></td>
                                                <td><?php echo $log['bz'] ?></td>
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
