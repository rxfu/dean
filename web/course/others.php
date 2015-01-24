<?php section('header') ?>
<?php section('student.navigation') ?>
            <?php if (isset($grades) && !isEmpty($grades)): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo Session::read('year') ?>年度<?php echo Dictionary::get('xq', Session::read('term')) ?>学期非本年级本专业课程检索</h1>
                        <div class="alert alert-danger" role="alert">请输入课程序号或课程中文名称进行检索并申请修读</div>
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
            <?php endif; ?>

            <?php if (isset($majors) && !isEmpty($majors)): ?>
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
        <?php endif; ?>
<?php section('footer') ?>
