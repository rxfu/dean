<?php section('header') ?>
<?php section('student.navigation') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo Session::read('name') ?>同学<?php echo Session::read('year') ?>年度<?php echo Dictionary::get('xq', Session::read('term')) ?>学期<?php echo $title ?>课程选课表</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?php if(empty($courses)): ?>
                                    <div class="well">现在无可选课程</div>
                                <?php else: ?>
                                    <div role="tabpanel">
                                        <ul id="campus-tab" class="nav nav-tabs" role="tablist">
                                            <?php foreach (array_keys($courses) as $campus): ?>
                                                <?php $campusId = 'campus-' . $campus ?>
                                                <li role="presentation"><a href="#<?php echo $campusId ?>" aria-controls="<?php echo $campusId ?>" role="tab" data-toggle="tab"><?php echo Dictionary::get('xqh', $campus) ?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                        <div class="tab-content">
                                            <?php foreach (array_keys($courses) as $campus): ?>
                                                <div id="campus-<?php echo $campus ?>" class="tab-pane fade<?php echo Session::read('campus') == $campus ? ' in active' : '' ?>" role="tabpanel">
                                                    <div class="table-responsive tab-table">
                                                        <table class="table table-bordered table-striped table-hover course-table">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2" class="active">操作</th>
                                                                    <th rowspan="2" class="active">课程序号</th>
                                                                    <th rowspan="2" class="active">课程名称</th>
                                                                    <th rowspan="2" class="active">学分</th>
                                                                    <th rowspan="2" class="active">考核方式</th>
                                                                    <th colspan="3" class="active text-center">上课时间</th>
                                                                    <th rowspan="2" class="active">所在校区</th>
                                                                    <th rowspan="2" class="active">主要任课老师</th>
                                                                    <th rowspan="2" class="active">上课人数</th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="active">起始周次</th>
                                                                    <th class="active">星期</th>
                                                                    <th class="active">起始节数</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($courses[$campus] as $course): ?>
                                                                    <tr data-name="<?php echo $course[0]['kcxh'] ?>">
                                                                        <?php $rowspan = count($course) ?>
                                                                        <td rowspan="<?php echo $rowspan ?>" class="text-center">
                                                                            <form method="post" action="<?php echo toLink('course.select') ?>" role="form">
                                                                                <div class="checkbox">
                                                                                    <label>
                                                                                        <input type="checkbox" value="<?php echo $course[0]['kcxh'] ?>" title="选课" data-toggle="modal" data-target="#dialogConfirm" data-whatever="<?php echo $course[0]['kcmc'] . '(' . $course[0]['kcxh'] . ')' ?>"<?php echo FORBIDDEN === $course[0]['zt'] ? ' disabled' : (SELECTED === $course[0]['zt'] ? ' checked' : '') ?>>
                                                                                    </label>
                                                                                </div>
                                                                            </form>
                                                                        </td>
                                                                        <td rowspan="<?php echo $rowspan ?>"><?php echo $course[0]['kcxh'] ?></td>
                                                                        <td rowspan="<?php echo $rowspan ?>"><?php echo $course[0]['kcmc'] ?></td>
                                                                        <td rowspan="<?php echo $rowspan ?>"><?php echo $course[0]['xf'] ?></td>
                                                                        <td rowspan="<?php echo $rowspan ?>"><?php echo $course[0]['kh'] ?></td>
                                                                        <td><?php echo $course[0]['ksz'] ?>~<?php echo $course[0]['jsz'] ?></td>
                                                                        <td><?php echo $course[0]['zc'] ?></td>
                                                                        <td><?php echo $course[0]['ksj'] ?><?php echo $course[0]['jsj'] <= $course[0]['ksj'] ? '' : '~' . $course[0]['jsj'] ?></td>
                                                                        <td><?php echo Dictionary::get('xqh', $course[0]['xqh']) ?></td>
                                                                        <td><?php echo $course[0]['jsxm'] ?></td>
                                                                        <td><?php echo $course[0]['rs'] ?></td>
                                                                    </tr>
                                                                    <?php for($i = 1; $i < $rowspan; ++$i): ?>
                                                                        <tr data-name="<?php echo $course[0]['kcxh'] ?>">
                                                                            <?php for($j = 0; $j < 5; ++$j): ?>
                                                                                <td style="display: none"></td>
                                                                            <?php endfor; ?>
                                                                            <td><?php echo $course[$i]['ksz'] ?>~<?php echo $course[$i]['jsz'] ?></td>
                                                                            <td><?php echo $course[$i]['zc'] ?></td>
                                                                            <td><?php echo $course[$i]['ksj'] ?><?php echo $course[$i]['jsj'] <= $course[$i]['ksj'] ? '' : '~' . $course[$i]['jsj'] ?></td>
                                                                            <td><?php echo Dictionary::get('xqh', $course[$i]['xqh']) ?></td>
                                                                            <td><?php echo $course[$i]['jsxm'] ?></td>
                                                                            <td><?php echo $course[$i]['rs'] ?></td>
                                                                        </tr>
                                                                    <?php endfor; ?>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="dialogConfirm" tabindex="-1" role="dialog" aria-labelledby="#dialogConfirmLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="关闭"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="dialogConfirmLabel">确认选课</h4>
                      </div>
                      <div class="modal-body">
                        <p>即将选择<span id="course" class="text-danger"></span>课程，确认选课？</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-primary">确定</button>
                      </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>
<?php section('footer') ?>
<script>
    var campusId = '#campus-<?php echo Session::read('campus') ?>';
    if ($('#campus-tab a[href="' + campusId + '"]').length) {
        $('#campus-tab a[href="' + campusId + '"]').tab('show');
    } else {
        $('#campus-tab a:first').tab('show');
    }
</script>
