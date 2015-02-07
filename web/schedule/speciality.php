<?php section('header') ?>
                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo Session::read('name') ?>同学<?php echo Session::read('year') ?>年度<?php echo Dictionary::get('xq', Session::read('term')) ?>学期专业课程表</h1>
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
                                                <th class="active">课程号</th>
                                                <th class="active">课程名称</th>
                                                <th class="active">课程英文名称</th>
                                                <th class="active">课程平台</th>
                                                <th class="active">课程性质</th>
                                                <th class="active">学时</th>
                                                <th class="active">学分</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($courses as $course): ?>
                                            <tr>
                                                <td><?php echo $course['kch'] ?></td>
                                                <td><?php echo $course['kcmc'] ?></td>
                                                <td><?php echo $course['kcywmc'] ?></td>
                                                <td><?php echo $course['pt'] ?></td>
                                                <td><?php echo $course['xz'] ?></td>
                                                <td><?php echo $course['xs'] ?></td>
                                                <td><?php echo $course['xf'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
<?php section('footer') ?>
