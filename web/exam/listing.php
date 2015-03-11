                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['name'] ?>同学考试报名信息</h1>
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
                                                <th class="active">报名时间</th>
                                                <th class="active">考试类型</th>
                                                <th class="active">所在校区</th>
                                                <th class="active">考试时间</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($exams as $exam): ?>
                                            <tr>
                                                <td><?php echo $exam['bmsj'] ?></td>
                                                <td><?php echo $exam['ksmc'] ?></td>
                                                <td><?php echo Dictionary::get('xqh', $exam['xq']) ?></td>
                                                <td><?php echo $exam['kssj'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
