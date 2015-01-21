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
                            <div class="panel-heading">成绩方式：<?php echo $grades['name'] ?></div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="active">学号</th>
                                                <th class="active">姓名</th>
                                                <?php foreach($grades['mode'] as $grade): ?>
                                                    <th class="active"><?php echo $grade['idm'] ?>
                                                <?php endforeach; ?>
                                                <th class="active">总评</th>
                                                <th class="active">状态</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($scores as $score): ?>
                                            <tr data-row="<?php echo $score['xh'] ?>">
                                                <td><?php echo $score['xh'] ?></td>
                                                <td><?php echo $score['xm'] ?></td>
                                                <?php foreach($grades['mode'] as $grade): ?>
                                                    <td><input type="text" name="<?php echo $grade['id'] ?>" value="<?php echo $score['cj'.$grade['id']] ?>"></td>
                                                <?php endforeach; ?>
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
