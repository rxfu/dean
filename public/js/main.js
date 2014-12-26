$.getJsUrl = function() {
	var url = $("script").last().attr("src");

	return url.substring(0, url.lastIndexOf("/") + 1);
}

$(document).ready(function() {
	$('#flash_error').on('closed.bs.alert', function() {
		$.get('clearSession.php', {
			name: "error"
		});
	});
	$('#flash_warning').on('closed.bs.alert', function() {
		$.get('clearSession.php', {
			name: "warning"
		});
	});
	$('#flash_info').on('closed.bs.alert', function() {
		$.get('clearSession.php', {
			name: "info"
		});
	});
	$('#flash_success').on('closed.bs.alert', function() {
		$.get('clearSession.php', {
			name: "success"
		});
	});
	$('a[href="' + $(location).attr('href') + '"]').closest('ul.nav').addClass('collapse in');
	$('#loginForm')
		.bootstrapValidator({
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				username: {
					message: '用户名无效',
					validators: {
						notEmpty: {
							message: '用户名不能为空'
						},
						stringLength: {
							min: 12,
							max: 12,
							message: '用户名为12位学号'
						},
						regexp: {
							regexp: /^[0-9]+$/,
							message: '用户名只能是数字格式'
						}
					}
				},
				password: {
					validators: {
						notEmpty: {
							message: '密码不能为空'
						}
					}
				}
			}
		});
	$('#passwordForm')
		.bootstrapValidator({
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				oldPassword: {
					validators: {
						notEmpty: {
							message: '旧密码不能为空'
						}
					},
					different: {
						field: 'newPassword',
						message: '新密码与旧密码相同'
					}
				},
				newPassword: {
					validators: {
						notEmpty: {
							message: '新密码不能为空'
						},
						different: {
							field: 'oldPassword',
							message: '新密码与旧密码相同'
						},
						identical: {
							field: 'confirmedPassword',
							message: '两次输入密码不一致'
						}
					}
				},
				confirmedPassword: {
					validators: {
						notEmpty: {
							message: '确认密码不能为空'
						},
						identical: {
							field: 'newPassword',
							message: '两次输入密码不一致'
						}
					}
				}
			}
		});
	$('input[type=checkbox]').change(function() {
		if ($(this).is(':checked')) {
			$.get('elect.php', {
				course: $(this).val()
			});
		} else {
			$.get('drop.php', {
				course: $(this).val()
			});
		}
	});
	$('#campus-tab a:first').tab('show');
});