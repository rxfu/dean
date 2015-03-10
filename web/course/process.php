                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['name'] ?>同学课程申请进度</h1>
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
                                                <th class="active">申请类型</th>
                                                <th class="active">审核意见</th>
                                                <th class="active">申请状态</th>
                                                <th class="active">申请时间</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($courses as $course): ?>
                                            <tr>
                                                <td><?php echo $course['nd'] ?></td>
                                                <td><?php echo Dictionary::get('xq', $course['xq']) ?></td>
                                                <td><?php echo $course['kcxh'] ?></td>
                                                <td><?php echo $course['ynd'] ?></td>
                                                <td><?php echo isEmpty($course['yxq']) ? $course['yxq'] : Dictionary::get('xq', $course['yxq']) ?></td>
                                                <td><?php echo $course['ykcxh'] ?></td>
                                                <td><?php switch ($course['xklx']) {
                                                    case 0:
                                                        echo '其他课程';
                                                        break;
                                                    case 1:
                                                        echo '重修';
                                                        break;
                                                    default:
                                                        echo '其他课程';
                                                        break;
                                                } ?></td>
                                                <td><?php echo $course['shyj'] ?></td>
                                                <td><?php switch ($course['sh']) {
                                                    case Config::get('apply.unauditted'):
                                                        echo '待审核';
                                                        break;
                                                    case Config::get('apply.passed'):
                                                        echo '审核已批准';
                                                        break;
                                                    case Config::get('apply.refused'):
                                                        echo '审核未批准';
                                                        break;
                                                    default:
                                                        echo '待审核';
                                                        break;
                                                } ?></td>
                                                <td><?php echo $course['xksj'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
