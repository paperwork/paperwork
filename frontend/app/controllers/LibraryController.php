<?php

class LibraryController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function show()
	{
		//TODO: Not yet implemented
		/* Check if the Welcome one is not deleted */
        //$userId = Auth::user()->id;
        //$welcomeNote = Note::with(
        //    array(
                /*'users' => function($query) {
                    $query->where('id', '=', Auth::user()->id);
                },*/
        /*        'version' => function($query) {
                    $query->whereNull('previous_id');
                }
            )
        )->join('note_user', function($join) use(&$userId) {
            $join->on('notes.id', '=', 'note_user.note_id')->where('note_user.user_id', '=', $userId);
        })
        ->orderBy('notes.created_at')
        ->whereNull('notes.deleted_at')
        ->first();
            
        if(is_null($welcomeNote)) {
            $welcomeNoteArray = array('welcomeNoteSaved' => 0);
        }else{
            if($welcomeNote->version->title === Lang::get('notebooks.welcome_note_title')) {
                $welcomeNoteArray = array('welcomeNoteSaved' => 1);
            }else{
                $welcomeNoteArray = array('welcomeNoteSaved' => 0);
            }
        }*/
        return View::make('main');
        //return View::make('main', $welcomeNoteArray);
    }

}
