                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $year ?>~<?php echo $year + 1 ?>学年度<?php echo Dictionary::get('xq', $term) ?>学期评教结果列表</h1>
                    </div>
                </section>

                <section class="row">
                    <?php foreach ($courses as $course): ?>
                        <div class="col-md-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div><?php echo $course['kch'] ?></div>
                                            <div class="huge"><?php echo $course['kcmc'] ?></div>
                                        </div>
                                    </div>
                                </div>

                                <a href="<?php echo Route::to('assess.result', $year, $term, $course['kch']) ?>">
                                    <div class="panel-footer">
                                        <span class="pull-left">查询评教结果</span>
                                        <span class="pull-right">
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </section>
