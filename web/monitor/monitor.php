                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['year'] ?>-<?php echo $session['year'] + 1 ?>学年<?php echo Dictionary::get('xq', $session['term']) ?>未评教完的学生名单</h1>
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
                                                <th class="active">学院</th>
                                                <th class="active">学号</th>
                                                <th class="active">姓名</th>
                                                <th class="active">年级</th>
                                                <th class="active">专业</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($monitors as $monitor): ?>
                                            <tr>
                                                <td><?php echo $monitor['id'] ?></td>
                                                <td><?php echo $monitor['xymc'] ?></td>
                                                <td><?php echo $monitor['c_xh'] ?></td>
                                                <td><?php echo $monitor['c_xm'] ?></td>
                                                <td><?php echo $monitor['c_nj'] ?></td>
                                                <td><?php echo $monitor['c_zy'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
