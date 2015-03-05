                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $info['kkxy'] ?><?php echo $info['nj'] ?>级<?php echo $info['zy'] ?>专业<?php echo $info['kcxh'] ?><?php echo $info['kcmc'] ?>成绩录入
                        </h1>
                        <div class="alert alert-danger" role="alert">注意：录入成绩自动提交，无需点击提交按钮。点击“<strong>成绩上报</strong>”后，<strong>成绩不可更改！</strong></div>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading clearfix">
                                <div class="panel-title pull-left">成绩方式：<?php echo $ratios['name'] ?></div>
                                <?php if (Config::get('score.uncommitted') == $report): ?>
                                    <div class="pull-right">
                                        <button class="btn btn-primary" title="成绩上报" data-toggle="modal" data-target="#gradeConfirm">成绩上报</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive tab-table">
                                    <table class="table table-bordered table-striped table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th class="active">学号</th>
                                                <th class="active">姓名</th>
                                                <?php foreach($ratios['mode'] as $ratio): ?>
                                                    <th class="active"><?php echo $ratio['idm'] ?></th>
                                                <?php endforeach; ?>
                                                <th class="active">总评</th>
                                                <th class="active">状态</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($scores as $score): ?>
                                                <tr data-row="<?php echo $score['xh'] ?>">
                                                    <td><p class="form-control-static"><?php echo $score['xh'] ?></p></td>
                                                    <td><p class="form-control-static"><?php echo $score['xm'] ?></p></td>
                                                    <?php foreach($ratios['mode'] as $key => $value): ?>
                                                        <td>
                                                            <?php if (Config::get('score.uncommitted') == $score['tjzt']): ?>
                                                                <form method="post" action="<?php echo toLink('score.enter', $info['kcxh']) ?>" role="form" onsubmit="return false">
                                                                    <input type="text" name="grade<?php echo $key ?>" value="<?php echo $score['cj' . $key] ?>" size="6" class="form-control">
                                                                </form>
                                                            <?php else: ?>
                                                                <p class="form-control-static"><?php echo $score['cj' . $key] ?></p>
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php endforeach; ?>
                                                    <td data-name="total"><p id="total<?php echo $score['xh'] ?>" class="form-control-static"><?php echo $score['zpcj'] ?></p></td>
                                                    <td>
                                                        <form method="post" action="<?php echo toLink('score.status', $info['kcxh']) ?>" role="form">
                                                            <select name="status<?php echo $score['xh'] ?>" id="status<?php echo $score['xh'] ?>" class="form-control">
                                                                <?php foreach($statuses as $status): ?>
                                                                    <option value="<?php echo $status['dm'] ?>"<?php echo $status['dm'] === $score['ksztdm'] ? ' selected="selected"' : '' ?>><?php echo $status['mc'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="modal fade" id="gradeConfirm" tabindex="-1" role="dialog" aria-labelledby="#gradeConfirmLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="关闭"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="gradeConfirmLabel">成绩确认</h4>
                            </div>
                        <div class="modal-body">
                            <p>注意：请检查成绩是否已经录入完毕并且正确，成绩确认后将不可更改！</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">取消</button>
                            <a role="button" class="btn btn-primary" id="confirm" href="<?php echo toLink('score.confirm', $info['kcxh']) ?>">确定</a>
                        </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
