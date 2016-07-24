var app = {
	request: function (url, params, type, callback, errorCallback, pjax) {
		//params['csrf_token'] = app.getMainParams('csrf_token');
		var checkData = function (response) {
			try {
				callback(response);
				/*var resp = JSON.parse(response);
				 if (resp.error == 'NO PERMISSION') {
				 window.location.href = resp.link;
				 } else {
				 console.log(response);
				 
				 }*/
			} catch (e) {
				if (typeof errorCallback == 'function')
					errorCallback(response);
			}
		};
		if (pjax)
			$.pjax({
				url: url,
				type: 'GET',
				data: params,
				container: $('#pjaxContainer'),
				success: checkData
			});
		else
			$.ajax({
				url: url,
				type: type,
				data: params,
				success: checkData
			});
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
		var action = app.getParams('action');
		var nameClass = module + '_' + action;
		var myObject = eval("new " + nameClass + "()");
		myObject.register();
	}
}

jQuery(document).ready(function () {
	app.autoLoad();
})

