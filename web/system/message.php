                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">系统消息</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover data-table">                                        
                                        <thead>
                                            <tr>
                                                <th class="active">发送者</th>
                                                <th class="active">内容</th>
                                                <th class="active">发送时间</th>
                                                <th class="active">状态</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($messages as $message): ?>
                                            <tr>
                                                <td><?php echo $message['xxfsz'] ?></td>
                                                <td><?php echo $message['xxnr'] ?></td>
                                                <td><?php echo $message['fssj'] ?></td>
                                                <td><?php echo $message['ydbz'] ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
