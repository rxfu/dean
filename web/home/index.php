                <div class="row">
                    <div class="col-md-12">
                        <div class="front-logo">
                            <img src="<?php echo img('images/logo.png') ?>" alt="广西师范大学教务管理系统">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 col-md-offset-3">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-md-9 text-right">
                                        <div class="huge">学生入口</div>
                                    </div>
                                </div>
                            </div>

                            <a href="<?php echo Route::to('student.login') ?>">
                                <div class="panel-footer">
                                    <span class="pull-left">进入系统</span>
                                    <span class="pull-right">
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-md-9 text-right">
                                        <div class="huge">教师入口</div>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="<?php echo Route::to('teacher.login') ?>">
                                <div class="panel-footer">
                                    <span class="pull-left">进入系统</span>
                                    <span class="pull-right">
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-md-9 text-right">
                                        <div class="huge">评教入口</div>
                                    </div>
                                </div>
                            </div>
                            
                            <a href="<?php echo Route::to('manager.login') ?>">
                                <div class="panel-footer">
                                    <span class="pull-left">进入系统</span>
                                    <span class="pull-right">
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
