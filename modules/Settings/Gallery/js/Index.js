function Settings_Gallery_Index() {
	this.refreshTable = function () {
		var thisInstance = this;
		app.pjax('/Settings/Gallery/Index', {}, 'POST', function (response) {
			thisInstance.register();
		});
	},
	this.registerAddButton = function () {
		var thisInstance = this;
		$('.addImage').on('click', function () {
			app.showModalByAjax('/Settings/Gallery/FormToAddImage', function () {

			},
			function (reponse) {
				thisInstance.refreshTable();
			});
		});
	},
	this.registerRemoveButton = function () {
		var thisInstance = this;
		$('.removeImage').on('click', function (e) {
			var currentTarget = $(e.currentTarget);
			var idImage = currentTarget.data('id');
			app.ajax('/Settings/Gallery/DeleteImage', {id: idImage}, 'POST', function () {
				thisInstance.refreshTable();
			});
		});
	},
	this.register = function () {
		this.registerAddButton();
		this.registerRemoveButton();
	};
}