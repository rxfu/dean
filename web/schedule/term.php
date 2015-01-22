<?php section('header') ?>
<?php section('student.navigation') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo Session::read('name') ?>同学<?php echo $year ?>年度<?php echo Dictionary::get('xq', $term) ?>学期课程表</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="active">课程号</th>
                                                <th class="active">课程名称</th>
                                                <th class="active">课程英文名称</th>
                                                <th class="active">学分</th>
                                                <th class="active">所在校区</th>
                                                <th class="active">上课时间</th>
                                                <th class="active">上课教室</th>
                                                <th class="active">任课老师</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($courses as $course): ?>
                                            <tr>
                                                <td><?php echo $course['kch'] ?></td>
                                                <td><?php echo $course['kcmc'] ?></td>
                                                <td><?php echo $course['kcywmc'] ?></td>
                                                <td><?php echo $course['xf'] ?></td>
                                                <td><?php echo $course['xqh'] ?></td>
                                                <td>第 <?php echo $course['ksz'] ?>~<?php echo $course['jsz'] ?> 周<?php echo weekend($course['zc']) ?>
                                                                第 <?php echo $course['ksj'] ?>
                                                                <?php echo $course['jsj'] <= $course['ksj'] ? '' : '~' . $course['jsj'] ?> 节</td>
                                                <td><?php echo $course['jsmc'] ?></td>
                                                <td><?php echo $course['jsxm'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php section('footer') ?>