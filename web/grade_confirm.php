                <div class="modal fade" id="gradeConfirm" tabindex="-1" role="dialog" aria-labelledby="#gradeConfirmLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="关闭"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="gradeConfirmLabel">成绩确认</h4>
                            </div>
                        <div class="modal-body">
                            <p>注意：请检查成绩是否已经录入完毕并且正确，成绩确认后将不可更改！</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">取消</button>
                            <a role="button" class="btn btn-primary" id="confirm" href="<?php echo Route::to('score.confirm', $info['kcxh']) ?>">确定</a>
                        </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->