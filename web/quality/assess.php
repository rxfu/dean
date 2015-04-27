                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['name'] ?>同学<?php echo $session['year'] ?>年度<?php echo Dictionary::get('xq', $session['term']) ?>学期<?php echo $course['kcmc'] ?>课堂教学质量评估表</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading clearfix">
                                <div class="panel-title">授课教师：<?php echo $course['jsxm'] ?></div>
                            </div>
                            <div class="panel-body">
                                <form id="assessForm" name="assessForm" action="<?php echo Route::to('quality.assess', $course['kcxh']) ?>" role="form" method="post" class="form-horizontal">
                                    <fieldset>
                                        <?php foreach ($indexes as $index): ?>
                                            <div class="form-group">
                                                <label for="score<?php echo $index['zb_id'] ?><?php echo $index['ejzb_id'] ?>" class="col-md-3 control-label"><?php echo $index['zb_mc'] ?>-<?php echo $index['ejzb_mc'] ?></label>
                                                <div class="col-md-9">
                                                    <label class="radio-inline">
                                                        <?php foreach ($ranks as $rank): ?>
                                                            <input type="radio" name="score<?php echo $index['zb_id'] ?><?php echo $index['ejzb_id'] ?>" id="score<?php echo $index['zb_id'] ?><?php echo $index['ejzb_id'] ?><?php echo $rank['rank_id'] ?>" value="<?php echo $rank['rank_id'] ?>" class="form-control"><?php echo $rank['rank_mc'] ?>
                                                        <?php endforeach; ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        <div class="form-group">
                                            <label for="advantage" class="col-md-3 control-label">优点</label>
                                            <div class="col-md-9">
                                                <textarea name="advantage" cols="50" rows="5" class="form-control" placeholder="优点" required></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="shortcoming" class="col-md-3 control-label">缺点</label>
                                            <div class="col-md-9">
                                                <textarea name="shortcoming" cols="50" rows="5" class="form-control" placeholder="缺点" required></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="word" class="col-md-3 control-label">在教学方面，你最想对该门任课教师说的一句话</label>
                                            <div class="col-md-9">
                                                <textarea name="word" cols="50" rows="5" class="form-control" placeholder="在教学方面，你最想对该门任课教师说的一句话" required></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-lg btn-success btn-block">确认提交</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
