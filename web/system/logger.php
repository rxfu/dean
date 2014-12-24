<?php section('header') ?>
<?php section('navigation') ?>
<?php
$current = array_pop($logs);
$count = array_pop($logs);
$pages = array_pop($logs);

$first = max(1, $current - 4);
$last = min($pages, $current + 4);
?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">选课日志</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">                            
                            <div class="panel-heading">
                                共<?php echo $count ?>条日志记录，共<?php echo $pages ?>页，目前在第
                                <select onchange="window.location=this.value;">
                                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                                    <option value="<?php echo $_SERVER['PHP_SELF'] . '?p=' . $i ?>"<?php echo ($current == $i) ? ' selected' : ''?>><?php echo $i ?></option>
                                    <?php endfor ?>
                                </select>
                                页
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">                                        
                                        <thead>
                                            <tr>
                                                <th class="active">操作时间</th>
                                                <th class="active">IP地址</th>
                                                <th class="active">课程序号</th>
                                                <th class="active">操作类型</th>
                                                <th class="active">备注</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($logs as $log): ?>
                                            <tr>
                                                <td><?php echo $log['czsj'] ?></td>
                                                <td><?php echo $log['ip'] ?></td>
                                                <td><?php echo $log['kcxh'] ?></td>
                                                <td><?php echo parseType($log['czlx']) ?></td>
                                                <td><?php echo $log['bz'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="10" class="text-right">
                                                    <ul class="pagination">
                                                        <?php if ($current != 1): ?>
                                                            <li><a href="<?php echo toLink('system.log', array(1)) ?>">首页</a></li>
                                                            <li><a href="<?php echo toLink('system.log', array($current - 1)) ?>">上一页</a></li>
                                                        <?php endif ?>
                                                        <?php for ($i = $first; $i <= $last; $i++): ?>
                                                        <li<?php echo ($current == $i) ? ' class="active"' : ''?>><a href="<?php echo toLink('system.log', array($i)) ?>"><?php echo $i ?></a></li>
                                                        <?php endfor ?>
                                                        <?php if ($current != $pages): ?>
                                                            <li><a href="<?php echo toLink('system.log', array($current + 1)) ?>">下一页</a></li>
                                                            <li><a href="<?php echo toLink('system.log', array($pages)) ?>">末页</a></li>
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