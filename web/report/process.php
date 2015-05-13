                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['name'] ?>同学课程转换申请进度</h1>
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
                                                <th class="active">申请时间</th>
                                                <th class="active">年度</th>
                                                <th class="active">学期</th>
                                                <th class="active">原课程号</th>
                                                <th class="active">原课程名称</th>
                                                <th class="active">原学分</th>
                                                <th class="active">原成绩</th>
                                                <th class="active">原绩点</th>
                                                <th class="active">新课程号</th>
                                                <th class="active">新课程名称</th>
                                                <th class="active">新学分</th>
                                                <th class="active">新成绩</th>
                                                <th class="active">新绩点</th>
                                                <th class="active">申请理由</th>
                                                <th class="active">申请状态</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($courses as $course): ?>
                                            <tr>
                                                <td><?php echo $course['sqrq'] ?></td>
                                                <td><?php echo $course['nd'] ?></td>
                                                <td><?php echo Dictionary::get('xq', $course['xq']) ?></td>
                                                <td><?php echo $course['ykch'] ?></td>
                                                <td><?php echo $course['ykcmc'] ?></td>
                                                <td><?php echo $course['yxf'] ?></td>
                                                <td><?php echo $course['ycj'] ?></td>
                                                <td><?php echo $course['yjd'] ?></td>
                                                <td><?php echo $course['nkch'] ?></td>
                                                <td><?php echo $course['nkcmc'] ?></td>
                                                <td><?php echo $course['nxf'] ?></td>
                                                <td><?php echo $course['ncj'] ?></td>
                                                <td><?php echo $course['njd'] ?></td>
                                                <td><?php echo $course['sqly'] ?></td>
                                                <td>
                                                    <?php if ('4' == $course['tjzt']): ?>
                                                        教务处已拒绝
                                                    <?php elseif ('3' == $course['tjzt']): ?>
                                                        教务处已批准
                                                    <?php elseif ('2' == $course['tjzt']): ?>
                                                        学院已批准
                                                    <?php elseif ('1' == $course['tjzt']): ?>
                                                        <form method="post" name="revoke" action="<?php echo Route::to('report.revoke') ?>" role="form">
                                                            <input type="hidden" name="lcno" value="<?php echo $course['ykch'] ?>">
                                                            <input type="hidden" name="cno" value="<?php echo $course['nkch'] ?>">
                                                            <button type="button" class="btn btn-primary" title="撤销申请" data-toggle="modal" data-target="#confirmDialog" data-title="撤销选课申请" data-message="你确定要撤销<?php echo $course['nkch'] ?>课程的选课申请？">撤销申请</button>
                                                        </form>
                                                    <?php endif; ?>
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

                <?php include partial('confirm_dialog') ?>
