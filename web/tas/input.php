                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['year'] ?>年度<?php echo Dictionary::get('xq', $session['term']) ?>学期<?php echo $info['kcxh'] ?><?php echo $info['kcmc'] ?>课程评学录入</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form action="<<?php echo Route::to('tas.input', $info['kcxh']) ?>" method="post" role="form">
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
                                                <?php foreach ($standards as $standard): ?>
                                                <tr>
                                                    <td><?php echo $standard['xh'] ?></td>
                                                    <td><?php echo $standard['zbmc'] ?></td>
                                                    <td><?php echo $standard['bzmc'] ?></td>
                                                    <td><?php echo $standard['zgfz'] ?></td>
                                                    <td>
                                                        <input type="text" name="scores[<?php echo $standard['pjbz_id'] ?>][fz]" placeholder="评分分值" value="<?php echo $standard['fz'] ?>">
                                                        <input type="hidden" name="scores[<?php echo $standard['pjzb_id'] ?>][pjzb_id]" value="<?php echo $standard['pjzb_id'] ?>">
                                                    </td>
                                                </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5">备注：优秀（90分以上）、良好（80~89分）、中等（70~79分）、合格（60~69分）、不合格（59分以下）</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="col-lg-4 col-lg-offset-4">
                                        <button type="submit" title="提交评分" class="btn btn-primary btn-block">提交评分</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
