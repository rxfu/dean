<?php include 'header.php' ?>
<?php include 'navigation.php' ?>
<?php
$current = array_pop($messages);
$count = array_pop($messages);
$pages = array_pop($messages);

$first = max(1, $current - 4);
$last = min($pages, $current + 4);
?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">系统消息</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">                            
                            <div class="panel-heading">
                                共<?php echo $count ?>条系统消息，共<?php echo $pages ?>页，目前在第
                                <select onchange="window.location=this.value;">
                                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                                    <option value="<?php echo toLink('system.message', array($i)) ?>"<?php echo ($p == $i) ? ' selected' : ''?>><?php echo $i ?></option>
                                    <?php endfor ?>
                                </select>
                                页
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">                                        
                                        <thead>
                                            <tr>
                                                <th class="active">发送者</th>
                                                <th class="active">内容</th>
                                                <th class="active">发送时间</th>
                                                <th class="active">状态</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($items as $item): ?>
                                            <tr>
                                                <td><?php echo $item['xxfsz'] ?></td>
                                                <td><?php echo $item['xxnr'] ?></td>
                                                <td><?php echo $item['fssj'] ?></td>
                                                <td><?php echo $item['ydbz'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="10" class="text-right">
                                                    <ul class="pagination">
                                                        <?php if ($current != 1): ?>
                                                            <li><a href="<?php echo toLink('system.message', array(1)) ?>">首页</a></li>
                                                            <li><a href="<?php echo toLink('system.message', array($current - 1)) ?>">上一页</a></li>
                                                        <?php endif ?>
                                                        <?php for ($i = $first; $i <= $last; $i++): ?>
                                                        <li<?php echo ($current == $i) ? ' class="active"' : ''?>><a href="<?php echo toLink('system.message', array($i)) ?>"><?php echo $i ?></a></li>
                                                        <?php endfor ?>
                                                        <?php if ($current != $pages): ?>
                                                            <li><a href="<?php echo toLink('system.message', array($current + 1)) ?>">下一页</a></li>
                                                            <li><a href="<?php echo toLink('system.message', array($pages)) ?>">末页</a></li>
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
