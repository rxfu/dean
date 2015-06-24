                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $info['kkxy'] ?><?php echo $info['nj'] ?>级<?php echo $info['zy'] ?>专业<?php echo $info['kcxh'] ?><?php echo $info['kcmc'] ?>课程评教得分结果</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">得分情况</div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="active">一级指标</th>
                                                <th class="active">二级指标</th>
                                                <th class="active">二级指标得分</th>
                                                <th class="active">一级指标得分</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($indexes['zb'] as $key => $index): ?>
                                            <tr>
                                                <td<?php echo $index['total'] ? ' rowspan="' . $index['total'] . '"': '' ?>><?php echo $key ?>.<?php echo $index['zb_mc'] ?></td>
                                                <td><?php echo $index['ejzb'][0]['ejzb_id'] ?>.<?php echo $index['ejzb'][0]['ejzb_mc'] ?></td>
                                                <td><?php echo $index['ejzb'][0]['score'] ?></td>
                                                <td<?php echo $index['total'] ? ' rowspan="' . $index['total'] . '"' : '' ?>><?php echo $indexes[$key] ?></td>
                                            </tr>
                                                <?php foreach ($index['ejzb'] as $k => $score): ?>
                                                    <?php if (0 != $k): ?>
                                                        <tr>
                                                            <td><?php echo $score['ejzb_id'] ?>.<?php echo $score['ejzb_mc'] ?></td>
                                                            <td><?php echo $score['score'] ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td class="active text-right" colspan="4">综合评分：<?php echo $indexes['zhpf'] ?>分</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">学生评语，共<?php echo count($comments) ?>条评语</div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="active"><i>#</i></th>
                                                <th class="active">优点</th>
                                                <th class="active">缺点</th>
                                                <th class="active">在教学方面，您的学生最想对您说的一句话</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0 ?>
                                            <?php foreach ($comments as $comment): ?>
                                            <tr>
                                                <td><i>#<?php echo ++$i ?></i></td>
                                                <td class="text-success"><?php echo $comment['c_yd'] ?></td>
                                                <td class="text-danger"><?php echo $comment['c_qd'] ?></td>
                                                <td class="text-info"><?php echo $comment['c_one'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
