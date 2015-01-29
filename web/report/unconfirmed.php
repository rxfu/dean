<?php section('header') ?>
<?php section('student.navigation') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo Session::read('name') ?>同学<?php echo Session::read('year') ?>年度<?php echo Dictionary::get('xq', Session::read('term')) ?>学期待确认成绩单
                        </h1>
                    </div>
                </div>

                <?php foreach ($scores as $score): ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="active">课程代码</th>
                                                    <th class="active">课程名称</th>
                                                    <th class="active">课程英文名称</th>
                                                    <?php foreach ($score['radios']['mode'] as $ratio): ?>
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
                                                    <td><?php echo $score['kcxh'] ?></td>
                                                    <td><?php echo $score['kcmc'] ?></td>
                                                    <td><?php echo $score['kcywmc'] ?></td>
                                                    <?php foreach ($score['radios']['mode'] as $key => $value): ?>
                                                        <td><?php echo $course['cj' . $key] ?></td>
                                                    <?php endforeach; ?>
                                                    <td><?php echo $score['zpcj'] ?></td>
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
                    </div>
                <?php endforeach;?>
            </div>
<?php section('footer') ?>
