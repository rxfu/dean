                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['name'] ?>同学<?php echo $session['year'] ?>年度<?php echo Dictionary::get('xq', $session['term']) ?>学期选课情况表</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="active text-center">课程平台</th>
                                                <th class="active text-center">课程性质</th>
                                                <th class="active text-center">应修学分</th>
                                                <th class="active text-center">已修学分</th>
                                                <th class="active text-center">正在修读学分</th>
                                                <th class="active text-center">本次选修学分</th>
                                                <th class="active text-center">操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($credits as $credit): ?>
                                                <tr>
                                                    <td><?php echo Dictionary::get('pt', $credit['platform']) ?></td>
                                                    <td><?php echo Dictionary::get('xz', $credit['property']) ?></td>
                                                    <td><?php echo isset($credit['requirement']) ? $credit['requirement'] : 0 ?></td>
                                                    <td><?php echo isset($credit['studied']) ? $credit['studied'] : 0 ?></td>
                                                    <td><?php echo isset($credit['selecting']) ? $credit['selecting'] : 0 ?></td>
                                                    <td><?php echo isset($credit['selected']) ? $credit['selected'] : 0 ?></td>
                                                    <td>
                                                        <a href="<?php echo Route::to('plan.detail', $credit['platform'], $credit['property']) ?>" class="btn btn-primary">详细列表</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
