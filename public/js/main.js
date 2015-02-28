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
	$('a[href="' + $(location).attr('href') + '"]').parents('ul.nav').not('ul#side-menu').addClass('collapse in');
	$('#loginForm')
		.formValidation({
			framework: 'bootstrap',
			icon: {
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
		.formValidation({
			framework: 'bootstrap',
			icon: {
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
			'url': $().getBaseUrl() + 'js/plugins/dataTables/i18n/zh_cn.lang'
		}
	});
	$('.course-table').dataTable({
		'paging': false,
		'ordering': false,
		'language': {
			'url': $().getBaseUrl() + 'js/plugins/dataTables/i18n/zh_cn.lang'
		}
	});
	$('#campus-tab a').click(function(e) {
		e.preventDefault();
		$(this).tab('show');
	});
	$(':input[name^="grade"]').change(function() {
		var input = $(this);
		var form = $(this).closest('form');
		var sno = $(this).closest('tr').attr('data-row');
		var mode = $(this).attr('name');
		$.ajax({
			type: "post",
			url: form.prop("action"),
			data: {
				"sno": sno,
				"mode": mode,
				"score": $(this).val()
			},
			success: function(response) {
				input.wrap('<div class="has-success has-feedback"></div>').after('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>');
				$('#total' + sno).text(response);
			},
			error: function(response) {
				input.wrap('<div class="has-error has-feedback"></div>').after('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>');
				$('#total' + sno).text(response);
			}
		});
	});
	$('select[name^="status"]').change(function() {
		var select = $(this);
		var form = $(this).closest('form');
		var sno = $(this).closest('tr').attr('data-row');

		$.ajax({
			type: "post",
			url: form.prop("action"),
			data: {
				"sno": sno,
				"status": $(this).val()
			},
			success: function(response) {
				select.wrap('<div class="has-success has-feedback"></div>').after('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>');
			},
			error: function(xhr, status) {
				select.wrap('<div class="has-error has-feedback"></div>').after('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>');
			}
		});
	});
	$('#courseConfirm').on('show.bs.modal', function(e) {
		var form = $(e.relatedTarget).closest('form');
		$(this).find('.modal-footer #confirm').data('form', form);

		if (true === form.find('input:checkbox').is(':checked')) {
			$(this).find('.modal-title').text('选课确认');
			$(this).find('.modal-body p').html('即将选择<span id="course" class="text-danger">' + $(e.relatedTarget).attr('data-whatever') + '</span>课程，确认选课？');
		} else {
			$(this).find('.modal-title').text('退课确认');
			$(this).find('.modal-body p').html('即将退选<span id="course" class="text-danger">' + $(e.relatedTarget).attr('data-whatever') + '</span>课程，确认退课？');
		}
	});
	$('#courseConfirm').find('.modal-footer #confirm').on('click', function() {
		var form = $(this).data('form');
		var checkbox = form.find('input:checkbox');
		var checked = (true === checkbox.is(':checked')) ? 'true' : 'false';

		if ('true' == checked) {
			var cno = form.find('input[name="course"]').val();
			var result;

			// 人数是否已满
			$.ajax({
				async: false,
				url: $().getBaseUrl() + 'course/full/' + cno,
				success: function(data) {
					result = $.parseJSON(data);
				}
			});
			if (true == result.status) {
				$('#fullConfirm').on('show.bs.modal', function(e) {
					$(this).find('.modal-title').text('人数超限');
					$(this).find('.modal-body p').html('选课人数已达上限！');
				});
				$('#fullConfirm').on('hidden.bs.modal', function(e) {
					$('#courseConfirm').modal('hide');
				})
				$('#fullConfirm').modal('show');
				return false;
			}

			// 选课时间是否冲突
			$.ajax({
				async: false,
				url: $().getBaseUrl() + 'course/clash/' + cno,
				success: function(data) {
					result = $.parseJSON(data);
				}
			});
			if ('object' == typeof result.status) {
				$('#clashConfirm').on('show.bs.modal', function(e) {
					$(this).find('.modal-title').text('时间冲突');
					$(this).find('.modal-body p').html('选课时间冲突！是否继续选课？');
				});
				$('#clashConfirm').find('.modal-footer #confirm').on('click', function() {
					checkbox.siblings('input:hidden[name="checked"]').val(checked);
					form.submit();
				});
				$('#clashConfirm').find('.modal-footer #cancel').on('click', function() {
					$('#courseConfirm').modal('hide');
				});
				$('#clashConfirm').modal('show');
				return false;
			}
		}
		checkbox.siblings('input:hidden[name="checked"]').val(checked);
		form.submit();
	});
	$('#courseConfirm').on('hidden.bs.modal', function(e) {
		location.reload();
	});

	var campusId = '#campus-' + $('#campus').text();
    if ($('#campus-tab a[href="' + campusId + '"]').length) {
        $('#campus-tab a[href="' + campusId + '"]').tab('show');
    } else {
        $('#campus-tab a:first').tab('show');
    }
});