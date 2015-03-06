                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $session['name'] ?>同学综合成绩单
                        </h1>
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
                                                <th class="active">课程英文名称</th>
                                                <th class="active">成绩</th>
                                                <th class="active">学分</th>
                                                <th class="active">绩点</th>
                                                <th class="active">课程平台</th>
                                                <th class="active">课程性质</th>
                                                <th class="active">考核方式</th>
                                                <th class="active">考试状态</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($scores as $score): ?>
                                            <tr>
                                                <td><a href="<?php echo Route::to('report.detail', $score['kch']) ?>"><?php echo $score['kch'] ?></a></td>
                                                <td><?php echo $score['kcmc'] ?></td>
                                                <td><?php echo $score['kcywmc'] ?></td>
                                                <td><?php echo $score['cj'] ?></td>
                                                <td><?php echo $score['xf'] ?></td>
                                                <td><?php echo $score['jd'] ?></td>
                                                <td><?php echo $score['pt'] ?></td>
                                                <td><?php echo $score['xz'] ?></td>
                                                <td><?php echo $score['kh'] ?></td>
                                                <td><?php echo $score['kszt'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
