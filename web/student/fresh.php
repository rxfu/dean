                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">新生信息核对</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form id="freshForm" name="freshForm" action="<?php echo Route::to('student.fresh') ?>" role="form" method="post" class="form-horizontal">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="train" class="col-md-3 control-label">火车到站</label>
                                            <div class="col-md-9">
                                                <input type="text" name="train" id="train" placeholder="火车到站" class="form-control" autofocus required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="col-md-3 control-label">家庭地址</label>
                                            <div class="col-md-9">
                                                <input type="text" name="address" id="address" placeholder="家庭地址" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-lg btn-success btn-block">提交</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
