                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $session['name'] ?>同学<?php echo $cname ?>课程详细成绩单
                        </h1>
                    </div>
                </section>

                 <?php foreach ($scores as $score): ?>
                    <section class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="active">年度</th>
                                                    <th class="active">学期</th>
                                                    <th class="active">课程代码</th>
                                                    <th class="active">课程名称</th>
                                                    <th class="active">课程英文名称</th>
                                                    <th class="active">课程平台</th>
                                                    <th class="active">课程性质</th>
                                                    <?php foreach ($score['ratios']['mode'] as $ratio): ?>
                                                        <th class="active"><?php echo $ratio['idm'] ?></th>
                                                    <?php endforeach; ?>
                                                    <th class="active">总评成绩</th>
                                                    <th class="active">考核方式</th>
                                                    <th class="active">考试状态</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($score['courses'] as $course): ?>
                                                <tr>
                                                    <td><?php echo $course['nd'] ?></td>
                                                    <td><?php echo Dictionary::get('xq', $course['xq']) ?></td>
                                                    <td><?php echo $course['kcxh'] ?></td>
                                                    <td><?php echo $course['kcmc'] ?></td>
                                                    <td><?php echo $course['kcywmc'] ?></td>
                                                    <td><?php echo $course['pt'] ?></td>
                                                    <td><?php echo $course['xz'] ?></td>
                                                    <?php foreach ($score['ratios']['mode'] as $key => $value): ?>
                                                        <td><?php echo $course['cj' . $key] ?></td>
                                                    <?php endforeach; ?>
                                                    <td><?php echo $course['zpcj'] ?></td>
                                                    <td><?php echo $course['kh'] ?></td>
                                                    <td><?php echo $course['kszt'] ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php endforeach; ?>
