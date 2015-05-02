                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['year'] ?>-<?php echo $session['year'] + 1 ?>学年<?php echo Dictionary::get('xq', $session['term']) ?><?php echo '' == $department ? '全校' : $department ?>公共课评教结果对比表</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <form name="kcpjdbForm" id="kcpjdbForm" action="<?php echo Route::to('monitor.jspjmx') ?>" role="form" class="form-inline">
                                    <div class="form-group">
                                        <label for="course">公共课程</label>
                                        <select name="course" id="course" class="form-control">
                                            <option value=''>== 选择公共课 ==</option>
                                            <?php foreach ($courses as $item): ?>
                                                <option value="<?php echo $item['kch'] ?>" class="<?php echo $item['kkxy'] ?>" <?php echo $item['kch'] == $course ? ' selected' : '' ?>><?php echo $item['kcmc'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">查询</button>
                                </form>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="active">教师工号</th>
                                                <th class="active">教师姓名</th>
                                                <th class="active">教师所在学院</th>
                                                <th class="active">主要授课年级、专业</th>
                                                <th class="active">教学态度得分</th>
                                                <th class="active">教学内容得分</th>
                                                <th class="active">教学方法得分</th>
                                                <th class="active">教学效果得分</th>
                                                <th class="active">综合得分</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data as $item): ?>
                                            <tr>
                                                <td><?php echo $item['jsxm'] ?></td>
                                                <td><?php echo $item['jsyx'] ?></td>
                                                <?php foreach ($item['skzy'] as $skzy): ?>
                                                    <td><?php echo $skzy ?></td>
                                                <?php endforeach; ?>
                                                <td><?php echo $item['jxtd'] ?></td>
                                                <td><?php echo $item['jxnr'] ?></td>
                                                <td><?php echo $item['jxff'] ?></td>
                                                <td><?php echo $item['jxxg'] ?></td>
                                                <td><?php echo $item['zhpf'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="active">平均分</th>
                                                <td><?php echo $avg['jxtd'] ?></td>
                                                <td><?php echo $avg['jxnr'] ?></td>
                                                <td><?php echo $avg['jxff'] ?></td>
                                                <td><?php echo $avg['jxxg'] ?></td>
                                                <td><?php echo $avg['zhpf'] ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
