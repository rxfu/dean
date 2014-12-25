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
                                        </thead><?php var_dump(Session::read('year')); ?>
                                        <tbody>
                                            <?php foreach ($courses as $course): ?>
                                            <tr>
                                                <td><input type="checkbox"></td>
                                                <td><?php echo $course['kcxh'] ?></td>
                                                <td><?php echo $course['kcmc'] ?></td>
                                                <td><?php echo $course['xf'] ?></td>
                                                <td><?php echo $course['kh'] ?></td>
                                                <td>
                                                    <?php 
                                                    foreach ($course['sksj'] as $time) {
                                                        echo $time['sksj'] . '<br />';
                                                    } 
                                                    ?>
                                                </td>
                                                <td><?php echo $course['jsz'] - $course['ksz'] ?></td>
                                                <td><?php echo $course['xqh'] ?></td>
                                                <td><?php echo $course['jsxm'] ?></td>
                                                <td><?php echo $course['rs'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php section('footer') ?>