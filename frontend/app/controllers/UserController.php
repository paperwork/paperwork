<?php

class UserController extends BaseController {
	public function register() {
		if($this->isPostRequest()) {
			$validator = $this->getRegistrationValidator();

			if($validator->passes()) {
				// $credentials = $this->getRegistrationCredentials();

				$user = User::create(Input::except('_token', 'password_confirmation'));
				if ($user) {
					Auth::login($user);
					return Redirect::route("user/profile");
				}
				return Redirect::back()->withErrors([ "password" => [Lang::get('messages.account_creation_failed')]]);


			} else {
				return Redirect::back()->withInput()->withErrors($validator);
			}
		}
		return View::make('user/register');
	}

	public function login()
	{
		if($this->isPostRequest()) {
			$validator = $this->getLoginValidator();

			if($validator->passes()) {
				$credentials = $this->getLoginCredentials();

				if (Auth::attempt($credentials)) {
					return Redirect::route("user/profile");
				}
				return Redirect::back()->withErrors([ "password" => [Lang::get('messages.invalid_credentials')]]);


			} else {
				return Redirect::back()->withInput()->withErrors($validator);
			}
		}
		return View::make('user/login');
	}

	protected function isPostRequest()
	{
		return Input::server("REQUEST_METHOD") == "POST";
	}

	protected function getRegistrationValidator() {
		return Validator::make(Input::all(), [ "username" => "required|email|unique:users", "password" => "required|min:5|confirmed", "password_confirmation" => "required", "firstname" => "required|alpha_num", "lastname" => "required|alpha_num"]);
	}

	protected function getLoginValidator() {
		return Validator::make(Input::all(), [ "username" => "required|email", "password" => "required"]);
	}

	// protected function getRegistrationCredentials() {
	// 	return ["username" => Input::get("username"), "password" => Input::get("password"), "firstname" => Input::get("firstname"), "lastname" => Input::get("lastname")];
	// }

	protected function getLoginCredentials() {
		return ["username" => Input::get("username"), "password" => Input::get("password")];
	}


	public function profile()
	{
 		return View::make("user/profile");
 	}

	public function settings()
	{
 		return View::make("user/settings");
 	}

 	public function request() {
		if ($this->isPostRequest()) {
			$response = $this->getPasswordRemindResponse();
			if ($this->isInvalidUser($response)) {
				return Redirect::back()->withInput()->with("error", Lang::get($response));
			}
			return Redirect::back()->with("status", Lang::get($response));
		}
		return View::make("user/request");
	}

	protected function getPasswordRemindResponse() {
		return Password::remind(Input::only("username"));
	}

	protected function isInvalidUser($response) {
		return $response === Password::INVALID_USER;
	}

	public function reset($token) {
		if ($this->isPostRequest()) {
			$credentials = Input::only("username", "password", "password_confirmation") + compact("token");
    		$response = $this->resetPassword($credentials);
			if ($response === Password::PASSWORD_RESET) {
				return Redirect::route("user/profile");
			}
			return Redirect::back()->withInput()->with("error", Lang::get($response));
		}
		return View::make("user/reset", compact("token"));
	}

	protected function resetPassword($credentials) {
		return Password::reset($credentials, function($user, $pass) {
			$user->password = Hash::make($pass);
			$user->save();
		});
	}

	public function help()
	{
 		return View::make("user/help");
 	}

	public function logout() {
		Auth::logout();
		return Redirect::route("user/login");
	}
}
