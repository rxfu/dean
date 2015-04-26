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
                                            <th class="active">用户名</th>
                                            <td><?php echo $profile['username'] ?></td>
                                            <th class="active">单位</th>
                                            <td><?php echo $profile['user_dep'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
