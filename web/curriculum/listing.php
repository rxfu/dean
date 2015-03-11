                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['name'] ?>老师课程列表</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div id="accordion" class="panel-group">
                            <?php foreach ($courses as $key => $course): ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <a href="#<?php echo $key ?>" data-toggle="collapse" data-parent="#accordion">
                                                <?php $courseTime = parseTerm($key) ?>
                                                <?php echo $courseTime['year'] ?>年度<?php echo Dictionary::get('xq', $courseTime['term']) ?>学期
                                            </a>
                                        </div>
                                    </div>

                                    <div id="<?php echo $key ?>" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="active">课程代码</th>
                                                            <th class="active">课程名称</th>
                                                            <th class="active">课程英文名称</th>
                                                            <th class="active">学时</th>
                                                            <th class="active">所在校区</th>
                                                            <th class="active">上课时间</th>
                                                            <th class="active">上课教室</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($course as $item): ?>
                                                            <tr>
                                                                <?php $rowspan = count($item) ?>
                                                                <td rowspan="<?php echo $rowspan ?>"><?php echo $item[0]['kcxh'] ?></td>
                                                                <td rowspan="<?php echo $rowspan ?>"><?php echo $item[0]['kcmc'] ?></td>
                                                                <td rowspan="<?php echo $rowspan ?>"><?php echo $item[0]['kcywmc'] ?></td>
                                                                <td rowspan="<?php echo $rowspan ?>"><?php echo $item[0]['xs'] ?></td>
                                                                <td rowspan="<?php echo $rowspan ?>"><?php echo $item[0]['xqh'] ?></td>
                                                                <td>第 <?php echo $item[0]['ksz'] ?>~<?php echo $item[0]['jsz'] ?> 周<?php echo weekend($item[0]['zc']) ?>
                                                                                第 <?php echo $item[0]['ksj'] ?>
                                                                                <?php echo $item[0]['jsj'] <= $item[0]['ksj'] ? '' : '~' . $item[0]['jsj'] ?> 节</td>
                                                                <td><?php echo $item[0]['jsmc'] ?>教室</td>
                                                            </tr>                                            
                                                            <?php for($i = 1; $i < $rowspan; ++$i): ?>
                                                                <tr>
                                                                    <?php for($j = 0; $j < 5; ++$j): ?>
                                                                        <td style="display: none"></td>
                                                                    <?php endfor; ?>
                                                                    <td>第 <?php echo $item[$i]['ksz'] ?>~<?php echo $item[$i]['jsz'] ?> 周<?php echo weekend($item[$i]['zc']) ?>
                                                                                    第 <?php echo $item[$i]['ksj'] ?>
                                                                                    <?php echo $item[$i]['jsj'] <= $item[$i]['ksj'] ? '' : '~' . $item[$i]['jsj'] ?> 节</td>
                                                                    <td><?php echo $item[$i]['jsmc'] ?>教室</td>
                                                                </tr>
                                                            <?php endfor; ?>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
