<?php section('header') ?>
<?php section('navigation') ?>
<?php
$current = array_pop($courses);
$count = array_pop($courses);
$pages = array_pop($courses);

$first = max(1, $current - 4);
$last = min($pages, $current + 4);
?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">课程基本信息</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">                            
                            <div class="panel-heading">
                                共<?php echo $count ?>门课程，共<?php echo $pages ?>页，目前在第
                                <select onchange="window.location=this.value;">
                                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                                    <option value="<?php echo toLink('plan.course', array($i)) ?>"<?php echo ($p == $i) ? ' selected' : ''?>><?php echo $i ?></option>
                                    <?php endfor ?>
                                </select>
                                页
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">                                        
                                        <thead>
                                            <tr>
                                                <th class="active">课程代码</th>
                                                <th class="active">课程名称</th>
                                                <th class="active">英文名称</th>
                                                <th class="active">学分</th>
                                                <th class="active">学时</th>
                                                <th class="active">主要内容</th>
                                                <th class="active">使用教材</th>
                                                <th class="active">参考书目</th>
                                                <th class="active">考核方式</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($items as $item): ?>
                                            <tr>
                                                <td><?php echo $item['kch'] ?></td>
                                                <td><?php echo $item['kcmc'] ?></td>
                                                <td><?php echo $item['kcywmc'] ?></td>
                                                <td><?php echo $item['xf'] ?></td>
                                                <td><?php echo $item['xs'] ?></td>
                                                <td><?php echo $item['ff'] ?></td>
                                                <td><?php echo $item['jc'] ?></td>
                                                <td><?php echo $item['cks'] ?></td>
                                                <td><?php echo $item['kh'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="10" class="text-right">
                                                    <ul class="pagination">
                                                        <?php if ($current != 1): ?>
                                                            <li><a href="<?php echo toLink('plan.course', array(1)) ?>">首页</a></li>
                                                            <li><a href="<?php echo toLink('plan.course', array($current - 1)) ?>">上一页</a></li>
                                                        <?php endif ?>
                                                        <?php for ($i = $first; $i <= $last; $i++): ?>
                                                        <li<?php echo ($current == $i) ? ' class="active"' : ''?>><a href="<?php echo toLink('plan.course', array($i)) ?>"><?php echo $i ?></a></li>
                                                        <?php endfor ?>
                                                        <?php if ($current != $pages): ?>
                                                            <li><a href="<?php echo toLink('plan.course', array($current + 1)) ?>">下一页</a></li>
                                                            <li><a href="<?php echo toLink('plan.course', array($pages)) ?>">末页</a></li>
                                                        <?php endif ?>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php section('footer') ?>
