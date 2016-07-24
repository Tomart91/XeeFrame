function Home_Index() {
	this.registerLinks = function () {
		$('.link').on('click', function (e) {
			var currentTarget = $(e.currentTarget);
			var url = currentTarget.data('url');
			app.pjax(url, {}, 'GET', function (response) {
				console.log('sdfsdf');
			});
		});
	};
	this.register = function () {
		this.registerLinks();
	};
}