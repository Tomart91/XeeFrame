function Home_Index() {
	this.registerLinks = function () {
		$('.link').on('click', function (e) {
			var currentTarget = $(e.currentTarget);
			var url = currentTarget.data('url');
			app.pjax(url, {}, 'GET', function (response) {

			});
		});
	};
	this.register = function () {
		this.registerLinks();
	};
}