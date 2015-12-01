                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $info['nd'] ?>年度<?php echo Dictionary::get('xq', $info['xq']) ?>学期<?php echo $info['kcxh'] ?><?php echo $info['kcmc'] ?>课程评学结果</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="active">序号</th>
                                                <th class="active">评价指标</th>
                                                <th class="active">评价标准</th>
                                                <th class="active">最高分值</th>
                                                <th class="active">评分分值</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total = 0?>
                                            <?php foreach ($results as $result): ?>
                                                <?php $total += $result['fz']?>
                                                <tr>
                                                    <td><?php echo $result['xh'] ?></td>
                                                    <td><?php echo $result['zbmc'] ?></td>
                                                    <td><?php echo $result['bzmc'] ?></td>
                                                    <td><?php echo $result['zgfz'] ?></td>
                                                    <td><?php echo $result['fz'] ?></td>                                                   </td>
                                                </tr>
                                            <?php endforeach;?>
                                            <tr>
                                                <th>评价等级与总分</th>
                                                <th>等级</th>
                                                <td><?php echo $grade ?></td>
                                                <th>总分</th>
                                                <td><?php echo $total ?></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5">备注：优秀（90分以上）、良好（80~89分）、中等（70~79分）、合格（60~69分）、不合格（59分以下）</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
