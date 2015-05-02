                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['year'] ?>-<?php echo $session['year'] + 1 ?>学年<?php echo Dictionary::get('xq', $session['term']) ?><?php echo '' == $department ? '全校' : $department ?>教师评教结果明细表</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <form name="xscplForm" id="xscplForm" action="<?php echo Route::to('monitor.jspjmx') ?>" role="form" class="form-inline">
                                    <div class="form-group">
                                        <label for="department">学院</label>
                                        <select name="department" id="department" class="form-control">
                                            <option value=''>== 全部学院 ==</option>
                                            <?php foreach ($departments as $item): ?>
                                                <option value="<?php echo $item['c_mc'] ?>"<?php echo $item['c_mc'] == $department ? ' selected' : '' ?>><?php echo $item['c_mc'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">确定</button>
                                </form>
                                <div class="pull-right">导出表格</div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="active">教师工号</th>
                                                <th class="active">教师姓名</th>
                                                <th class="active">教师职称</th>
                                                <th class="active">教学态度得分</th>
                                                <th class="active">教学内容得分</th>
                                                <th class="active">教学方法得分</th>
                                                <th class="active">教学效果得分</th>
                                                <th class="active">综合得分</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($data as $item): ?>
                                            <tr>
                                                <td><?php echo $item['jsgh'] ?></td>
                                                <td><?php echo $item['jsxm'] ?></td>
                                                <td><?php echo $item['jszc'] ?></td>
                                                <td><?php echo $item['jxtd'] ?></td>
                                                <td><?php echo $item['jxnr'] ?></td>
                                                <td><?php echo $item['jxff'] ?></td>
                                                <td><?php echo $item['jxxg'] ?></td>
                                                <td><?php echo $item['zhpf'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3" class="active">平均分</th>
                                                <td><?php echo $avg['jxtd'] ?></td>
                                                <td><?php echo $avg['jxnr'] ?></td>
                                                <td><?php echo $avg['jxff'] ?></td>
                                                <td><?php echo $avg['jxxg'] ?></td>
                                                <td><?php echo $avg['zhpf'] ?></td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" class="active">标准分</th>
                                                <td><?php echo $zscore['jxtd'] ?></td>
                                                <td><?php echo $zscore['jxnr'] ?></td>
                                                <td><?php echo $zscore['jxff'] ?></td>
                                                <td><?php echo $zscore['jxxg'] ?></td>
                                                <td><?php echo $zscore['zhpf'] ?></td>
                                            </tr>
                                            <tr>
                                                <th colspan="2" rowspan="3" class="active">综合评分频率分布</th>
                                                <th class="active">等级</th>
                                                <th class="active">优秀</th>
                                                <th class="active">良好</th>
                                                <th class="active">中等</th>
                                                <th class="active">及格</th>
                                                <th class="active">不及格</th>
                                            </tr>
                                            <tr>
                                                <td>人数</td>
                                                <td><?php echo $grade['yxjs'] ?></td>
                                                <td><?php echo $grade['lhjs'] ?></td>
                                                <td><?php echo $grade['zdjs'] ?></td>
                                                <td><?php echo $grade['jgjs'] ?></td>
                                                <td><?php echo $grade['bjgjs'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>百分比</td>
                                                <td><?php echo $grade['yxjs'] / $total ?></td>
                                                <td><?php echo $grade['lhjs'] / $total ?></td>
                                                <td><?php echo $grade['zdjs'] / $total ?></td>
                                                <td><?php echo $grade['jgjs'] / $total ?></td>
                                                <td><?php echo $grade['bjgjs'] / $total ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="panel-footer">
                                注：<br>①教师姓名不重复出现，若一名教师同时讲授多门课程，以平均分来统计；<br>
②各分数段标准：优秀（90～100）；良好（80～89）；中等（70～79）；及格（60～69）；不及格（60分以下）<br>
③此表拥有排序功能，可实现按照“教师姓名”进行排序。<br>
④此表可反馈给学校相关负责领导、教务处相关负责领导、各学院主管教学副院长。
                            </div>
                        </div>
                    </div>
                </section>
