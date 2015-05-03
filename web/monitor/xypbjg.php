                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['year'] ?>-<?php echo $session['year'] + 1 ?>学年<?php echo Dictionary::get('xq', $session['term']) ?><?php echo '' == $department ? '全校' : $department ?>学院评教结果对比表</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="pull-right">导出表格</div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="active">学院</th>
                                                <th class="active">评教教师数</th>
                                                <th class="active">评教课程数</th>
                                                <th class="active">参评学生人次</th>
                                                <th class="active">评教平均分</th>
                                                <th class="active">排名</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i = 0; $i < count($data); ++$i): ?>
                                            <?php $number = $i + 1; ?>
                                            <tr>
                                                <td><?php echo $item[$i][3] ?></td>
                                                <td><?php echo $item[$i][1] ?></td>
                                                <td><?php echo $item[$i][2] ?></td>
                                                <td><?php echo $item[$i][4] ?></td>
                                                <td><?php echo $item[$i][0] ?></td>
                                                <td><?php echo $number ?></td>
                                            </tr>
                                            <?php endfor; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="active">合计</th>
                                                <td><?php echo $pjjs; ?></td>
                                                <td><?php echo $pjkc; ?></td>
                                                <td><?php echo $pjrs; ?></td>
                                                <td><?php echo $avge; ?></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="panel-footer">
                                注：<br>①评教教师数、评教课程数均不累加统计，参评学生人次则累加统计。<br>
    ②此表可反馈给学校相关负责领导、教务处相关负责领导、各学院主管教学副院长。也可面向全校进行反馈。
                            </div>
                        </div>
                    </div>
                </section>
