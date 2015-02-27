                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $name ?>同学<?php echo $year ?>年度<?php echo Dictionary::get('xq', $term) ?>学期课程表</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="active">课程代码</th>
                                                <th class="active">课程名称</th>
                                                <th class="active">课程英文名称</th>
                                                <th class="active">学分</th>
                                                <th class="active">所在校区</th>
                                                <th class="active">上课时间</th>
                                                <th class="active">上课教室</th>
                                                <th class="active">任课老师</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($courses as $course): ?>
                                                <tr>
                                                    <?php $rowspan = count($course) ?>
                                                    <td rowspan="<?php echo $rowspan ?>"><?php echo $course[0]['kcxh'] ?></td>
                                                    <td rowspan="<?php echo $rowspan ?>"><?php echo $course[0]['kcmc'] ?></td>
                                                    <td rowspan="<?php echo $rowspan ?>"><?php echo $course[0]['kcywmc'] ?></td>
                                                    <td rowspan="<?php echo $rowspan ?>"><?php echo $course[0]['xf'] ?></td>
                                                    <td rowspan="<?php echo $rowspan ?>"><?php echo $course[0]['xqh'] ?></td>
                                                    <td>第 <?php echo $course[0]['ksz'] ?>~<?php echo $course[0]['jsz'] ?> 周<?php echo weekend($course[0]['zc']) ?>
                                                                    第 <?php echo $course[0]['ksj'] ?>
                                                                    <?php echo $course[0]['jsj'] <= $course[0]['ksj'] ? '' : '~' . $course[0]['jsj'] ?> 节</td>
                                                    <td><?php echo $course[0]['jsmc'] ?></td>
                                                    <td><?php echo $course[0]['jsxm'] ?></td>
                                                </tr>                                            
                                                <?php for($i = 1; $i < $rowspan; ++$i): ?>
                                                    <tr>
                                                        <?php for($j = 0; $j < 5; ++$j): ?>
                                                            <td style="display: none"></td>
                                                        <?php endfor; ?>
                                                        <td>第 <?php echo $course[$i]['ksz'] ?>~<?php echo $course[$i]['jsz'] ?> 周<?php echo weekend($course[$i]['zc']) ?>
                                                                        第 <?php echo $course[$i]['ksj'] ?>
                                                                        <?php echo $course[$i]['jsj'] <= $course[$i]['ksj'] ? '' : '~' . $course[$i]['jsj'] ?> 节</td>
                                                        <td><?php echo $course[$i]['jsmc'] ?></td>
                                                        <td><?php echo $course[$i]['jsxm'] ?></td>
                                                    </tr>
                                                <?php endfor; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
