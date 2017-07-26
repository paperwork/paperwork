<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\View;

class AdminController extends BaseController {
	public function showConsole() {
		$users = User::withTrashed()->get();
	    return View::make('admin/console')->with('users', $users);
	}

	public function deleteOrRestoreUsers() {
	    $input = Input::get('selected_users');
        if (!empty($input)) {
            foreach ($input as $single_input) {
                $user = User::withTrashed()->where('id', '=', $single_input);
                if (Input::get('restore')) {
                    $user->restore();
                } else {
                    $user->delete();
                }
            }
        }
	    return Redirect::route("admin/console");
	}
}
