function Progress() {
	this.show = function () {
		var html = '<div class="backDrop show"><img src="/storage/fade-spinner.gif"><p>Please wait ...</p></div>';
		$('body').append(html);
	}
	this.hide = function () {
		$('.backDrop').remove();
	}
}