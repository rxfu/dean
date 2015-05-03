                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['year'] ?>-<?php echo $session['year'] + 1 ?>学年<?php echo Dictionary::get('xq', $session['term']) ?><?php echo '' == $department ? '全校' : $department ?>单名教师单门课程评教得分明细表</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <form name="xscplForm" id="xscplForm" action="<?php echo Route::to('monitor.xscpl') ?>" role="form" class="form-inline">
                                    <div class="form-group">
                                        <label for="department">学院</label>
                                        <select name="department" id="department" class="form-control">
                                            <option value=''>== 全部学院 ==</option>
                                            <?php foreach ($departments as $item): ?>
                                                <option value="<?php echo $item['c_mc'] ?>"<?php echo $item['c_mc'] == $department ? ' selected' : '' ?>><?php echo $item['c_mc'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="teacher">教师</label>
                                        <select name="teacher" id="teacher" class="form-control">
                                            <option value=''>== 选择教师 ==</option>
                                            <?php foreach ($teachers as $item): ?>
                                                <option value="<?php echo $item['jsgh'] ?>" class="<?php echo $item['kkxy'] ?>" <?php echo $item['kch'] == $teacher ? ' selected' : '' ?>><?php echo $item['kcmc'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="course">课程</label>
                                        <select name="course" id="course" class="form-control">
                                            <option value=''>== 选择课程 ==</option>
                                            <?php foreach ($courses as $item): ?>
                                                <option value="<?php echo $item['kch'] ?>" class="<?php echo $item['kkxy'] ?>" <?php echo $item['kch'] == $course ? ' selected' : '' ?>><?php echo $item['kcmc'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">查询</button>
                                </form>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="active">一级指标</th>
                                                <th class="active">二级指标</th>
                                                <th class="active">二级指标得分</th>
                                                <th class="active">一级指标得分</th>
                                                <th class="active">综合评分</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($indexes as $key => $item): ?>
                                            <tr>
                                                <td><?php echo $item['zb_mc'] ?></td>
                                                <td><?php echo $item['ejzb_mc'] ?></td>
                                                <td><?php echo $item['ejpf'][$i][$j] ?></td>
                                                <td><?php echo $item['yjpf'][$i] ?></td>
                                                <td><?php echo $item['zh'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="panel-footer">
                                注：<br>①若出现“教师姓名”、“授课名称”分别相同，而“主要授课年级、专业”不同的情况，属于不同年级或专业合班授课，对于此种情况采取合并处理，“主要授课年级、专业”采取罗列方式呈现；<br>
    ②设置二级查询：“教师所在学院”（一级查询）——“教师姓名”（二级查询），通过二级查询可实现对某名教师的相应统计；<br>
③一名教师一门课程对应一张得分明细表；<br>
④由于计算机无法对文字性评价进行高级识别，因此评教系统无法顾及表述不清、信息重复、措辞不当、真实性等方面的问题。对“优点”、“缺点”等文字性评价采取一一罗列的方式呈现，即有多少名学生参与评价，就罗列多少条文字记录。未经处理的文字性评价仅供教师个人参考！<br>
⑤此表仅面对教师个人进行反馈。
                            </div>
                        </div>
                    </div>
                </section>
