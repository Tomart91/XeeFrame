function Layout() {
	this.registerSubmenu = function () {
		var container = $('.containerSubmenu');
		$('.submenu').on('click', function (e) {
			if (!container.hasClass('open')) {
				var currentTarget = $(e.currentTarget);
				var url = currentTarget.data('url');
				app.ajax(url, {}, 'GET', function (response) {
					container.html(response);
				});
			}
			container.toggleClass('open');
		});
	},
	this.registerEvents = function () {
		this.registerSubmenu();
		$('.link').on('click', function (e) {
			var currentTarget = $(e.currentTarget);
			var url = currentTarget.data('url');
			app.pjax(url, {}, 'GET', function (response) {});
		});
		$('.carousel').carousel({
			interval: 5000
		})
	}
}
jQuery(document).ready(function () {
	var object = new Layout();
	object.registerEvents();
})


