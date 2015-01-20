<?php section('header') ?>
<?php section('teacher.navigation') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $course['xy'] ?><?php echo $course['nj'] ?>级<?php echo $course['zy'] ?>专业<?php echo $course['kcxh'] ?><?php echo $course['kcmc'] ?>成绩录入
                        </h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="active">学号</th>
                                                <th class="active">姓名</th>
                                                <th class="active">平时</th>
                                                <th class="active">考试</th>
                                                <th class="active">实验</th>
                                                <th class="active">总评</th>
                                                <th class="active">状态</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($scores as $score): ?>
                                            <tr>
                                                <td><?php echo $score['xh'] ?></td>
                                                <td><?php echo $score['xm'] ?></td>
                                                <td><input type="text" name="cj1" value="<?php echo $score['cj1'] ?>"></td>
                                                <td><input type="text" name="cj2" value="<?php echo $score['cj2'] ?>"></td>
                                                <td><input type="text" name="cj3" value="<?php echo $score['cj3'] ?>"></td>
                                                <td><?php echo $score['zpcj'] ?></td>
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
