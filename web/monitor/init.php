                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">系统初始化</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <form id="deleteForm" name="deleteForm" action="<?php echo Route::to('monitor.drop') ?>" role="form" method="post">
                                        <button type="submit" class="btn btn-lg btn-danger btn-block">删除</button>
                                    </form>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="initForm" name="initForm" action="<?php echo Route::to('monitor.init') ?>" role="form" method="post" class="form-horizontal">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="year" class="col-md-3 control-label">年度</label>
                                            <div class="col-md-9">
                                                <input type="text" name="year" id="year" placeholder="年度" class="form-control" value="<?php echo $year; ?>" autofocus required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="term" class="col-md-3 control-label">学期</label>
                                            <div class="col-md-9">
                                                <select name="term" id="term">
                                                    <?php foreach (Dictionary::getAll('xq') as $item): ?>
                                                        <option value="<?php echo $item['dm'] ?>"<?php echo $item['dm'] == $term ? ' selected' : '' ?>><?php echo $item['mc'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-lg btn-success btn-block">确认</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
