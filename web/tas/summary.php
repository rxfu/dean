                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $year ?>年度<?php echo Dictionary::get('xq', $term) ?>学期评学结果列表</h1>
                    </div>
                </section>

                <section class="row">
                    <?php foreach ($results as $result): ?>
                        <div class="col-md-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div><?php echo $result['kcxh'] ?></div>
                                            <div class="huge"><?php echo $result['kcmc'] ?></div>
                                        </div>
                                    </div>
                                </div>

                                <a href="<?php echo Route::to('tas.result', $year, $term, $result['kcxh']) ?>">
                                    <div class="panel-footer">
                                        <span class="pull-left">查询评学结果</span>
                                        <span class="pull-right">
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach;?>
                </section>
