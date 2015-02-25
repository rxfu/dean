                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo Session::get('name') ?>同学<?php echo Session::get('year') ?>年度<?php echo Dictionary::get('xq', Session::get('term')) ?>学期课程申请进程</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th class="active">年度</th>
                                                <th class="active">学期</th>
                                                <th class="active">课程序号</th>
                                                <th class="active">原年度</th>
                                                <th class="active">原学期</th>
                                                <th class="active">原课程序号</th>
                                                <th class="active">审核意见</th>
                                                <th class="active">申请状态</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($courses as $course): ?>
                                            <tr>
                                                <td><?php echo $course['nd'] ?></td>
                                                <td><?php echo $course['xq'] ?></td>
                                                <td><?php echo $course['kcxh'] ?></td>
                                                <td><?php echo $course['ynd'] ?></td>
                                                <td><?php echo $course['yxq'] ?></td>
                                                <td><?php echo $course['ykcxh'] ?></td>
                                                <td><?php echo $course['shyj'] ?></td>
                                                <td><?php switch ($course['sh']) {
                                                    case UNAUDITTED:
                                                        echo '待审核';
                                                        break;
                                                    case PASSED:
                                                        echo '审核已批准';
                                                        break;
                                                    case REFUSED:
                                                        echo '审核未批准';
                                                        break;
                                                    default:
                                                        echo '待审核';
                                                        break;
                                                } ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
