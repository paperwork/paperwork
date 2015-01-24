<?php
class AdminController extends BaseController {
	public function showConsole() {
		return View::make('admin/console');
	}
}
