<?php section('header') ?>
<?php section('navigation') ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo Session::read('name') ?>同学<?php echo Session::read('year') ?>年度<?php echo Dictionary::get('xq', Session::read('term')) ?>学期选课表</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div role="tabpanel">
                                    <ul id="campus-tab" class="nav nav-tabs" role="tablist">
                                        <li role="presentation"><a href="#xq1" aria-controls="#xq1" role="tab" data-toggle="tab">雁山</a></li>
                                        <li role="presentation"><a href="#xq2" aria-controls="#xq2" role="tab" data-toggle="tab">育才</a></li>
                                        <li role="presentation"><a href="#xq3" aria-controls="#xq3" role="tab" data-toggle="tab">王城</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="xq1" class="tab-pane fade in active" role="tabpanel">                                            
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="active">操作</th>
                                                            <th class="active">课程序号</th>
                                                            <th class="active">课程名称</th>
                                                            <th class="active">学分</th>
                                                            <th class="active">考核方式</th>
                                                            <th class="active">上课时间</th>
                                                            <th class="active">上课周数</th>
                                                            <th class="active">所在校区</th>
                                                            <th class="active">主要任课老师</th>
                                                            <th class="active">上课人数</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($courses as $course): ?>
                                                        <tr>
                                                            <td><input type="checkbox"></td>
                                                            <td><?php echo $course['kcxh'] ?></td>
                                                            <td><?php echo $course['kcmc'] ?></td>
                                                            <td><?php echo $course['xf'] ?></td>
                                                            <td><?php echo $course['kh'] ?></td>
                                                            <td>第 <?php echo $course['ksz'] ?>~<?php echo $course['jsz'] ?> 周<?php echo weekend($course['zc']) ?>
                                                                第 <?php echo $course['ksj'] ?>
                                                                <?php echo $course['jsj'] <= $course['ksj'] ? '' : '~' . $course['jsj'] ?> 节</td>
                                                            <td><?php echo $course['jsz'] - $course['ksz'] + 1 ?></td>
                                                            <td><?php echo Dictionary::get('xqh', $course['xqh']) ?></td>
                                                            <td><?php echo $course['jsxm'] ?></td>
                                                            <td><?php echo $course['rs'] ?></td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div id="xq2" class="tab-pane fade" role="tabpanel"></div>
                                        <div id="xq3" class="tab-pane fade" role="tabpanel"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php section('footer') ?>