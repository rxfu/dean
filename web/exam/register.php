                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['name'] ?>同学<?php echo $session['year'] ?>年度<?php echo Dictionary::get('xq', $session['term']) ?>学期<?php echo $exam['ksmc'] ?>考试报名表</h1>
                        <div class="alert alert-danger" role="alert">请认真核准自己的报名信息</div>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?php if (!$registered): ?>
                                            <form method="post" action="<?php echo Route::to('exam.register', $type) ?>" class="form-horizontal">
                                        <?php endif; ?>
                                            <div class="form-group">
                                                <label for="sno" class="col-md-4">学号</label>
                                                <div class="col-md-8"><?php echo $session['username'] ?></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="sno" class="col-md-4">姓名</label>
                                                <div class="col-md-8"><?php echo $session['name'] ?></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="sno" class="col-md-4">身份证号码</label>
                                                <div class="col-md-8"><?php echo $session['id'] ?></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="sno" class="col-md-4">考试时间</label>
                                                <div class="col-md-8"><?php echo $exam['sj'] ?></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="sno" class="col-md-4">报考类别</label>
                                                <div class="col-md-8"><?php echo $exam['ksmc'] ?></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="cno" class="col-md-4">所在校区</label>
                                                <div class="col-md-8">
                                                    <?php if ($registered): ?>
                                                        <?php echo $exam['xq'] ?>
                                                    <?php else: ?>
                                                        <select name="campus" id="campus" class="form-control">
                                                            <?php foreach ($campuses as $campusId => $campus): ?>
                                                                <option value="<?php echo $campusId ?>"<?php echo $campusId == $session['campus'] ? ' selected="selected"' : '' ?>><?php echo $campus ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php if (!$registered): ?>
                                                <div class="form-group">
                                                    <div class="col-md-8 col-md-offset-4">
                                                        <button type="submit" class="btn btn-primary">报名</button>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php if (!$registered): ?> 
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-4">
                                        <img src="<?php echo Route::to('student.portrait') ?>" alt="<?php echo $session['name'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
