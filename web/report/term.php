<?php section('header') ?>
<?php section('student.navigation') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo Session::read('name') ?>同学<?php echo $year ?>年度<?php echo Dictionary::get('xq', $term) ?>学期成绩单
                        </h1>
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
                                                <th class="active">课程代码</th>
                                                <th class="active">课程名称</th>
                                                <th class="active">课程英文名称</th>
                                                <th class="active">成绩</th>
                                                <th class="active">学分</th>
                                                <th class="active">绩点</th>
                                                <th class="active">课程性质</th>
                                                <th class="active">考核方式</th>
                                                <th class="active">考试状态</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($scores as $score): ?>
                                            <tr>
                                                <td><?php echo $score['kch'] ?></td>
                                                <td><?php echo $score['kcmc'] ?></td>
                                                <td><?php echo $score['kcywmc'] ?></td>
                                                <td><?php echo $score['cj'] ?></td>
                                                <td><?php echo $score['xf'] ?></td>
                                                <td><?php echo $score['jd'] ?></td>
                                                <td><?php echo $score['kcxz'] ?></td>
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
            </div>
<?php section('footer') ?>