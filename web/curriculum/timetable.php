                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['name']?>老师课程表</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div id="accordion" class="panel-group">
                            <?php foreach ($courses as $key => $course): ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <a href="#<?php echo $key?>" data-toggle="collapse" data-parent="#accordion">
                                                <?php $courseTime = parseTerm($key)?>
                                                <?php echo $courseTime['year']?>年度<?php echo Dictionary::get('xq', $courseTime['term'])?>学期
                                            </a>
                                        </div>
                                    </div>

                                    <div id="<?php echo $key?>" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="active">节次</th>
                                                            <th class="active">星期一</th>
                                                            <th class="active">星期二</th>
                                                            <th class="active">星期三</th>
                                                            <th class="active">星期四</th>
                                                            <th class="active">星期五</th>
                                                            <th class="active">星期六</th>
                                                            <th class="active">星期日</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php for ($i = 1; $i <= 5; ++$i): ?>
                                                            <tr>
                                                                <?php if (1 == $i): ?>
                                                                    <th rowspan="5" class="active text-center" style="vertical-align:middle">上午</th>
                                                                <?php endif;?>
                                                                <th class="active">第<?php echo $i?>节</th>
                                                                <?php for ($j = 1; $j <= 7; ++$j): ?>
                                                                    <?php if (is_array($course[$i][$j])): ?>
                                                                        <td<?php echo 1 < ($course[$i][$j][0]['jsj'] - $i + 1) ? ' rowspan="' . ($course[$i][$j][0]['jsj'] - $i + 1) . '"' : ''?>>
                                                                            <?php foreach ($course[$i][$j] as $item): ?>
                                                                                <?php echo $item['kcxh']?><br>
                                                                                <?php echo $item['kcmc']?><br>
                                                                                <?php echo $item['xqh']?>校区<?php echo $item['jsmc']?>教室<br>
                                                                                第 <?php echo $item['ksz']?>~<?php echo $item['jsz']?> 周
                                                                                <hr>
                                                                            <?php endforeach;?>
                                                                        </td>
                                                                    <?php elseif (!is_null($course[$i][$j])): ?>
                                                                        <td><?php echo $course[$i][$j]?></td>
                                                                    <?php endif;?>
                                                                <?php endfor;?>
                                                            </tr>
                                                        <?php endfor;?>
                                                        <tr>
                                                            <td colspan="9" class="text-center">午休</td>
                                                        </tr>
                                                        <?php for ($i = 6; $i <= 9; ++$i): ?>
                                                            <tr>
                                                                <?php if (6 == $i): ?>
                                                                    <th rowspan="4" class="active text-center" style="vertical-align:middle">下午</th>
                                                                <?php endif;?>
                                                                <th class="active">第<?php echo $i?>节</th>
                                                                <?php for ($j = 1; $j <= 7; ++$j): ?>
                                                                    <?php if (is_array($course[$i][$j])): ?>
                                                                        <td<?php echo 1 < ($course[$i][$j][0]['jsj'] - $i + 1) ? ' rowspan="' . ($course[$i][$j][0]['jsj'] - $i + 1) . '"' : ''?>>
                                                                            <?php foreach ($course[$i][$j] as $item): ?>
                                                                                <?php echo $item['kcxh']?><br>
                                                                                <?php echo $item['kcmc']?><br>
                                                                                <?php echo $item['xqh']?>校区<?php echo $item['jsmc']?>教室<br>
                                                                                第 <?php echo $item['ksz']?>~<?php echo $item['jsz']?> 周
                                                                                <hr>
                                                                            <?php endforeach;?>
                                                                        </td>
                                                                    <?php elseif (!is_null($course[$i][$j])): ?>
                                                                        <td><?php echo $course[$i][$j]?></td>
                                                                    <?php endif;?>
                                                                <?php endfor;?>
                                                            </tr>
                                                        <?php endfor;?>
                                                        <tr>
                                                            <td colspan="9" class="text-center">晚饭</td>
                                                        </tr>
                                                        <?php for ($i = 10; $i <= 12; ++$i): ?>
                                                            <tr>
                                                                <?php if (10 == $i): ?>
                                                                    <th rowspan="3" class="active text-center" style="vertical-align:middle">晚上</th>
                                                                <?php endif;?>
                                                                <th class="active">第<?php echo $i?>节</th>
                                                                <?php for ($j = 1; $j <= 7; ++$j): ?>
                                                                    <?php if (is_array($course[$i][$j])): ?>
                                                                        <td<?php echo 1 < ($course[$i][$j][0]['jsj'] - $i + 1) ? ' rowspan="' . ($course[$i][$j][0]['jsj'] - $i + 1) . '"' : ''?>>
                                                                            <?php foreach ($course[$i][$j] as $item): ?>
                                                                                <?php echo $item['kcxh']?><br>
                                                                                <?php echo $item['kcmc']?><br>
                                                                                <?php echo $item['xqh']?>校区<?php echo $item['jsmc']?>教室<br>
                                                                                第 <?php echo $item['ksz']?>~<?php echo $item['jsz']?> 周
                                                                                <hr>
                                                                            <?php endforeach;?>
                                                                        </td>
                                                                    <?php elseif (!is_null($course[$i][$j])): ?>
                                                                        <td><?php echo $course[$i][$j]?></td>
                                                                    <?php endif;?>
                                                                <?php endfor;?>
                                                            </tr>
                                                        <?php endfor;?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </section>
