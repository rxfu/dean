<?php section('header') ?>
<?php section('student.navigation') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo Session::read('year') ?>年度<?php echo Dictionary::get('xq', Session::read('term')) ?>学期本专业其他年级课程</h1>
                    </div>
                </div>

                <div class="row">
                    <?php foreach ($grades as $grade): ?>
                        <div class="col-md-3">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="huge"><?php echo $grade['nj'] ?>级</div>
                                        </div>
                                    </div>
                                </div>

                                <a href="<?php echo toLink('course.index', 'ngs', $grade['nj']) ?>">
                                    <div class="panel-footer">
                                        <span class="pull-left">进入选课</span>
                                        <span class="pull-right">
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo Session::read('year') ?>年度<?php echo Dictionary::get('xq', Session::read('term')) ?>学期其他专业课程</h1>
                    </div>
                </div>

                <div class="row">
                    <?php foreach ($majors as $major): ?>
                        <div class="col-md-3">
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="huge"><?php echo $major['zy'] ?>专业</div>
                                        </div>
                                    </div>
                                </div>

                                <a href="<?php echo toLink('course.index', 'ngs', $major['zyh']) ?>">
                                    <div class="panel-footer">
                                        <span class="pull-left">进入选课</span>
                                        <span class="pull-right">
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
<?php section('footer') ?>
