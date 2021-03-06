                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['name'] ?>同学<?php echo $session['year'] ?>年度<?php echo Dictionary::get('xq', $session['term']) ?>学期<?php echo Config::get('quality.assessing') == $status ? '未评教' : '已评教' ?>课程列表</h1>
                    </div>
                </section>

                <?php if (isEmpty($courses)): ?>
                    <section class="row">
                        <div class="col-lg-12">
                            <div class="well">现在无评教课程</div>
                        </div>
                    </section>
                <?php else: ?>
                    <section class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="active">课程序号</th>
                                                    <th class="active">课程名称</th>
                                                    <th class="active">课程英文名称</th>
                                                    <th class="active">课程平台</th>
                                                    <th class="active">课程性质</th>
                                                    <th class="active">评教状态</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($courses as $course): ?>
                                                <tr>
                                                    <td><?php echo $course['kcxh'] ?></td>
                                                    <td><?php echo $course['kcmc'] ?></td>
                                                    <td><?php echo $course['kcywmc'] ?></td>
                                                    <td><?php echo $course['pt'] ?></td>
                                                    <td><?php echo $course['xz'] ?></td>
                                                    <td><a href="<?php echo Route::to('quality.assess', $course['kcxh'], $status) ?>"><?php echo Config::get('quality.assessing') == $status ? '评教' : '查看' ?></a></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php endif; ?>
