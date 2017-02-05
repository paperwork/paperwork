<?php
namespace Paperwork;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Input;

class UserRegistrator
{

    /**
     * This function will create a new user object and return the newly created user object.
     *
     * @param array $userInfo This should have the properties: username, firstname, lastname, password, ui_language
     *
     * @return mixed
     */
    public function registerUser(array $userInfo, $userLanguage)
    {
        $user = \User::create($userInfo);
        //make the first user an admin
        if (\User::all()->count() <= 1) {
            $user->is_admin = 1;
        }

        // Trim trailing whitespace from user first and last name.
        $user->firstname = trim($user->firstname);
        $user->lastname  = trim($user->lastname);

        $user->save();
        \Setting::create([
          'ui_language' => $userLanguage,
          'user_id'     => $user->id
        ]);

        /* Add welcome note to user - create notebook, tag and note */
        //$notebookCreate = Notebook::create(array('title' => Lang::get('notebooks.welcome_notebook_title')));
        $notebookCreate = new \Notebook();

        $notebookCreate->title = Lang::get('notebooks.welcome_notebook_title');
        $notebookCreate->save();

        $notebookCreate->users()
                       ->attach($user->id,
                         ['umask' => \PaperworkHelpers::UMASK_OWNER]);

        //$tagCreate = Tag::create(array('title' => Lang::get('notebooks.welcome_note_tag'), 'visibility' => 0));
        $tagCreate = new \Tag();

        $tagCreate->title      = Lang::get('notebooks.welcome_note_tag');
        $tagCreate->visibility = 0;
        $tagCreate->user_id=$user->id;
        $tagCreate->save();
        //$tagCreate->users()->attach($user->id);

        $noteCreate = new \Note;

        $versionCreate = new \Version([
          'title'           => Lang::get('notebooks.welcome_note_title'),
          'content'         => Lang::get('notebooks.welcome_note_content'),
          'content_preview' => mb_substr(strip_tags(Lang::get('notebooks.welcome_note_content')),
					 0, 255),
	  'user_id'         => $user->id
        ]);

        $versionCreate->save();

        $noteCreate->version()->associate($versionCreate);
        $noteCreate->notebook_id = $notebookCreate->id;
        $noteCreate->save();

        $noteCreate->users()
                   ->attach($user->id,
                     ['umask' => \PaperworkHelpers::UMASK_OWNER]);
        $noteCreate->tags()->sync([$tagCreate->id]);

        return $user;
    }
}
