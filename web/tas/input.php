                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['year'] ?>年度<?php echo Dictionary::get('xq', $session['term']) ?>学期<?php echo $info['kcxh'] ?><?php echo $info['kcmc'] ?>课程评学录入</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form name="tasForm" id="tasForm" action="<?php echo Route::to('tas.input', $info['kcxh']) ?>" method="post" role="form">
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
                                                <?php foreach ($results as $result): ?>
                                                    <tr>
                                                        <td><?php echo $result['xh'] ?></td>
                                                        <td><?php echo $result['zbmc'] ?></td>
                                                        <td><?php echo $result['bzmc'] ?></td>
                                                        <td><?php echo $result['zgfz'] ?></td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" name="scores[<?php echo $result['pjbz_id'] ?>][fz]" placeholder="评分分值" value="<?php echo $result['fz'] ?>" data-fv-notempty="true" data-fv-integer="true" min="0" max="<?php echo $result['zgfz'] ?>" required<?php echo isset($result['fz']) ? ' disabled' : '' ?>>
                                                                <input type="hidden" name="scores[<?php echo $result['pjbz_id'] ?>][pjbz]" value="<?php echo $result['pjbz_id'] ?>">
                                                            </div>
                                                        </td>
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
                                    <?php if (!isset($results[0]['fz'])): ?>
                                    <div class="col-lg-4 col-lg-offset-4">
                                        <button type="submit" name="submitScore" title="提交评分" class="btn btn-primary btn-block">提交评分</button>
                                    </div>
                                    <?php endif;?>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
