<?php
class AdminController extends BaseController {
	public function showConsole() {
		$users = User::all();
	    return View::make('admin/console')->with('users', $users);
	}
}
