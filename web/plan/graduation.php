                <section class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">毕业要求</h1>
                    </div>
                </section>

                <section class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th rowspan="3" class="active text-center">课程平台与性质</th>
                                            <th colspan="5" class="active text-center">必修学分数</th>
                                            <th colspan="7" class="active text-center">选修学分数</th>
                                            <th rowspan="3" class="active text-center">总学分</th>
                                        </tr>
                                        <tr>
                                            <th rowspan="2" class="active text-center">通识素质教育<br>(TB)</th>
                                            <th rowspan="2" class="active text-center">学科专业教育<br>(KB)</th>
                                            <th rowspan="2" class="active text-center">教师资格教育<br>(JB)</th>
                                            <th rowspan="2" class="active text-center">集中实践教育<br>(SB)</th>
                                            <th rowspan="2" class="active text-center">专业拓展教育<br>(ZB)</th>
                                            <th colspan="4" class="active text-center">通识素质教育选修</th>
                                            <th rowspan="2" class="active text-center">学科专业教育选修<br>(KX)</th>
                                            <th rowspan="2" class="active text-center">教师资格教育选修<br>(JX)</th>
                                            <th rowspan="2" class="active text-center">专业拓展教育选修<br>(ZX)</th>
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
                                            <td class="text-center"><?php echo $require['ZB'] ?></td>
                                            <td class="text-center"><?php echo $require['TW'] ?></td>
                                            <td class="text-center"><?php echo $require['TI'] ?></td>
                                            <td class="text-center"><?php echo $require['TY'] ?></td>
                                            <td class="text-center"><?php echo $require['TQ'] ?></td>
                                            <td class="text-center"><?php echo $require['KX'] ?></td>
                                            <td class="text-center"><?php echo $require['JX'] ?></td>
                                            <td class="text-center"><?php echo $require['ZX'] ?></td>
                                            <td rowspan="2" class="text-center"><?php echo $require['TB'] + $require['KB'] + $require['JB'] + $require['SB'] + $require['ZB'] + $require['TW'] + $require['TI'] + $require['TY'] + $require['TQ'] + $require['KX'] + $require['JX'] + $require['ZX'] ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-center"><?php echo $require['TB'] + $require['KB'] + $require['JB'] + $require['SB'] + $require['ZB'] ?></td>
                                            <td colspan="7" class="text-center"><?php echo $require['TW'] + $require['TI'] + $require['TY'] + $require['TQ'] + $require['KX'] + $require['JX'] + $require['ZX'] ?></td>
                                        </tr>
                                        <tr>
                                            <th rowspan="2" class="active text-center">已修读学分数</th>
                                            <td class="text-center"><?php echo $studied['TB'] ?></td>
                                            <td class="text-center"><?php echo $studied['KB'] ?></td>
                                            <td class="text-center"><?php echo $studied['JB'] ?></td>
                                            <td class="text-center"><?php echo $studied['SB'] ?></td>
                                            <td class="text-center"><?php echo $studied['ZB'] ?></td>
                                            <td class="text-center"><?php echo $studied['TW'] ?></td>
                                            <td class="text-center"><?php echo $studied['TI'] ?></td>
                                            <td class="text-center"><?php echo $studied['TY'] ?></td>
                                            <td class="text-center"><?php echo $studied['TQ'] ?></td>
                                            <td class="text-center"><?php echo $studied['KX'] ?></td>
                                            <td class="text-center"><?php echo $studied['JX'] ?></td>
                                            <td class="text-center"><?php echo $studied['ZX'] ?></td>
                                            <td rowspan="2" class="text-center"><?php echo $studied['TB'] + $studied['KB'] + $studied['JB'] + $studied['SB'] + $studied['ZB'] + $studied['TW'] + $studied['TI'] + $studied['TY'] + $studied['TQ'] + $studied['KX'] + $studied['JX'] + $studied['ZX'] ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-center"><?php echo $studied['TB'] + $studied['KB'] + $studied['JB'] + $studied['SB'] + $studied['ZB'] ?></td>
                                            <td colspan="7" class="text-center"><?php echo $studied['TW'] + $studied['TI'] + $studied['TY'] + $studied['TQ'] + $studied['KX'] + $studied['JX'] + $studied['ZX'] ?></td>
                                        </tr>
                                        <tr>
                                            <th rowspan="2" class="active text-center">本次选修学分数</th>
                                            <td class="text-center"><?php echo $selected['TB'] ?></td>
                                            <td class="text-center"><?php echo $selected['KB'] ?></td>
                                            <td class="text-center"><?php echo $selected['JB'] ?></td>
                                            <td class="text-center"><?php echo $selected['SB'] ?></td>
                                            <td class="text-center"><?php echo $selected['ZB'] ?></td>
                                            <td class="text-center"><?php echo $selected['TW'] ?></td>
                                            <td class="text-center"><?php echo $selected['TI'] ?></td>
                                            <td class="text-center"><?php echo $selected['TY'] ?></td>
                                            <td class="text-center"><?php echo $selected['TQ'] ?></td>
                                            <td class="text-center"><?php echo $selected['KX'] ?></td>
                                            <td class="text-center"><?php echo $selected['JX'] ?></td>
                                            <td class="text-center"><?php echo $selected['ZX'] ?></td>
                                            <td rowspan="2" class="text-center"><?php echo $selected['TB'] + $selected['KB'] + $selected['JB'] + $selected['SB'] + $selected['ZB'] + $selected['TW'] + $selected['TI'] + $selected['TY'] + $selected['TQ'] + $selected['KX'] + $selected['JX'] + $selected['ZX'] ?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="text-center"><?php echo $selected['TB'] + $selected['KB'] + $selected['JB'] + $selected['SB'] + $selected['ZB'] ?></td>
                                            <td colspan="7" class="text-center"><?php echo $selected['TW'] + $selected['TI'] + $selected['TY'] + $selected['TQ'] + $selected['KX'] + $selected['JX'] + $selected['ZX'] ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
