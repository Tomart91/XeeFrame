var app = {
	request: function (url, params, type, callback, errorCallback, pjax) {
		//params['csrf_token'] = app.getMainParams('csrf_token');
		var progressObject = new Progress();
		progressObject.show();

		var checkData = function (response, textStatus, jqXHR) {
			try {
				progressObject.hide();
				callback(response);
				var html = '<div class="col-xs-12 well">' +
						url + ' ' + jqXHR.status + ' ' +  jqXHR.statusText + 
				'</div>'
				$('#ajax').append(html);
				console.log(jqXHR);
			} catch (e) {
				if (typeof errorCallback == 'function')
					errorCallback(response);
			}
		};
		if (pjax) {
			$.pjax({
				url: url,
				type: 'POST',
				data: params,
				container: $('#pjaxContainer'),
				success: checkData
			});
		} else {
			var ajaxParams = {
				url: url,
				type: type,
				data: params,
				success: checkData
			}
			if (params instanceof FormData) {
				ajaxParams['processData'] = false;
				ajaxParams['contentType'] = false;
			}
			$.ajax(ajaxParams);
		}
	},
	pjax: function (url, params, type, callback, errorCallback) {
		app.request(url, params, type, callback, errorCallback, true);
	},
	ajax: function (url, params, type, callback, errorCallback) {
		app.request(url, params, type, callback, errorCallback, false);
	},
	getParams: function (name) {
		return $('#' + name).val();
	},
	autoLoad: function () {
		var module = app.getParams('module');
		module = module.replace("\\", "_");
		var action = app.getParams('action');
		var nameClass = module + '_' + action;
		var myObject = eval("new " + nameClass + "()");
		myObject.register();
	},
	showModalByAjax: function (url, cbAfterShow, cbAfterSave) {
		$('body').append('<div class="globalModal"></div>');
		app.ajax(url, {}, 'POST', function (response) {
			var globalModal = $('.globalModal');
			globalModal.html(response);
			var modalContainer = globalModal.find('.modal');
			modalContainer.on('shown.bs.modal', function (container) {
				var form = $('form');
				form.submit(function (event) {
					event.preventDefault();
					var formData = new FormData($(this)[0]);
					app.ajax(form.attr('action'), formData, 'POST', function (response) {
						modalContainer.modal('hide');
						cbAfterSave(response);
					});
				});
				cbAfterShow(container);
			});
			modalContainer.on('hidden.bs.modal', function () {
				globalModal.remove();
			});
			modalContainer.modal('show');
		});
	}
}

jQuery(document).ready(function () {
	app.autoLoad();
})

