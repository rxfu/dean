                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session['name'] ?>同学<?php echo $session['year'] ?>年度<?php echo Dictionary::get('xq', $session['term']) ?>学期<?php echo Dictionary::get('pt', $platform) ?><?php echo Dictionary::get('xz', $property) ?>学分情况详单</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="title">应修学分：<?php echo $requirement ?>&nbsp;&nbsp;已修学分：<?php echo $studied ?></div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="active text-center">课程号</th>
                                                <th class="active text-center">课程名称</th>
                                                <th class="active text-center">年度</th>
                                                <th class="active text-center">学期</th>
                                                <th class="active text-center">课程平台</th>
                                                <th class="active text-center">课程性质</th>
                                                <th class="active text-center">考核方式</th>
                                                <th class="active text-center">成绩</th>
                                                <th class="active text-center">补考成绩</th>
                                                <th class="active text-center">重修成绩</th>
                                                <th class="active text-center">考试状态</th>
                                                <th class="active text-center">学分</th>
                                                <th class="active text-center">绩点</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($scores as $score): ?>
                                                <tr>
                                                    <td><?php echo $score['kch'] ?></td>
                                                    <td><?php echo $score['kcmc'] ?></td>
                                                    <td><?php echo $score['nd'] ?></td>
                                                    <td><?php echo Dictionary::get('xq', $score['xq']) ?></td>
                                                    <td><?php echo Dictionary::get('pt', $score['pt']) ?></td>
                                                    <td><?php echo Dictionary::get('xz', $score['kcxz']) ?></td>
                                                    <td><?php echo $score['kh'] ?></td>
                                                    <td><?php echo $score['cj'] ?></td>
                                                    <td><?php echo $score['bkcj'] ?></td>
                                                    <td><?php echo $score['cxcj'] ?></td>
                                                    <td><?php echo $score['kszt'] ?></td>
                                                    <td><?php echo $score['xf'] ?></td>
                                                    <td><?php echo $score['jd'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="title">正在修读学分：<?php echo $studying ?></div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="active text-center">课程序号</th>
                                                <th class="active text-center">课程名称</th>
                                                <th class="active text-center">课程平台</th>
                                                <th class="active text-center">课程性质</th>
                                                <th class="active text-center">学分</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($studyingCourses as $studyingCourse): ?>
                                                <tr>
                                                    <td><?php echo $studyingCourse['kcxh'] ?></td>
                                                    <td><?php echo $studyingCourse['kcmc'] ?></td>
                                                    <td><?php echo Dictionary::get('pt', $studyingCourse['pt']) ?></td>
                                                    <td><?php echo Dictionary::get('xz', $studyingCourse['xz']) ?></td>
                                                    <td><?php echo $studyingCourse['xf'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="title">教学计划中未修读必修课程</div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="active text-center">课程号</th>
                                                <th class="active text-center">课程名称</th>
                                                <th class="active text-center">课程平台</th>
                                                <th class="active text-center">课程性质</th>
                                                <th class="active text-center">开课学期</th>
                                                <th class="active text-center">学分</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($unstudiedCourses as $unstudiedCourse): ?>
                                                <tr>
                                                    <td><?php echo $unstudiedCourse['kch'] ?></td>
                                                    <td><?php echo $unstudiedCourse['kcmc'] ?></td>
                                                    <td><?php echo Dictionary::get('pt', $unstudiedCourse['pt']) ?></td>
                                                    <td><?php echo Dictionary::get('xz', $unstudiedCourse['xz']) ?></td>
                                                    <td><?php echo $unstudiedCourse['kxq'] ?></td>
                                                    <td><?php echo $unstudiedCourse['zxf'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="title">教学计划提供修读的专业选修课程</div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="active text-center">课程号</th>
                                                <th class="active text-center">课程名称</th>
                                                <th class="active text-center">课程平台</th>
                                                <th class="active text-center">课程性质</th>
                                                <th class="active text-center">开课学期</th>
                                                <th class="active text-center">学分</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($electiveCourses as $electiveCourse): ?>
                                                <tr>
                                                    <td><?php echo $electiveCourse['kch'] ?></td>
                                                    <td><?php echo $electiveCourse['kcmc'] ?></td>
                                                    <td><?php echo Dictionary::get('pt', $electiveCourse['pt']) ?></td>
                                                    <td><?php echo Dictionary::get('xz', $electiveCourse['xz']) ?></td>
                                                    <td><?php echo $electiveCourse['kxq'] ?></td>
                                                    <td><?php echo $electiveCourse['zxf'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
