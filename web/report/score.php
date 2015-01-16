<?php section('header') ?>
<?php section('teacher.navigation') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">**学院**专业**课程号**课程成绩单</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">                            
                            <div class="panel-heading">
                                共<?php echo $count ?>门课程，共<?php echo $pages ?>页，目前在第
                                <select onchange="window.location=this.value;">
                                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                                    <option value="<?php echo toLink('plan.course', array($i)) ?>"<?php echo ($p == $i) ? ' selected' : ''?>><?php echo $i ?></option>
                                    <?php endfor ?>
                                </select>
                                页
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th class="active">学号</th>
                                                <th class="active">姓名</th>
                                                <th class="active">平时</th>
                                                <th class="active">考试</th>
                                                <th class="active">实验</th>
                                                <th class="active">总评</th>
                                                <th class="active">状态</th>
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
                                        <tfoot>
                                            <tr>
                                                <td colspan="10" class="text-right">
                                                    <form method="post" action="<?php echo toLink('report.confirm', $course['kcxh']) ?>" role="form">
                                                        <button type="submit" name="confirm" value="<?php echo $course[0]['kcxh'] ?>" class="btn btn-primary<?php echo FORBIDDEN === $course[0]['zt'] ? ' disabled' : (SELECTED === $course[0]['zt'] ? ' checked' : '') ?>">确认成绩</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php section('footer') ?>
