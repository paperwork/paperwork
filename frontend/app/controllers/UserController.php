<?php

class UserController extends BaseController {
	public function register() {
		if($this->isPostRequest()) {
			$validator = $this->getRegistrationValidator();

			if($validator->passes()) {
				// $credentials = $this->getRegistrationCredentials();

				$user = User::create(Input::except('_token', 'password_confirmation', 'ui_language'));
				if ($user) {
					$user->save();
					$setting = Setting::create(array('ui_language' => Input::get('ui_language'), 'user_id' => $user->id));
					Auth::login($user);
					return Redirect::route("/");
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
					$settings = Setting::where('user_id', '=',Auth::user()->id)->first();

					App::setLocale($settings->ui_language);

					return Redirect::route("/");
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

	protected function getProfileValidator() {
		return Validator::make(Input::all(), [ "password" => "min:5|confirmed", "firstname" => "required|alpha_num", "lastname" => "required|alpha_num"]);
	}

	protected function getSettingsValidator() {
		return Validator::make(Input::all(), [ "ui_language" => "required" ]);
	}

	// protected function getRegistrationCredentials() {
	// 	return ["username" => Input::get("username"), "password" => Input::get("password"), "firstname" => Input::get("firstname"), "lastname" => Input::get("lastname")];
	// }

	protected function getLoginCredentials() {
		return ["username" => Input::get("username"), "password" => Input::get("password")];
	}


	public function profile()
	{
		$user = User::find(Auth::user()->id);

		if($this->isPostRequest()) {
			$validator = $this->getProfileValidator();

			if($validator->passes()) {
				$user->firstname = Input::get('firstname');
				$user->lastname = Input::get('lastname');

				$passwd = Input::get('password');
				if(!is_null($passwd) && trim($passwd) != "") {
					$user->password = Input::get('password');
				}
				if (!$user->save()) {
					return Redirect::back()->withErrors([ "password" => [Lang::get('messages.account_update_failed')]]);
				}
			} else {
				return Redirect::back()->withInput()->withErrors($validator);
			}
		}
 		return View::make("user/profile")->with('user', $user);
 	}

	public function settings()
	{
		$user = User::find(Auth::user()->id);
		$settings = Setting::where('user_id', '=',$user->id)->first();

		if($this->isPostRequest()) {
			$validator = $this->getSettingsValidator();

			if($validator->passes()) {
				$settings->ui_language = Input::get('ui_language');
				$document_languages = Input::get('document_languages');

				// TODO: I think this whole thing could be done nicer...
				DB::Table('language_user')->where('user_id', '=', $user->id)->delete();

				foreach($document_languages as $document_lang) {
					$foundLanguage = Language::where('language_code', '=', $document_lang)->first();
					if(!is_null($foundLanguage)) {
						$user->languages()->save($foundLanguage);
					}
				}

				App::setLocale($settings->ui_language);
			} else {
				return Redirect::back()->withInput()->withErrors($validator);
			}
		}

		$languages = array();
		$userDocumentLanguages = $user->languages()->get();
		foreach($userDocumentLanguages as $userDocumentLanguage) {
			$languages[$userDocumentLanguage->language_code] = true;
		}
 		return View::make("user/settings")->with('settings', $settings)->with('languages', $languages);

 		// TODO:
 		// Think about whether we need to run an OCRing process in background, if document languages selection changed.
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
	// TODO: Password reminders not working out of the box, since we don't have an "email" column.
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

	public function help($topic = "index")
	{
		if($topic[0] == '.') {
			$topic = "index";
		}

		$topic_path = $this->helpGenerateTopicPath($topic);
		if(is_null($topic_path)) {
			return View::make('404');
		}

		$topic_content = $this->helpGetAndPrepareContent($topic_path);

 		return View::make("user/help")->with(array('topic' => $topic_content));
 	}

 	private function helpGenerateTopicPath($topic) {
		$topic_clean = str_replace('.', '/', $topic);

		$topic_path = app_path() . '/help/' . $topic_clean . '.' . App::getLocale() . '.md';
		$topic_path_alternative = app_path() . '/help/' . $topic_clean . '/index.' . App::getLocale() . '.md';

		if(File::exists($topic_path)) {
			return $topic_path;
		} else if(File::exists($topic_path_alternative)) {
			return $topic_path_alternative;
		} else {
			return null;
		}
 	}

 	private function helpGetAndPrepareContent($path) {
		$content = File::get($path);

		$conent_prepared = preg_replace_callback('/(\@(help|image))((.[A-Za-z0-9]+)+)/', function($match) {
			if(is_null($match) || count($match) < 4) {
				return $match;
			}
			$topic = ltrim($match[3], '.');
			if($match[1] === "@help") {
				return URL::route("user/help", $topic);
			}
			else if($match[1] === "@image") {
				return url('/images/help/' . $topic);
			}
		}, $content);

		$pdown = new Parsedown();
		return $pdown->text($conent_prepared);
 	}

	public function logout() {
		Auth::logout();
		return Redirect::route("user/login");
	}
}
