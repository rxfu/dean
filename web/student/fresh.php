                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">新生信息填写</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="panel-title">为完善个人学籍信息，尽快办妥学生证，请新生务必完善以下信息：</div>
                            </div>
                            <div class="panel-body">
                                <form id="freshForm" name="freshForm" action="<?php echo Route::to('student.fresh')?>" role="form" method="post" class="form-horizontal">
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="hometown" class="col-md-3 control-label">籍贯</label>
                                            <div class="col-md-9">
                                                <input type="text" name="hometown" id="hometown" placeholder="籍贯" class="form-control"<?php echo isset($info['jg']) ? ' value="' . $info['jg'] . '"' : ''?> autofocus required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address" class="col-md-3 control-label">家庭地址（20字以内）</label>
                                            <div class="col-md-9">
                                                <input type="text" name="address" id="address" placeholder="家庭地址" class="form-control"<?php echo isset($info['jtdz']) ? ' value="' . $info['jtdz'] . '"' : ''?> required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="train" class="col-md-3 control-label">火车到站</label>
                                            <div class="col-md-9">
                                                <input type="text" name="train" id="train" placeholder="火车到站" class="form-control"<?php echo isset($info['hcdz']) ? ' value="' . $info['hcdz'] . '"' : ''?> required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3 col-md-offset-3">
                                                <button type="submit" class="btn btn-lg btn-success btn-block">提交</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>

                                <div class="well">
                                    填写要求：
                                    <ol>
                                        <li>籍贯：填写所在省市（县），如“河南省洛阳市”写“河南洛阳”即可；</li>
                                        <li>家庭地址：填写监护人（如父母）能收到信的通讯地址，家庭地址在县以及县以下的不用写所属的地级市名称，注意省份不能用“湘”“桂”等简称。如“广西壮族自治区桂林市龙胜各族自治县江底乡江底村江底屯15组16号”写“广西龙胜县江底乡江底村江底屯15组16号”即可；</li>
                                        <li>火车到站：填写父母户口所在地站名。如户口所在地是“广西柳州市鱼峰区白云三村”对应填写的火车到站为“柳州”；如需中转，只需填写最终到站即可。（站名必须规范填写，站点一旦写入火车优惠卡将无法更改）。</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
