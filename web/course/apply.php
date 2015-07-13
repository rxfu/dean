                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['name'] ?>同学<?php echo $session['year'] ?>年度<?php echo Dictionary::get('xq', $session['term']) ?>学期<?php echo $title ?>课程申请表</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form method="post" action="<?php echo Route::to('course.apply', $type, $cno) ?>" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="cno" class="col-md-2">课程序号</label>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" id="cno" name="cno" value="<?php echo $cno ?>" disabled>
                                        </div>
                                    </div>
                                    <?php if ('retake' == $type): ?>
                                        <div class="form-group">
                                            <label for="lyear" class="col-md-2">原年度</label>
                                            <div class="col-md-4">
                                                <select name="lyear" id="lyear" class="form-control">
                                                    <?php foreach ($lyears as $lyear): ?>
                                                        <option value="<?php echo $lyear['nd'] ?>"><?php echo $lyear['nd'] ?> 年度</option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="lterm" class="col-md-2">原学期</label>
                                            <div class="col-md-4">
                                                <select name="lterm" id="lterm" class="form-control">
                                                    <?php foreach ($lterms as $lterm): ?>
                                                        <option value="<?php echo $lterm['dm'] ?>"><?php echo $lterm['mc'] ?>学期</option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="lcno" class="col-md-2">原课程序号</label>
                                            <div class="col-md-4">
                                                <select name="lcno" id="lcno" class="form-control">
                                                    <?php foreach ($lcnos as $lcno): ?>
                                                        <option value="<?php echo $lcno['kcxh'] ?>"><?php echo $lcno['nd'] ?>年度-<?php echo Dictionary::get('xq', $lcno['xq']) ?>学期-<?php echo $lcno['kcxh'] ?>-<?php echo $lcno['kcmc'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
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
                </section>
