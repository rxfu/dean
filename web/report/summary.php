<?php section('header') ?>
<?php section('teacher.navigation') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $year ?>年度<?php echo Dictionary::get('xq', $term) ?>学期成绩单列表</h1>
                    </div>
                </div>

                <div class="row">
                    <?php $i = 0; ?>
                    <?php foreach ($courses as $course): ?>
                        <?php if (0 == $i % 4): ?>
                        <div class="col-md-3">
                        <?php endif; ?>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div><?php echo $course['kch'] ?></div>
                                            <div class="huge"><?php echo $course['kcmc'] ?></div>
                                        </div>
                                    </div>
                                </div>

                                <a href="<?php echo toLink('report.score', $year, $term, $course['kch']) ?>">
                                    <div class="panel-footer">
                                        <span class="pull-left">查询成绩</span>
                                        <span class="pull-right">
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        <?php if (0 == $i % 4): ?>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
<?php section('footer') ?>
