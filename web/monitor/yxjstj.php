                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['year'] ?>-<?php echo $session['year'] + 1 ?>学年<?php echo Dictionary::get('xq', $session['term']) ?><?php echo '' == $department ? '全校' : $department ?>评教排名优秀教师得分统计表</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <form name="kcpjdbForm" id="kcpjdbForm" action="<?php echo Route::to('monitor.jspjmx') ?>" role="form" class="form-inline">
                                    <div class="form-group">
                                        <label for="course">课程</label>
                                        <select name="course" id="course" class="form-control">
                                            <option value=''>== 所有课程 ==</option>
                                            <?php foreach (Dictionary::getAll('xz') as $item): ?>
                                                <option value="<?php echo $item['kch'] ?>"<?php echo $item['kch'] == $course ? ' selected' : '' ?>><?php echo $item['kcmc'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="teacher">优秀教师数</label>
                                        <input name="teacher" id="teacher" type="text" class="form-control" placeholder="请输入优秀教师数" value="<?php echo $teacher ? $teacher : 20 ?>">
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
                                                <th class="active">教师职称</th>
                                                <th class="active">教师所在学院</th>
                                                <th class="active">课程名称</th>
                                                <th class="active">课程序号</th>                                                
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
                                            <?php 
                                                foreach ($item['kcmc'] as $v) {
                                                    $rowspan += (count($v) - 1);
                                                }
                                            ?>
                                            <tr>
                                                <td rowspan="<?php echo $rowspan ?>"><?php echo $item['jsgh'] ?></td>
                                                <td rowspan="<?php echo $rowspan ?>"><?php echo $item['jsxm'] ?></td>
                                                <td rowspan="<?php echo $rowspan ?>"><?php echo $item['jszc'] ?></td>
                                                <td rowspan="<?php echo $rowspan ?>"><?php echo $item['jsyx'] ?></td>
                                                <?php foreach ($item['kcmc'] as $key => $value): ?>
                                                <?php $rowspan = count($value) - 1; ?>
                                                    <td rowspan="<?php echo $rowspan ?>"><?php echo $key ?></td>
                                                    <td rowspan="<?php echo $rowspan ?>"><?php echo $value['kch'] ?></td>
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
                                注：<br>①若同一门课程由不同教师分别承担，其课程名称重复出现；<br>
②若一名教师讲授多门课程，其教师姓名重复出现；<br>
③若出现“教师姓名”、“授课名称”分别相同，而“主要授课年级、专业”不同的情况，属于不同年级或专业合班授课，对于此种情况采取合并处理，“主要授课年级、专业”采取罗列方式呈现；<br>
④此表设置“课程性质、类别”、“表彰教师人数”两个查询。可实现对某类课程（如专业必修课）在指定表彰人数内的相关统计。当“课程性质、类别”选择“全部”的时候，则可实现对全部课程进行相应统计；<br>
⑤此表按照“高分——低分”顺序排列；<br>
⑥此表可反馈给学校相关负责领导、教务处相关负责领导、各学院主管教学副院长。也可面向全校进行反馈。
                            </div>
                        </div>
                    </div>
                </section>
