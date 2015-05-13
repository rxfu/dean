                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['name'] ?>同学<?php echo $session['year'] ?>年度<?php echo Dictionary::get('xq', $session['term']) ?>学期课程转换申请表</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form method="post" action="<?php echo Route::to('report.transfer') ?>" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="lcno" class="col-md-2">原课程号</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="lcno" name="lcno">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lcname" class="col-md-2">原课程名称</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="lcname" name="lcname">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lplatform" class="col-md-2">原课程平台</label>
                                        <div class="col-md-4">
                                            <select name="lplatform" id="lplatform" class="form-control">
                                                <?php foreach (Dictionary::getAll('pt') as $platform): ?>
                                                    <?php if (!isEmpty($platform['dm'])): ?>
                                                    <option value="<?php echo $platform['dm'] ?>"><?php echo $platform['mc'] ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lproperty" class="col-md-2">原课程性质</label>
                                        <div class="col-md-4">
                                            <select name="lproperty" id="lproperty" class="form-control">
                                                <?php foreach (Dictionary::getAll('xz') as $property): ?>
                                                    <?php if (!isEmpty($property['dm'])): ?>
                                                    <option value="<?php echo $property['dm'] ?>"><?php echo $property['mc'] ?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if (!isEmpty($electives)): ?>
                                    <div class="form-group">
                                        <label for="lelective" class="col-md-2">原选修系列</label>
                                        <div class="col-md-4">
                                            <select name="lelective" id="lelective" class="form-control">
                                                <?php foreach ($electives as $elective): ?>
                                                    <option value="<?php echo $elective['dm'] ?>"><?php echo $elective['mc'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <label for="method" class="col-md-2">考核方式</label>
                                        <div class="col-md-4">
                                            <select name="method" id="method" class="form-control">
                                                <?php foreach (Dictionary::getAll('khfs') as $method): ?>
                                                    <option value="<?php echo $method['dm'] ?>"><?php echo $method['mc'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lcredit" class="col-md-2">原学分</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="lcredit" name="lcredit">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lscore" class="col-md-2">原成绩</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="lscore" name="lscore">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lgpa" class="col-md-2">原绩点</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="lgpa" name="lgpa">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="status" class="col-md-2">考试状态</label>
                                        <div class="col-md-4">
                                            <select name="status" id="status" class="form-control">
                                                <?php foreach ($statuses as $status): ?>
                                                    <option value="<?php echo $status['mc'] ?>"><?php echo $status['mc'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cno" class="col-md-2">新课程号</label>
                                        <div class="col-md-4">
                                            <select name="cno" id="cno" class="form-control">
                                                <?php foreach ($courses as $course): ?>
                                                    <option value="<?php echo $course['kch'] ?>"><?php echo $course['kch'] ?>(<?php echo $course['zxf'] ?>)</option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="reason" class="col-md-2">申请理由</label>
                                        <div class="col-md-4">
                                            <select name="reason" id="reason" class="form-control">
                                                <option value="出国留学" selectd>出国留学</option>
                                                <option value="教学计划异动">教学计划异动</option>
                                                <option value="跨专业选课">跨专业选课</option>
                                                <option value="其他">其他</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-2">
                                            <button type="submit" class="btn btn-primary">提交申请</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
