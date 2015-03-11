                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $year ?>年度<?php echo $term ?>学期<?php echo $students[0]['kcxh'] ?><?php echo $students[0]['xm'] ?>
                        </h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading clearfix">
                                <div class="panel-title pull-left">成绩方式：<?php echo $ratios['name'] ?></div>
                                <?php if (Config::get('score.uncommitted') == $report): ?>
                                    <div class="pull-right">
                                        <form method="post" action="<?php echo Route::to('score.confirm') ?>" role="form">
                                            <button type="button" class="btn btn-primary" title="成绩上报" data-toggle="modal" data-target="#confirmDialog" data-title="成绩上报" data-message="注意：请检查成绩是否已经录入完毕并且正确，成绩确认后将不可更改！">成绩上报</button>
                                            <input type="hidden" name="cno" id="cno" value="<?php echo $info['kcxh'] ?>">
                                        </form>
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
                                                                <form method="post" action="<?php echo Route::to('score.enter', $info['kcxh']) ?>" role="form" onsubmit="return false">
                                                                    <input type="text" name="grade<?php echo $key ?>" value="<?php echo $score['cj' . $key] ?>" size="6" class="form-control">
                                                                </form>
                                                            <?php else: ?>
                                                                <p class="form-control-static"><?php echo $score['cj' . $key] ?></p>
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php endforeach; ?>
                                                    <td data-name="total"><p id="total<?php echo $score['xh'] ?>" class="form-control-static"><?php echo $score['zpcj'] ?></p></td>
                                                    <td>
                                                        <?php if (Config::get('score.uncommitted') == $score['tjzt']): ?>
                                                            <form method="post" action="<?php echo Route::to('score.status', $info['kcxh']) ?>" role="form">
                                                                <select name="status<?php echo $score['xh'] ?>" id="status<?php echo $score['xh'] ?>" class="form-control">
                                                                    <?php foreach($statuses as $status): ?>
                                                                        <option value="<?php echo $status['dm'] ?>"<?php echo $status['dm'] === $score['ksztdm'] ? ' selected="selected"' : '' ?>><?php echo $status['mc'] ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </form>
                                                        <?php else: ?>
                                                            <p class="form-control-static"><?php echo $score['kszt'] ?></p>
                                                        <?php endif; ?>
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

                <?php include partial('confirm_dialog') ?>
