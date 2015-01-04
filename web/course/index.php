<?php include 'header.php' ?>
<?php
if (isArrearage($session->get('username'))) {
    
    redirect('arrearage.php');
}
?>
<?php include 'navigation.php' ?>
<?php
$items = listElectiveCourses($session->get('username'), $session->get('spno'), $session->get('grade'), $session->get('year'), $session->get('term'), $session->get('season'), 'K', 'B');
?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?php echo $session->get('name') ?>同学<?php echo $session->get('year') ?>年度<?php echo parseDictCode('xq', $session->get('term')) ?>学期选课表</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="active">操作</th>
                                                <th class="active">课程序号</th>
                                                <th class="active">课程名称</th>
                                                <th class="active">学分</th>
                                                <th class="active">考核方式</th>
                                                <th class="active">上课时间</th>
                                                <th class="active">上课周数</th>
                                                <th class="active">所在校区</th>
                                                <th class="active">主要任课老师</th>
                                                <th class="active">上课人数</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($items as $item): ?>
                                            <tr>
                                                <td><input type="checkbox" value="<?php echo $item['kcxh'] ?>" <?php echo isElective($session->get('username'), $session->get('year'), $session->get('term'), $item['kcxh']) ? 'checked' : '' ?>></td>
                                                <td><?php echo $item['kcxh'] ?></td>
                                                <td><?php echo $item['kcmc'] ?></td>
                                                <td><?php echo $item['xf'] ?></td>
                                                <td><?php echo $item['kh'] ?></td>
                                                <td>
                                                    <?php 
                                                    foreach ($item['sksj'] as $time) {
                                                        echo $time['sksj'] . '<br />';
                                                    } 
                                                    ?>
                                                </td>
                                                <td><?php echo $item['jsz'] - $item['ksz'] ?></td>
                                                <td><?php echo $item['xqh'] ?></td>
                                                <td><?php echo $item['jsxm'] ?></td>
                                                <td><?php echo $item['rs'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<?php include 'footer.php' ?>