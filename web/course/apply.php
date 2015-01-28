<?php section('header') ?>
<?php section('student.navigation') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo Session::read('name') ?>同学<?php echo Session::read('year') ?>年度<?php echo Dictionary::get('xq', Session::read('term')) ?>学期<?php echo $title ?>课程申请表</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form action="<?php echo toLink('course.apply', $type) ?>" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="cno" class="col-md-2">课程序号</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control disabled" id="cno" name="cno" placeholde="课程序号">
                                        </div>
                                    </div>
                                    <?php if (RETAKE == $type): ?>
                                        <div class="form-group">
                                            <label for="lyear" class="col-md-2">原年度</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="lyear" name="lyear" placeholder="原年度">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="lterm" class="col-md-2">原学期</label>
                                            <div class="col-md-6">
                                                <select name="lterm" id="lterm" class="form-control">
                                                    <?php $terms = Dictionary::getAll('xq'); ?>
                                                    <?php foreach ($terms as $term): ?>
                                                        <option value="<?php echo $term['dm'] ?>"><?php echo $term['mc'] ?>学期</option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="lcno" class="col-md-2">原课程序号</label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="lcno" name="lcno" placeholder="原课程序号">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-2">
                                            <button type="submit" class="btn btn-primary">提交申请</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php section('footer') ?>
