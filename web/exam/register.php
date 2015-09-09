                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['name']?>同学<?php echo $session['year']?>年度<?php echo Dictionary::get('xq', $session['term'])?>学期<?php echo $exam['ksmc']?>考试报名表</h1>
                        <div class="alert alert-danger" role="alert">请认真核准自己的报名信息</div>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <label for="sno" class="col-md-4">学号</label>
                                                <div class="col-md-8"><?php echo $session['username']?></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="sno" class="col-md-4">姓名</label>
                                                <div class="col-md-8"><?php echo $session['name']?></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="sno" class="col-md-4">身份证号码</label>
                                                <div class="col-md-8"><?php echo $session['id']?></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="sno" class="col-md-4">考试时间</label>
                                                <div class="col-md-8"><?php echo $exam['sj']?></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="sno" class="col-md-4">报考类别</label>
                                                <div class="col-md-8"><?php echo $exam['ksmc']?></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="cno" class="col-md-4">所在校区</label>
                                                <div class="col-md-8"><?php echo Dictionary::get('xqh', $session['campus'])?></div>
                                            </div>
                                            <?php if ($registered): ?>
                                                <?php if (Config::get('exam.status.register') == $confirmed): ?>
                                                    <form method="post" action="<?php echo Route::to('exam.cancel')?>" class="form-horizontal">
                                                        <input type="hidden" name="type" id="type" value="<?php echo $exam['kslx']?>">
                                                        <div class="form-group">
                                                            <div class="col-md-8 col-md-offset-4">
                                                                <button type="submit" class="btn btn-primary">取消报名</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                <?php endif;?>
                                            <?php else: ?>
                                                <form method="post" action="<?php echo Route::to('exam.register', $exam['kslx'])?>" class="form-horizontal">
                                                    <input type="hidden" name="type" id="type" value="<?php echo $exam['kslx']?>">
                                                    <div class="form-group">
                                                        <div class="col-md-8 col-md-offset-4">
                                                            <button type="submit" class="btn btn-primary">报名</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <img src="<?php echo Route::to('student.portrait')?>" alt="<?php echo $session['name']?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <?php if (!$registered): ?>
                    <div class="modal fade" id="tipsModal" tabindex="-1" role="dialog" aria-labelledby="#tipsModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="tipsModalLabel">报名提示</h4>
                                </div>
                            <div class="modal-body">
                                <p>
                                    <?php if (!$uploaded || Config::get('user.portrait.none') == $status): ?>
                                        请上传图像要求为高320（像素）*宽240（像素）的<strong>蓝底免冠</strong>证件照，要求jpg格式，方能进行考试报名。若因照片不符合要求而引起的考生无法参加考试等情况，由考生自行负责。
                                    <?php elseif (Config::get('user.portrait.uploaded') == $status): ?>
                                        考生照片<strong>未审核</strong>，待审核通过后方能进行报名，审核将于半个工作日内完成。
                                    <?php elseif (Config::get('user.portrait.refused') == $status): ?>
                                        考生照片<strong>审核不合格</strong>，请上传图像要求为高320（像素）*宽240（像素）的<strong>蓝底免冠</strong>证件照，要求jpg格式，待审核通过后方能进行报名，审核将于半个工作日内完成。
                                    <?php elseif (Config::get('user.portrait.passed') == $status): ?>
                                        请核对考生个人信息无误并<strong>确认</strong>本人照片为符合要求的<strong>蓝底免冠</strong>证件照，方能进行考试报名。若因照片不符合要求而引起的考生无法参加考试等情况，由考生自行负责。
                                    <?php endif;?>
                                </p>
                            </div>
                            <div class="modal-footer">
                                <?php if ($uploaded && Config::get('user.portrait.passed') == $status): ?>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="cancel">确定</button>
                                <?php else: ?>
                                    <a href="<?php echo Route::to('student.upload')?>" role="button" class="btn btn-primary" id="confirm">确定</a>
                                <?php endif;?>
                            </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                <?php endif;?>
