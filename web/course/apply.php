                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['name'] ?>同学<?php echo $session['year'] ?>年度<?php echo Dictionary::get('xq', $session['term']) ?>学期<?php echo $title ?>申请表</h1>
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
                                                <input type="text" name="lyear-name" id="lyear-name" class="form-control" value="<?php echo $lcnos[0]['nd'] ?>年度" disabled>
                                                <input type="hidden" name="lyear" id="lyear" value="<?php echo $lcnos[0]['nd'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="lterm" class="col-md-2">原学期</label>
                                            <div class="col-md-4">
                                                <input type="text" name="lterm-name" id="lterm-name" class="form-control" value="<?php echo Dictionary::get('xq', $lcnos[0]['xq']) ?>学期" disabled>
                                                <input type="hidden" name="lterm" id="lterm" value="<?php echo $lcnos[0]['xq'] ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="lcno" class="col-md-2">原课程</label>
                                            <div class="col-md-4">
                                                <select name="lcno" id="lcno" class="form-control">
                                                    <?php foreach ($lcnos as $lcno): ?>
                                                        <option data-year="<?php echo $lcno['nd'] ?>" data-year-name="<?php echo $lcno['nd'] ?>年度" data-term="<?php echo $lcno['xq'] ?>" data-term-name="<?php echo Dictionary::get('xq', $lcno['xq']) ?>学期" value="<?php echo $lcno['kcxh'] ?>"><?php echo $lcno['kcxh'] ?>-<?php echo $lcno['kcmc'] ?>-<?php echo $lcno['xf'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" name="lcredit" id="lcredit" value="<?php echo $lcnos[0]['xf'] ?>">
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
