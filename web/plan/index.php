<?php section('header') ?>
<?php section('navigation') ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">教学计划</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"><?php echo Session::read('college') ?><?php echo Session::read('grade') ?>级<?php echo Session::read('speciality') ?>专业课程设置计划总表</div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="active">课程平台</th>
                                            <th class="active">课程性质</th>
                                            <th class="active">课程代码</th>
                                            <th class="active">课程中文名称</th>
                                            <th class="active">课程英文名称</th>
                                            <th class="active">总学分</th>
                                            <th class="active">理论讲授学分</th>
                                            <th class="active">实验实训学分</th>
                                            <th class="active">学时数</th>
                                            <th class="active">理论讲授学时</th>
                                            <th class="active">实验实训学时</th>
                                            <th class="active">开课学期</th>
                                            <th class="active">考核方式</th>
                                            <th class="active">开课单位</th>
                                        </tr>
                                        <?php foreach ($plans as $plan): ?>
                                            <tr>
                                                <th class="active"><?php echo $plan['pt'] ?></th>
                                                <th class="active"><?php echo $plan['xz'] ?></th>
                                                <td><?php echo $plan['kch'] ?></td>
                                                <td><?php echo $plan['kcmc'] ?></td>
                                                <td><?php echo $plan['kcywmc'] ?></td>
                                                <td><?php echo $plan['zxf'] ?></td>
                                                <td><?php echo $plan['llxf'] ?></td>
                                                <td><?php echo $plan['syxf'] ?></td>
                                                <td><?php echo $plan['llxs'] + $plan['syxs'] ?></td>
                                                <td><?php echo $plan['llxs'] ?></td>
                                                <td><?php echo $plan['syxs'] ?></td>
                                                <td><?php echo $plan['kxq'] ?></td>
                                                <td><?php echo $plan['kh'] ?></td>
                                                <td><?php echo $plan['kkxy'] ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php section('footer') ?>