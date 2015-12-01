                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['year'] ?>年度<?php echo Dictionary::get('xq', $session['term']) ?>学期<?php echo $info['kcxh'] ?><?php echo $info['kcmc'] ?>课程评学录入</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form name="tasForm" id="tasForm" action="<?php echo Route::to('tas.input', $info['kcxh']) ?>" method="post" role="form" onsubmit="confirm('提交后不可更改，你确定要提交吗？')" data-fv-framework="bootstrap" data-fv-icon-valid="glyphicon glyphicon-ok" data-fv-icon-invalid="glyphicon glyphicon-remove" data-fv-icon-validating="glyphicon glyphicon-refresh">
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
                                                <?php foreach ($standards as $standard): ?>
                                                    <?php $total += $standard['fz']?>
                                                    <tr>
                                                        <td><?php echo $standard['xh'] ?></td>
                                                        <td><?php echo $standard['zbmc'] ?></td>
                                                        <td><?php echo $standard['bzmc'] ?></td>
                                                        <td><?php echo $standard['zgfz'] ?></td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="number" name="scores[<?php echo $standard['pjbz_id'] ?>][fz]" placeholder="评分分值" value="<?php echo $standard['fz'] ?>" data-fv-notempty="true" data-fv-notempty-message="必填项，填写完成才能提交" min="0" max="<?php echo $standard['zgfz'] ?>" required<?php echo isset($standard['fz']) ? ' disabled' : '' ?>>
                                                                <input type="hidden" name="scores[<?php echo $standard['pjbz_id'] ?>][pjbz]" value="<?php echo $standard['pjbz_id'] ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach;?>
                                                <tr>
                                                    <th>评价等级与总分</th>
                                                    <th>等级</th>
                                                    <td></td>
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
                                    <?php if (!isset($standards[0]['fz'])): ?>
                                    <div class="col-lg-4 col-lg-offset-4">
                                        <button type="submit" name="submit" title="提交评分" class="btn btn-primary btn-block" onclick="document.tasForm.submit.value='评分提交中，请稍候……';document.tasForm.submit.disabled=true">提交评分</button>
                                    </div>
                                    <?php endif;?>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
