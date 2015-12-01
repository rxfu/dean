                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $info['kkxy'] ?><?php echo $info['nj'] ?>级<?php echo $info['zy'] ?>专业<?php echo $session['year'] ?>年度<?php echo Dictionary::get('xq', $session['term']) ?>学期<?php echo $info['kcxh'] ?><?php echo $info['kcmc'] ?>课程成绩单</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">成绩方式：<?php echo $ratios['name'] ?></div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover data-table">
                                        <thead>
                                            <tr>
                                                <th class="active">学号</th>
                                                <th class="active">姓名</th>
                                                <?php foreach ($ratios['mode'] as $ratio): ?>
                                                    <th class="active"><?php echo $ratio['idm'] ?></th>
                                                <?php endforeach; ?>
                                                <th class="active">总评成绩</th>
                                                <th class="active">考核方式</th>
                                                <th class="active">状态</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($scores as $score): ?>
                                            <tr>
                                                <td><?php echo $score['xh'] ?></td>
                                                <td><?php echo $score['xm'] ?></td>
                                                <?php foreach (array_keys($ratios['mode']) as $key): ?>
                                                    <td><?php echo $score['cj' . $key] ?></td>
                                                <?php endforeach; ?>
                                                <td><?php echo $score['zpcj'] ?></td>
                                                <td><?php echo $score['kh'] ?></td>
                                                <td><?php echo $score['kszt'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
