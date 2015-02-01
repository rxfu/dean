<?php section('header') ?>
<?php section('teacher.navigation') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $info['kkxy'] ?><?php echo $info['nj'] ?>级<?php echo $info['zy'] ?>专业<?php echo $info['kcxh'] ?><?php echo $info['kcmc'] ?>成绩录入
                        </h1>
                        <div class="alert alert-danger" role="alert">录入成绩自动提交，无需点击提交按钮</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading clearfix">
                                <div class="panel-title pull-left">成绩方式：<?php echo $ratios['name'] ?></div>
                                <div class="pull-right"><button class="btn btn-primary" title="成绩确认" data-toggle="modal" data-target="#gradeConfirm">成绩确认</button></div>
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
                                                <td><?php echo $score['xh'] ?></td>
                                                <td><?php echo $score['xm'] ?></td>
                                                <?php foreach($ratios['mode'] as $key => $value): ?>
                                                    <td>
                                                        <?php if (UNCOMMITTED == $score['tjzt']): ?>
                                                            <form class="gradeForm" method="post" action="<?php echo toLink('report.enter', $info['kcxh']) ?>" role="form" onsubmit="return false">
                                                                <input type="text" name="grade<?php echo $key ?>" value="<?php echo $score['cj' . $key] ?>">
                                                            </form>
                                                        <?php elseif (COMMITTED == $score['tjzt']): ?>
                                                            <?php echo $score['cj' . $key] ?>
                                                        <?php endif; ?>
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
                            <a role="button" class="btn btn-primary" id="confirm" href="<?php echo toLink('report.confirm', $info['kcxh']) ?>">确定</a>
                        </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>
<?php section('footer') ?>
