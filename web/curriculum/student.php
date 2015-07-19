                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $year ?>年度<?php echo Dictionary::get('xq', $term) ?>学期<?php echo $students[0]['kcxh'] ?><?php echo $students[0]['kcmc'] ?>课程学生名单
                        </h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading clearfix">
                                <div class="panel-title">
                                    <div class="pull-right">
                                        <a type="button" href="<?php echo Route::to('curriculum.download', $year, $term, $students[0]['kcxh']) ?>" class="btn btn-primary" title="下载学生名单">下载名单</a>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive tab-table">
                                    <table class="table table-bordered table-striped table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th class="active">学号</th>
                                                <th class="active">姓名</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($students as $student): ?>
                                                <tr>
                                                    <td><?php echo $student['xh'] ?></td>
                                                    <td><?php echo $student['xm'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
