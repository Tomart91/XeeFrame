<?php

namespace core\controller;

class ModalAdminController extends AdminController {

	public function preProcessAjax() {
		echo '<div class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">';
	}
	public function postProcessAjax() {
		echo '</div></div></div>';
	}
}
