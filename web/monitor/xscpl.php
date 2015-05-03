                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['year'] ?>-<?php echo $session['year'] + 1 ?>学年<?php echo Dictionary::get('xq', $session['term']) ?><?php echo '' == $department ? '全校' : $department ?>学生参评率统计表</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <form name="xscplForm" id="xscplForm" action="<?php echo Route::to('monitor.xscpl') ?>" role="form" class="form-inline">
                                    <div class="form-group">
                                        <label for="department">学院</label>
                                        <select name="department" id="department" class="form-control">
                                            <option value=''>== 全部学院 ==</option>
                                            <?php foreach ($departments as $item): ?>
                                                <option value="<?php echo $item['c_mc'] ?>"<?php echo $item['c_mc'] == $department ? ' selected' : '' ?>><?php echo $item['c_mc'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="property">课程</label>
                                        <select name="property" id="property" class="form-control">
                                            <option value=''>== 所有课程 ==</option>
                                            <?php foreach (Dictionary::getAll('xz') as $item): ?>
                                                <option value="<?php echo $item['mc'] ?>"<?php echo $item['dm'] == $property ? ' selected' : '' ?>><?php echo $item['mc'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="order">排序方式</label>
                                        <select name="order" id="order" class="form-coonrol">
                                            <option value='college'>学院</option>
                                            <option value='teacher'>教师</option>
                                            <option value='course'>课程</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">确定</button>
                                </form>
                                <div class="pull-right">导出表格</div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
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
                                            <?php foreach ($data as $item): ?>
                                            <tr>
                                                <td><?php echo $item['jsxy'] ?></td>
                                                <td><?php echo $item['jsgh'] ?></td>
                                                <td><?php echo $item['jsxm'] ?></td>
                                                <td><?php echo $item['kcmc'] ?></td>
                                                <td><?php echo $item['kcxz'] ?></td>
                                                <?php foreach ($item['skzy'] as $course): ?>
                                                    <td><?php echo $course ?></td>
                                                <?php endforeach ?>
                                                <td><?php echo $item['yprs'] ?></td>
                                                <td><?php echo $item['sprs'] ?></td>
                                                <td><?php echo $item['rate'] ?></td>
                                            </tr>
                                            <?php 
                                                $yprs += $item['yprs'];
                                                $sprs += $item['sprs'];
                                            ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="6" class="active">合计</th>
                                                <td><?php echo $yprs; ?></td>
                                                <td><?php echo $sprs; ?></td>
                                                <td><?php echo ($sprs / $yprs) * 100; ?>%</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="panel-footer">
                                注：<br>①若同一名教师讲授不同课程，其教师姓名重复出现；<br>
②若同一门课程由不同教师分别承担，其课程名称重复出现；<br />
③若出现“教师姓名”、“授课名称”分别相同，而“主要授课年级、专业”不同的情况，属于不同年级或专业合班授课，对于此种情况采取合并处理。“课程序号”和“授课年级、专业”将以一一罗列的方式来呈现。；<br />
④此表设置二级查询：“学院”——“课程性质、类别”，可通过“学院”查询进入对学院的单独统计，在进入“学院”查询的基础上，进入“课程性质、类别”查询，可细化到对某个学院某种性质、类别的课程进行相应统计。当两级查询均选择“全校”，则可实现对全校情况的相应统计。<br />
⑤此表拥有“排序”功能，如可按“教师姓名”进行排序。<br />
⑥此表可反馈给学校相关负责领导、教务处相关负责领导、各学院主管教学副院长。也可面向全校进行反馈。
                            </div>
                        </div>
                    </div>
                </section>
