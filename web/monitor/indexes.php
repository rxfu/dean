                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">评教指标管理</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <a href="<?php echo Route::to('monitor.addindex') ?>" role="button" class="btn btn-success">新增用户</a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th class="active">一级指标</th>
                                                <th class="active">编号</th>
                                                <th class="active">权重</th>
                                                <th class="active">二级指标</th>
                                                <th class="active">编号</th>
                                                <th class="active">权重</th>
                                                <th class="active">操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($indexs as $index): ?>
                                            <tr>
                                                <td><?php echo $index['zb_mc'] ?></td>
                                                <td><?php echo $index['zb_id'] ?></td>
                                                <td><?php echo $index['zb_qz'] ?></td>
                                                <td><?php echo $index['ejzb_mc'] ?></td>
                                                <td><?php echo $index['ejzb_id'] ?></td>
                                                <td><?php echo $index['ejzb_qz'] ?></td>
                                                <td>
                                                    <a href="<?php echo Route::to('monitor.modindex', $index['ejzb_id']) ?>" role="button" class="btn btn-primary">修改</a>
                                                    <form name="delindexForm" method="post" action="<?php echo Route::to('monitor.delindex', $index['ejzb_id']) ?>" role="form">
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
