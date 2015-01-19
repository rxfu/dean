<?php section('header') ?>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-md-9 text-right">
                                <div class="huge">26</div>
                            </div>
                        </div>
                    </div>

                    <a href="<?php echo toLink('student.login') ?>">
                        <div class="panel-footer">
                            <span class="pull-left">学生入口</span>
                            <span class="pull-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-3">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-md-9 text-right">
                                <div class="huge">26</div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="<?php echo toLink('teacher.login') ?>">
                        <div class="panel-footer">
                            <span class="pull-left">教师入口</span>
                            <span class="pull-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
<?php section('footer') ?>