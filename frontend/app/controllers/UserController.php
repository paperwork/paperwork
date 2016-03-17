<?php

use \Paperwork\UserRegistrator;

/**
 * Class UserController
 *
 * Provides user login and registration functionality.
 *
 * @todo provide documentation for every action.
 *       Clean up the commented legacy code. We use git for history.
 */
class UserController extends BaseController
{

    private $userRegistrator;
    private $isLdap;

    public function __construct(UserRegistrator $userRegistrator)
    {
        $this->userRegistrator = $userRegistrator;
        $this->isLdap          = PaperworkHelpers::isLdap();
    }

    public function showRegistrationForm()
    {
        return View::make('user.register');
    }

    /**
     * Register action.
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function register()
    {
        $validator = $this->getRegistrationValidator();

        if ($validator->passes()) {
            //only allow users to register who actually have a valid ldap account
            if ($this->isLdap) {
                $creds               = $this->getLoginCredentials();
                $creds['isRegister'] = true;
                if (!Auth::validate($creds)) {
                    return Redirect::back()
                                   ->withInput()
                                   ->withErrors(["password" => [Lang::get('messages.invalid_credentials')]]);
                }
            }
            //if we are using ldap and auto registration, the user will have been created in the Auth::attemp call above
            //thus, we need to just load the user using eloquent and not create a new one.
            if ($this->isLdap && Config::get('ldap.autoRegister')) {
                $user = User::query()
                            ->where('username', Input::get('username'))
                            ->first();
            } else {
                $user =
                  $this->userRegistrator->registerUser(Input::except('_token',
                    'password_confirmation', 'ui_language'),
                    Input::get('ui_language'));
            }
            if ($user && !(Input::get('frominstaller'))) {
                Auth::login($user);

                Session::put('ui_language', Input::get('ui_language'));

                return Redirect::route("/");
            }else if($user) {
                return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, array());
            }

            if(!(Input::get('frominstaller'))) {
                return Redirect::back()
                           ->withErrors(["password" => [Lang::get('messages.account_creation_failed')]]);
            }else{
                return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_ERROR, ["password" => [Lang::get('messages.account_creation_failed')]]);
            }
        } else {
            if(!(Input::get('frominstaller'))) {
                return Redirect::back()->withInput()->withErrors($validator);
            }else{
                return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_ERROR, $validator->failed());
            }
        }
    }

    public function login()
    {
        $validator = $this->getLoginValidator();

        if ($validator->passes()) {
            $credentials = $this->getLoginCredentials();

            if (Auth::attempt($credentials, Input::has('remember_me'))) {
                $settings =
                  Setting::where('user_id', '=', Auth::user()->id)->first();

                Session::put('ui_language', $settings->ui_language);

                return Redirect::route("/");
            }

            return Redirect::back()
                           ->withErrors(["password" => [Lang::get('messages.invalid_credentials')]]);

        } else {
            return Redirect::back()->withInput()->withErrors($validator);
        }
    }

    public function showLoginForm()
    {
        return View::make('user/login');
    }

    protected function isPostRequest()
    {
        return Input::server("REQUEST_METHOD") == "POST";
    }

    protected function getRegistrationValidator()
    {
        $attributes = ["username" => "email address"];
        $validator  = Validator::make(Input::all(), [
          "username"              => $this->isLdap ? "required|unique:users" :
            "required|email|unique:users",
          "password"              => "required|min:5|confirmed",
          "password_confirmation" => "required",
          "firstname"             => "required|name_validator",
          "lastname"              => "required|name_validator"
        ]);

        $validator->setAttributeNames($attributes);

        return $validator;
    }

    protected function getLoginValidator()
    {
        return Validator::make(Input::all(), [
          "username" => $this->isLdap ? "required" : "required|email",
          "password" => "required"
        ]);
    }

    protected function getProfileValidator()
    {
        return Validator::make(Input::all(), [
          "password"  => "min:5|confirmed",
          "firstname" => "required|name_validator",
          "lastname"  => "required|name_validator"
        ]);
    }

    protected function getSettingsValidator()
    {
        return Validator::make(Input::all(), ["ui_language" => "required"]);
    }

    protected function getLoginCredentials()
    {
        return [
          "username" => Input::get("username"),
          "password" => Input::get("password")
        ];
    }

    public function profile()
    {
        $user = User::find(Auth::user()->id);

        if ($this->isPostRequest()) {
            $validator = $this->getProfileValidator();

            if ($validator->passes()) {
                $user->firstname = Input::get('firstname');
                $user->lastname  = Input::get('lastname');

                $passwd = Input::get('password');

                if (!is_null($passwd) && trim($passwd) != "") {
                    $user->password = Input::get('password');
                }

                if (!$user->save()) {
                    return Redirect::back()
                                   ->withErrors(["password" => [Lang::get('messages.account_update_failed')]]);
                }
            } else {
                return Redirect::back()->withInput()->withErrors($validator);
            }
        }

        return View::make("user/profile")->with('user', $user);
    }

    public function settings()
    {
        $user     = User::find(Auth::user()->id);
        $settings = Setting::where('user_id', '=', $user->id)->first();

        if ($this->isPostRequest()) {
            $validator = $this->getSettingsValidator();

            if ($validator->passes()) {
                $settings->ui_language = Input::get('ui_language');
                $document_languages    = Input::get('document_languages');

                // TODO: I think this whole thing could be done nicer...
                DB::Table('language_user')
                  ->where('user_id', '=', $user->id)
                  ->delete();

                if (!is_null($document_languages)) {
                    foreach ($document_languages as $document_lang) {
                        $foundLanguage =
                          Language::where('language_code', '=', $document_lang)
                                  ->first();
                        if (!is_null($foundLanguage)) {
                            $user->languages()->save($foundLanguage);
                        }
                    }
                }

                Session::put('ui_language', $settings->ui_language);
                App::setLocale($settings->ui_language);
            } else {
                return Redirect::back()->withInput()->withErrors($validator);
            }
        }

        $languages             = [];
        $userDocumentLanguages = $user->languages()->get();
        foreach ($userDocumentLanguages as $userDocumentLanguage) {
            $languages[$userDocumentLanguage->language_code] = true;
        }

        return View::make("user/settings")
                   ->with('settings', $settings)
                   ->with('languages', $languages);

        // TODO:
        // Think about whether we need to run an OCRing process in background, if document languages selection changed.
    }

    public function request()
    {
        if (Config::get('paperwork.forgot_password')) {
            if ($this->isPostRequest()) {
                $response = $this->getPasswordRemindResponse();
                if ($this->isInvalidUser($response)) {
                    return Redirect::back()
                                   ->withInput()
                                   ->with("error", Lang::get($response));
                }

                return Redirect::back()->with("status", Lang::get($response));
            }

            return View::make("user/request");
        } else {
            return View::make("404");
        }
    }

    // TODO: Password reminders not working out of the box, since we don't have an "email" column.
    protected function getPasswordRemindResponse()
    {
        return Password::remind(Input::only("username"), function ($message) {
            $message->subject(Lang::get('keywords.password_reset_request'));
        });
    }

    protected function isInvalidUser($response)
    {
        return $response === Password::INVALID_USER;
    }

    public function reset($token)
    {
        if ($this->isPostRequest()) {
            $credentials =
              Input::only("username", "password", "password_confirmation") +
              compact("token");
            $response    = $this->resetPassword($credentials);
            if ($response === Password::PASSWORD_RESET) {
                return Redirect::route("user/profile");
            }

            return Redirect::back()
                           ->withInput()
                           ->with("error", Lang::get($response));
        }

        return View::make("user/reset", compact("token"));
    }

    protected function resetPassword($credentials)
    {
        return Password::reset($credentials, function ($user, $pass) {
            $user->password = Hash::make($pass);
            $user->save();
        });
    }

    public function help($topic = "index")
    {
        if ($topic[0] == '.') {
            $topic = "index";
        }

        $topic_path = $this->helpGenerateTopicPath($topic);

        if (is_null($topic_path)) {
            return View::make('404');
        }

        $topic_content = $this->helpGetAndPrepareContent($topic_path);

        return View::make("user/help")->with(['topic' => $topic_content]);
    }

    private function helpGenerateTopicPath($topic)
    {
        $topic_clean = str_replace('.', '/', $topic);

        $topic_path             =
          app_path() . '/help/' . $topic_clean . '.' . App::getLocale() . '.md';
        $topic_path_alternative =
          app_path() . '/help/' . $topic_clean . '/index.' . App::getLocale() .
          '.md';

        if (File::exists($topic_path)) {
            return $topic_path;
        } elseif (File::exists($topic_path_alternative)) {
            return $topic_path_alternative;
        } else {
            return null;
        }

    }

    private function helpGetAndPrepareContent($path)
    {
        $content = File::get($path);

        $conent_prepared =
          preg_replace_callback('/(\@(help|image))((.[A-Za-z0-9]+)+)/',
            function ($match) {
                if (is_null($match) || count($match) < 4) {
                    return $match;
                }
                $topic = ltrim($match[3], '.');
                if ($match[1] === "@help") {
                    return URL::route("user/help", $topic);
                } elseif ($match[1] === "@image") {
                    return url('/images/help/' . $topic);
                }
            }, $content);

        $pdown = new Parsedown();

        return $pdown->text($conent_prepared);
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();

        return Redirect::route("user/login");
    }

    public function import()
    {
        if ($this->isPostRequest()) {
            if(Input::hasFile('enex')) {
                $notebookNew = with(new \Paperwork\Import\EvernoteImport())->import(Input::file('enex'));
                if($notebookNew[0]) {
                    return Redirect::route("user/settings")
                                   ->withErrors(["enex_file_success" => $notebookNew[1]]);
                }
                else {
                    return Redirect::route("user/settings")
                                   ->withErrors(["enex_file" => $notebookNew[1]]);
                }
            } else {
              return Redirect::route("user/settings")
                            ->withErrors(["enex_file" => "You must choose an ENEX file!"]);
            }
        } else {
          return Redirect::route("user/settings")
                        ->withErrors(["enex_file" => "Nothing selected!"]);
        }
    }

    public function export()
    {
        $file_content = "";
        $noteNumber   = 0;

        $notes = DB::table('notes')
                   ->join('note_user', function ($join) {
                       $join->on('notes.id', '=', 'note_user.note_id')
                            ->where('note_user.user_id', '=', Auth::user()->id)
                            ->where('note_user.umask', '=', '7');
                   })
                   ->join('notebooks', function ($join) {
                       $join->on('notes.notebook_id', '=', 'notebooks.id');
                   })
                   ->join('versions', function ($join) {
                       $join->on('notes.version_id', '=', 'versions.id');
                   })
                   ->select('notes.id', 'notebooks.title as notebook_title',
                     'versions.id as version_id', 'versions.title',
                     'versions.content', 'notes.created_at',
                     'notes.updated_at')
                   ->whereNull('notes.deleted_at')
                   ->whereNull('notebooks.deleted_at')
                   ->get();

        $noteCount = count($notes);
        foreach ($notes as $note) {
            $noteNumber++;
            $versionId = $note->version_id;
            $noteid    = $note->id;

            $noteArray = [
              'title'   => $note->title,
              'content' => $note->content,
              'created' => date('omd', strtotime($note->created_at)) . 'T' .
                           date('His', strtotime($note->created_at)) . 'Z',
              'updated' => date('omd', strtotime($note->updated_at)) . 'T' .
                           date('His', strtotime($note->updated_at)) . 'Z'
            ];

            $attachments = DB::table('attachment_version')
                             ->join('versions',
                               function ($join) use (&$versionId) {
                                   $join->on('attachment_version.version_id',
                                     '=', 'versions.id')
                                        ->where('versions.id', '=', $versionId);
                               })
                             ->join('attachments', function ($join) {
                                 $join->on('attachment_version.attachment_id',
                                   '=', 'attachments.id');
                             })
                             ->select('attachments.id', 'attachments.filename',
                               'attachments.mimetype')
                             ->whereNull('attachments.deleted_at')
                             ->get();

            $tags = DB::table('tags')
                      ->join('tag_note', function ($join) use (&$noteid) {
                          $join->on('tags.id', '=', 'tag_note.tag_id')
                               ->where('tag_note.note_id', '=', $noteid);
                      })
                      ->select('tags.title')
                      ->get();

            foreach ($tags as $tag) {
                $noteArray['tags'][] = ['title' => $tag->title];
            }

            $noteArray['firstname'] = Auth::user()->firstname;
            $noteArray['lastname']  = Auth::user()->lastname;

            foreach ($attachments as $attachment) {
                $attachments_directory =
                  Config::get('paperwork.attachmentsDirectory');
                $path                  =
                  $attachments_directory . "/" . $attachment->id . "/" .
                  $attachment->filename;
                $file_contents         = File::get($path);
                $data                  = base64_encode($file_contents);

                $noteArray['attachments'][] = [
                  'hash'     => md5($file_contents),
                  'filename' => $attachment->filename,
                  'mimetype' => $attachment->mimetype,
                  'encoded'  => $data
                ];
            }

            if ($noteNumber == 1) {
                $noteArray['start'] = 1;
            }

            if ($noteNumber == $noteCount) {
                $noteArray['end'] = 1;
            }

            $file_content .= View::make('user/settings/export_file', $noteArray)
                                 ->render();
        }

        $headers = [
          "Content-Type"        => "application/xml",
          "Content-Disposition" => "attachment; filename=\"export.enex\""
        ];

        return Response::make(rtrim($file_content, "\r\n"), 200, $headers);
    }
}
