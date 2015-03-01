                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $name ?>同学<?php echo $year ?>年度<?php echo Dictionary::get('xq', $term) ?>学期<?php echo $exam['mc'] ?>考试报名表</h1>
                        <div class="alert alert-danger" role="alert">请认真核准自己的报名信息</div>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form method="post" action="<?php echo toLink('course.register', $type) ?>" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="sno" class="col-md-2">学号</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static"><?php echo $profile['xh'] ?></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sno" class="col-md-2">姓名</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static"><?php echo $profile['xm'] ?></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sno" class="col-md-2">身份证号码</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static"><?php echo $profile['sfzh'] ?></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sno" class="col-md-2">考试时间</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static"><?php echo $exam['sj'] ?></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sno" class="col-md-2">报考类别</label>
                                        <div class="col-md-4">
                                            <p class="form-control-static"><?php echo $exam['mc'] ?></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cno" class="col-md-2">所在校区</label>
                                        <div class="col-md-4">
                                            <select name="campus" id="campus" class="form-control">
                                                <?php foreach ($campuses as $campus): ?>
                                                    <option value="<?php echo $campus['dm'] ?>"><?php echo $campus['mc'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-2">
                                            <button type="submit" class="btn btn-primary">报名</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
