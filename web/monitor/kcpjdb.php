                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['year'] ?>-<?php echo $session['year'] + 1 ?>学年<?php echo Dictionary::get('xq', $session['term']) ?><?php echo '' == $department ? '全校' : $department ?>“一门课程多名教师讲授”评教结果横向对比表</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <form name="xscplForm" id="xscplForm" action="<?php echo Route::to('monitor.jspjmx') ?>" role="form" class="form-inline">
                                    <div class="form-group">
                                        <label for="department">开课学院</label>
                                        <select name="department" id="department" class="form-control">
                                            <option value=''>== 选择学院 ==</option>
                                            <?php foreach ($departments as $item): ?>
                                                <option value="<?php echo $item['c_mc'] ?>"<?php echo $item['c_mc'] == $department ? ' selected' : '' ?>><?php echo $item['c_mc'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="course">课程</label>
                                        <select name="course" id="course" class="form-control">
                                            <option value=''>== 选择课程 ==</option>
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
                            <div class="panel-footer">
                                注：<br>①此表包含“一门课程一名教师讲授”情况；<br>
②若出现“教师姓名”、“授课名称”分别相同，而“主要授课年级、专业”不同的情况，属于不同年级或专业合班授课，对于此种情况采取合并处理，“主要授课年级、专业”采取罗列方式呈现；<br>
③此表设置三级查询：“学院”（一级查询）——“课程名称”（二级查询）。通过二级查询可获取所选学院所选课程类别、性质所选具体课程的相关统计；<br>
④此表可反馈给学校相关负责领导、教务处相关负责领导、各学院主管教学副院长。也可面向教师个人进行反馈。
                            </div>
                        </div>
                    </div>
                </section>
