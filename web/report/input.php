<?php section('header') ?>
<?php section('teacher.navigation') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $info['xy'] ?><?php echo $info['nj'] ?>级<?php echo $info['zy'] ?>专业<?php echo $info['kcxh'] ?><?php echo $info['kcmc'] ?>成绩录入
                        </h1>
                        <div class="alert alert-danger" role="alert">录入成绩自动提交，无需点击提交按钮</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">成绩方式：<?php echo $grades['name'] ?>
                                <!--span class="pull-right">
                                    <form method="post" action="<?php echo toLink('report.confirm', $info['kcxh']) ?>" role="form">
                                        <button type="submit" class="btn btn-success">确认成绩</button>
                                    </form>
                                </span-->
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive tab-table">
                                    <table class="table table-bordered table-striped table-hover data-table">
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
                                                    <td>
                                                        <form method="post" action="<?php echo toLink('report.enter', $info['kcxh']) ?>" role="form">
                                                            <input type="text" name="grade<?php echo $grade['id'] ?>" value="<?php echo $score['cj' . $grade['id']] ?>">
                                                        </form>
                                                    </td>
                                                <?php endforeach; ?>
                                                <td data-name="total"><?php echo $score['zpcj'] ?></td>
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
