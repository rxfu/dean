                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">评教评分等级设置</h1>
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
                                                <th class="active">编号</th>
                                                <th class="active">名称</th>
                                                <th class="active">分数</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($grades as $grade): ?>
                                            <tr>
                                                <td><?php echo $grade['rank_id'] ?></td>
                                                <td><?php echo $grade['rank_mc'] ?></td>
                                                <td><?php echo $grade['rank_fs'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
