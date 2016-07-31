function Layout() {
	this.registerEvents = function () {
		$('.link').on('click', function (e) {
			var currentTarget = $(e.currentTarget);
			var url = currentTarget.data('url');
			app.pjax(url, {}, 'GET', function (response) {
				
			});
		});
	}
}
jQuery(document).ready(function () {
	var object = new Layout();
	object.registerEvents();
})


