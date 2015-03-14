                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">个人资料</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">基本资料</div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="active">学号</th>
                                            <td><?php echo $profile['xh'] ?></td>
                                            <th class="active">姓名</th>
                                            <td><?php echo $profile['xm'] ?></td>
                                            <td rowspan="10" width="240" height="320">
                                                <img src="<?php echo Route::to('student.portrait') ?>" alt="<?php echo $session['name'] ?>" /><br><br>
                                                <?php if ($allow): ?>
                                                    <div class="text-center">
                                                        <a href="<?php echo Route::to('student.upload') ?>" role="button" class="btn btn-default">上传照片</a>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="active">曾用名</th>
                                            <td><?php echo $profile['cym'] ?></td>
                                            <th class="active">拼音</th>
                                            <td><?php echo $profile['xmpy'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">性别</th>
                                            <td><?php echo $profile['xb'] ?></td>
                                            <th class="active">出生日期</th>
                                            <td><?php echo $profile['csny'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">证件类型</th>
                                            <td><?php echo $profile['zjlx'] ?></td>
                                            <th class="active">证件号码</th>
                                            <td><?php echo $profile['sfzh'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">国籍</th>
                                            <td><?php echo $profile['gj'] ?></td>
                                            <th class="active">民族</th>
                                            <td><?php echo $profile['mz'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">籍贯</th>
                                            <td><?php echo $profile['jg'] ?></td>
                                            <th class="active">政治面貌</th>
                                            <td><?php echo $profile['zzmm'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">生源地</th>
                                            <td><?php echo $profile['syd'] ?></td>
                                            <th class="active">出生地</th>
                                            <td><?php echo $profile['csd'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">学院</th>
                                            <td><?php echo $profile['xy'] ?></td>
                                            <th class="active">系所</th>
                                            <td><?php echo $profile['xs'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">专业</th>
                                            <td><?php echo $profile['zy'] ?></td>
                                            <th class="active">专业方向</th>
                                            <td><?php echo $profile['zyfs'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">第二专业</th>
                                            <td><?php echo $profile['zy2'] ?></td>
                                            <th class="active">辅修专业</th>
                                            <td><?php echo $profile['fxzy'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="row">
                	<div class="col-lg-12">
                		<div class="panel panel-default">
                            <div class="panel-heading">扩展资料</div>
                			<div class="panel-body">
                				<div class="table-responsive">
                					<table class="table table-bordered">
                                        <tr>
                                            <th class="active">班级</th>
                                            <td><?php echo $profile['bj'] ?></td>
                                            <th class="active">学制</th>
                                            <td><?php echo $profile['xz'] ?></td>
                                            <th class="active">年级</th>
                                            <td><?php echo $profile['nj'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">办学形式</th>
                                            <td><?php echo $profile['bxxs'] ?></td>
                                            <th class="active">办学类型</th>
                                            <td><?php echo $profile['bxlx'] ?></td>
                                            <th class="active">学习形式</th>
                                            <td><?php echo $profile['xxxs'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">招生季节</th>
                                            <td><?php echo $profile['zsjj'] ?></td>
                                            <th class="active">加入日期</th>
                                            <td><?php echo $profile['jrrq'] ?></td>
                                            <th class="active">师范类代码</th>
                                            <td><?php echo $profile['sfldm'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">主修外语语种</th>
                                            <td><?php echo $profile['zxwyyz'] ?></td>
                                            <th class="active">主修外语级别</th>
                                            <td><?php echo $profile['zxwyjb'] ?></td>
                                            <th class="active">计算机等级</th>
                                            <td><?php echo $profile['jsjdj'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">学籍状态</th>
                                            <td><?php echo $profile['xjzt'] ?></td>
                                            <th class="active">专业类别</th>
                                            <td colspan="3"><?php echo $profile['zylb'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">入学日期</th>
                                            <td><?php echo $profile['rxrq'] ?></td>
                                            <th class="active">入学方式</th>
                                            <td colspan="3"><?php echo $profile['rxfs'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">考生号</th>
                                            <td><?php echo $profile['ksh'] ?></td>
                                            <th class="active">中学名称</th>
                                            <td colspan="3"><?php echo $profile['zxmc'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">家长姓名</th>
                                            <td><?php echo $profile['jzxm'] ?></td>
                                            <th class="active">联系电话</th>
                                            <td colspan="3"><?php echo $profile['lxdh'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">邮政编码</th>
                                            <td><?php echo $profile['yzbm'] ?></td>
                                            <th class="active">家庭地址</th>
                                            <td colspan="3"><?php echo $profile['jtdz'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">特长</th>
                                            <td><?php echo $profile['tc'] ?></td>
                                            <th class="active">火车到站</th>
                                            <td colspan="3"><?php echo $profile['hcdz'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="active">备注</th>
                                            <td colspan="5"><?php echo $profile['bz'] ?></td>
                                        </tr>
                					</table>
                				</div>
                			</div>
                		</div>
                	</div>
                </section>
