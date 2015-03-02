                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">上传照片</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <form action="<?php echo toLink('student.uploade') ?>" method="post" enctype="multipart/form-data" role="form" class"form-control">
                                        <div class="form-group">
                                            <label for="portrait">上传照片:</label>
                                            <input type="file" name="portrait" id="portrait" class="form-control">&nbsp;&nbsp;
                                            <input type="submit" name="submit" value="提交">
                                        </form>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
