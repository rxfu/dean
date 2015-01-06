<?php section('header') ?>
<?php section('student.navigation') ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">毕业要求</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th rowspan="3" class="active text-center">课程平台与性质</th>
                                            <th colspan="4" class="active text-center">必修学分数</th>
                                            <th colspan="6" class="active text-center">选修学分数</th>
                                            <th rowspan="3" class="active text-center">至少应修读总学分</th>
                                        </tr>
                                        <tr>
                                            <th rowspan="2" class="active text-center">通识素质教育<br>(TB)</th>
                                            <th rowspan="2" class="active text-center">学科专业教育<br>(KB)</th>
                                            <th rowspan="2" class="active text-center">教师资格教育<br>(JB)</th>
                                            <th rowspan="2" class="active text-center">集中实践教育<br>(SB)</th>
                                            <th colspan="4" class="active text-center">通识素质教育选修</th>
                                            <th rowspan="2" class="active text-center">学科专业教育选修<br>(KX)</th>
                                            <th rowspan="2" class="active text-center">教师资格教育选修<br>(JX)</th>
                                        </tr>
                                        <tr>
                                            <th class="active text-center">人文社科<br>(TW)</th>
                                            <th class="active text-center">自然科学<br>(TI)</th>
                                            <th class="active text-center">艺术体育<br>(TY)</th>
                                            <th class="active text-center">其他专项<br>(TQ)</th>
                                        </tr>
                                        <tr>
                                            <th rowspan="2" class="active text-center">至少应修读学分数</th>
                                            <td class="text-center"><?php echo $require['TB'] ?></td>
                                            <td class="text-center"><?php echo $require['KB'] ?></td>
                                            <td class="text-center"><?php echo $require['JB'] ?></td>
                                            <td class="text-center"><?php echo $require['SB'] ?></td>
                                            <td class="text-center"><?php echo $require['TW'] ?></td>
                                            <td class="text-center"><?php echo $require['TI'] ?></td>
                                            <td class="text-center"><?php echo $require['TY'] ?></td>
                                            <td class="text-center"><?php echo $require['TQ'] ?></td>
                                            <td class="text-center"><?php echo $require['KX'] ?></td>
                                            <td class="text-center"><?php echo $require['JX'] ?></td>
                                            <td rowspan="2" class="text-center"><?php echo $require['TB'] + $require['KB'] + $require['JB'] + $require['SB'] + $require['TW'] + $require['TI'] + $require['TY'] + $require['TQ'] + $require['KX'] + $require['JX'] ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-center"><?php echo $require['TB'] + $require['KB'] + $require['JB'] + $require['SB'] ?></td>
                                            <td colspan="6" class="text-center"><?php echo $require['TW'] + $require['TI'] + $require['TY'] + $require['TQ'] + $require['KX'] + $require['JX'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php section('footer') ?>
