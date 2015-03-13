                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $session['name'] ?>同学国家考试成绩单
                        </h1>
                    </div>
                </section>

                <?php if (isEmpty($scores)): ?>
                    <section class="row">
                        <div class="col-lg-12">
                            <div class="well">现在无国家考试成绩</div>
                        </div>
                    </section>
                <?php else: ?>
                    <?php foreach ($scores as $score): ?>
                        <section class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><?php echo $score[0]['ksmc'] ?></div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="active">考试时间</th>
                                                        <th class="active">考试名称</th>
                                                        <th class="active">考试成绩</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($score as $item): ?>
                                                        <tr>
                                                            <td><?php echo $item['c_kssj'] ?></td>
                                                            <td><?php echo $item['ksmc'] ?></td>
                                                            <td><?php echo $item['c_cj'] ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    <?php endforeach; ?>
                <?php endif; ?>
