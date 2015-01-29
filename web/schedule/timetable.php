<?php section('header') ?>
<?php section('student.navigation') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo Session::read('name') ?>同学<?php echo Session::read('year') ?>年度<?php echo Dictionary::get('xq', Session::read('term')) ?>学期课程表</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="active">节次</th>
                                                <th class="active">星期一</th>
                                                <th class="active">星期二</th>
                                                <th class="active">星期三</th>
                                                <th class="active">星期四</th>
                                                <th class="active">星期五</th>
                                                <th class="active">星期六</th>
                                                <th class="active">星期日</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i = 1; $i <= 5; ++$i): ?>
                                                <tr>
                                                    <?php if (1 == $i): ?>
                                                        <th rowspan="5" class="active text-center" style="vertical-align:middle">上午</th>
                                                    <?php endif; ?>
                                                    <th class="active">第<?php echo $i ?>节</th>
                                                    <?php for ($j = 1; $j <= 7; ++$j): ?>
                                                        <td>
                                                            <?php if (is_array($courses[$i][$j])): ?>
                                                                <?php foreach ($courses[$i][$j] as $course): ?>
                                                                    <?php echo $course['kcmc'] ?><br>
                                                                    <?php echo $course['xqh'] ?>校区<?php echo $course['jsmc'] ?>教室<br>
                                                                    <?php echo $course['jsxm'] ?><br>
                                                                    第 <?php echo $course['ksz'] ?>~<?php echo $course['jsz'] ?> 周
                                                                    <hr>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php endfor; ?>
                                                </tr>
                                            <?php endfor; ?>
                                            <tr>
                                                <td colspan="9" class="text-center">午休</td>
                                            </tr>
                                            <?php for ($i = 6; $i <= 9; ++$i): ?>
                                                <tr>
                                                    <?php if (6 == $i): ?>
                                                        <th rowspan="4" class="active text-center" style="vertical-align:middle">下午</th>
                                                    <?php endif; ?>
                                                    <th class="active">第<?php echo $i ?>节</th>
                                                    <?php for ($j = 1; $j <= 7; ++$j): ?>
                                                        <td>
                                                            <?php if (is_array($courses[$i][$j])): ?>
                                                                <?php foreach ($courses[$i][$j] as $course): ?>
                                                                    <?php echo $course['kcmc'] ?><br>
                                                                    <?php echo $course['xqh'] ?>校区<?php echo $course['jsmc'] ?>教室<br>
                                                                    <?php echo $course['jsxm'] ?><br>
                                                                    第 <?php echo $course['ksz'] ?>~<?php echo $course['jsz'] ?> 周
                                                                    <hr>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php endfor; ?>
                                                </tr>
                                            <?php endfor; ?>
                                            <tr>
                                                <td colspan="9" class="text-center">晚饭</td>
                                            </tr>
                                            <?php for ($i = 10; $i <= 12; ++$i): ?>
                                                <tr>
                                                    <?php if (10 == $i): ?>
                                                        <th rowspan="3" class="active text-center" style="vertical-align:middle">晚上</th>
                                                    <?php endif; ?>
                                                    <th class="active">第<?php echo $i ?>节</th>
                                                    <?php for ($j = 1; $j <= 7; ++$j): ?>
                                                        <td>
                                                            <?php if (is_array($courses[$i][$j])): ?>
                                                                <?php foreach ($courses[$i][$j] as $course): ?>
                                                                    <?php echo $course['kcmc'] ?><br>
                                                                    <?php echo $course['xqh'] ?>校区<?php echo $course['jsmc'] ?>教室<br>
                                                                    <?php echo $course['jsxm'] ?><br>
                                                                    第 <?php echo $course['ksz'] ?>~<?php echo $course['jsz'] ?> 周
                                                                    <hr>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php endfor; ?>
                                                </tr>
                                            <?php endfor; ?>
                                            <!--tr>
                                                <th rowspan="5" class="active text-center" style="vertical-align:middle">上午</th>
                                                <th class="active">第1节</th>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th class="active">第2节</th>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th class="active">第3节</th>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th class="active">第4节</th>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th class="active">第5节</th>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="9" class="text-center">午休</td>
                                            </tr>
                                            <tr>
                                                <th rowspan="3" class="active text-center" style="vertical-align:middle">下午</th>
                                                <th class="active">第6节</th>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th class="active">第7节</th>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th class="active">第8节</th>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="9" class="text-center">晚饭</td>
                                            </tr>
                                            <tr>
                                                <th rowspan="3" class="active text-center" style="vertical-align:middle">晚上</th>
                                                <th class="active">第10节</th>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th class="active">第11节</th>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <th class="active">第12节</th>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr-->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php section('footer') ?>
