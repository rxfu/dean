<?php section('header') ?>
<?php section('student.navigation') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo Session::read('name') ?>同学<?php echo Session::read('year') ?>年度<?php echo Dictionary::get('xq', Session::read('term')) ?>学期<?php echo $title ?>选课表</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
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
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <?php foreach (array_keys($courses) as $campus): ?>
                                                <div id="campus-<?php echo $campus ?>" class="tab-pane fade<?php echo Session::read('campus') == $campus ? ' in active' : '' ?>" role="tabpanel">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-striped table-hover data-table">
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
                                                                <tr>
                                                                    <td class="text-center"><input type="checkbox" value="<?php echo $course['kcxh'] ?>"<?php echo FORBIDDEN == $course['zt'] ? ' disabled' : (SELECTED == $course['zt'] ? ' checked' : '') ?>></td>
                                                                    <td><?php echo $course['kcxh'] ?></td>
                                                                    <td><?php echo $course['kcmc'] ?></td>
                                                                    <td><?php echo $course['xf'] ?></td>
                                                                    <td><?php echo $course['kh'] ?></td>
                                                                    <td><?php echo $course['ksz'] ?>~<?php echo $course['jsz'] ?></td>
                                                                    <td><?php echo $course['zc'] ?></td>
                                                                    <td><?php echo $course['ksj'] ?>
                                                                        <?php echo $course['jsj'] <= $course['ksj'] ? '' : '~' . $course['jsj'] ?></td>
                                                                    <td><?php echo Dictionary::get('xqh', $course['xqh']) ?></td>
                                                                    <td><?php echo $course['jsxm'] ?></td>
                                                                    <td><?php echo $course['rs'] ?></td>
                                                                </tr>
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
                        <?php endif ?>
                    </div>
                </div>
            </div>
<?php section('footer') ?>
<!--
<script>
    $('#campus-tab a[href="#campus-' + <?php echo Session::read('campus') ?> + '"]').tab('show');
    $('#campus-tab a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $('input:checkbox').click(function(e) {
        if (true == $(this).is(':checked')) {         
            $('input[value=' + $(this).val() + ']').each(function() {
                $(this).prop('checked', true);
            });
            $.ajax({
                type: "post",
                url: "<?php echo toLink('course.select') ?>",
                data: { course: $(this).val() }
            });
        } else if (false == $(this).is(':checked')){
            $('input[value=' + $(this).val() + ']').each(function() {
                $(this).prop('checked', false);
            });
        }
    });
</script>

<div class="modal fade" id="checkModal" tabindex="-1" role="dialog" aria-labelledby="checkModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="checkModalLabel">选课时间冲突</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary">确认</button>
      </div>
    </div>
  </div>
</div>
-->