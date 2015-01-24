<?php section('header') ?>
<?php section('student.navigation') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo Session::read('name') ?>同学<?php echo Session::read('year') ?>年度<?php echo Dictionary::get('xq', Session::read('term')) ?>学期重修课程检索</h1>
                        <div class="alert alert-danger" role="alert">请输入课程序号或课程中文名称进行检索并申请重修</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <form class="form-inline" method="post" action="<?php echo toLink('course.search', 'retake') ?>" role="form">
                            <div class="input-group">
                                <div class="form-group">
                                    <label class="sr-only" for="courseSearch">课程检索</label>
                                    <input type="text" class="form-control" id="courseSearch" name="courseSearch" placeholder="请输入课程序号或课程名称...">
                                </div>
                                  <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button">Go!</button>
                                  </span>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
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
                                                                <tr data-row="<?php echo $course[0]['kcxh'] ?>">
                                                                    <?php $rowspan = count($course) ?>
                                                                    <td rowspan="<?php echo $rowspan ?>" class="text-center" id="<?php echo $course[0]['kcxh'] ?>">
                                                                        <?php if (UNAUDIT == $course[0]['zt']): ?>
                                                                            待审核
                                                                        <?php else: ?>
                                                                            <form method="post" action="<?php echo toLink('course.apply') ?>" role="form">
                                                                                <button type="submit" name="retake<?php echo $course[0]['kch'] ?>" value="<?php echo $course[0]['kcxh'] ?>" title="申请重修" data-toggle="modal" data-target="#dialogConfirm" class="btn btn-primary<?php echo FORBIDDEN === $course[0]['zt'] ? ' disabled' : (SELECTED === $course[0]['zt'] ? ' checked' : '') ?>">申请重修</button>
                                                                            </form>
                                                                        <?php endif; ?>
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
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="dialogConfirm" tabindex="-1" role="dialog" aria-labelledby="#dialogConfirmLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="关闭"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="dialogConfirmLabel">确认申请重修</h4>
                      </div>
                      <div class="modal-body">
                        <p>确认申请重修？</p>
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
