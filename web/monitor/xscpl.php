                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">学生参评率统计表</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-headig">
                                <form name="xscplForm" id="xscplForm" action="<?php echo Route::to('monitor.xscpl') ?>" role="form" class="form-inline">
                                    <select name="department" id="department">
                                        <?php foreach ($departments as $department): ?>
                                            <option value="<?php echo $department[1] ?>"><?php echo $department</option>
                                        <?php endforeach ?>
                                    </select>
                                </form>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th class="active">所在学院</th>
                                                <th class="active">教师工号</th>
                                                <th class="active">教师姓名</th>
                                                <th class="active">授课名称</th>
                                                <th class="active">课程性质</th>
                                                <th class="active">主要授课年级、专业</th>
                                                <th class="active">应评人数</th>
                                                <th class="active">实评人数</th>
                                                <th class="active">参评率</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($courses as $course): ?>
                                            <tr>
                                                <td><?php echo $course['kch'] ?></td>
                                                <td><?php echo $course['kcmc'] ?></td>
                                                <td><?php echo $course['kcywmc'] ?></td>
                                                <td><?php echo $course['xf'] ?></td>
                                                <td><?php echo $course['xs'] ?></td>
                                                <td><?php echo $course['ff'] ?></td>
                                                <td><?php echo $course['jc'] ?></td>
                                                <td><?php echo $course['cks'] ?></td>
                                                <td><?php echo $course['kh'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
