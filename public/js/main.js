(function($) {
	$.fn.getJsUrl = function() {
		var url = $("script").last().attr("src");

		return url.substring(0, url.lastIndexOf("/") + 1);
	};
	$.fn.getBaseUrl = function() {
		return location.protocol + "//" + location.host + "/dean/";
	};
})(jQuery);
$(document).ready(function() {
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
	$('.data-table').dataTable({
		'lengthMenu': [
			[10, 25, 50, -1],
			[10, 25, 50, '全部']
		],
		'pagingType': 'full_numbers',
		'ordering': false,
		'language': {
			'url': $.getBaseUrl() + 'js/plugins/dataTables/i18n/zh_cn.lang'
		}
	});
	$('#campus-tab a').click(function(e) {
		e.preventDefault();
		$(this).tab('show');
	});
	$('input:checkbox').click(function(e) {
		var form = $(this).closest('form');
		var course = $(this).val();
		$.ajax({
			type: "post",
			url: form.prop('action'),
			data: {
				'course': course,
				'checked': (true === $(this).is(':checked')) ? 'true' : 'false'
			},
			success: function(data) {
				var tr = $('tr[data-name="' + course + '"] > td');
				if ('select-success' == data) {
					tr.removeClass();
					tr.addClass('success');
				}
				if ('delete-success' == data) {
					tr.removeClass();
					tr.addClass('warning');
				}
			}
		});
	});
	$(':submit[name^=retake]').click(function(e) {
		e.preventDefault();
		var form = $(this).closest('form');
		var course = $(this).val();
		$.ajax({
			type: "post",
			url: form.prop("action"),
			data: {
				"course": course
			},
			success: function(data) {

			}
		});
	});
});