                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">上传照片</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form action="<?php echo Route::to('student.upload') ?>" method="post" enctype="multipart/form-data" role="form" class"form-inline">
                                    <div class="form-group">
                                        <label for="portrait">上传照片:</label>
                                        <input type="file" name="portrait" id="portrait" class="form-control">
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary">上传</button>
                                    </form>
                                </form>
                                <p class="help-block">
                                    <strong>上传说明：</strong>请各位同学上传本人蓝底证件照，高宽比为4:3，大小不得超过2MB。
                                </p>
                                <div>
                                    <img src="<?php echo Route::to('student.portrait') ?>" alt="<?php echo $session['name'] ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
