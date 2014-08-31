<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Blade::setContentTags('[[', ']]');
Blade::setEscapedContentTags('[[[', ']]]');
App::missing(function($exception)
{
    return Response::view('404', array(), 404);
});

Route::any('/login',["as" => "user/login", "uses" => "UserController@login"]);

if(Config::get('paperwork.registration')) {
Route::any("/register",["as" => "user/register","uses" => "UserController@register"]);
}

Route::any("/request",["as" => "user/request","uses" => "UserController@request"]);
Route::any("/reset/{token}",[ "as" => "user/reset","uses" => "UserController@reset"]);

Route::group(["before" => "auth"],function(){
    App::setLocale(PaperworkHelpers::getUiLanguageFromSession());
	Route::any("/profile",["as" => "user/profile","uses" => "UserController@profile"]);
	Route::any("/settings",["as" => "user/settings","uses" => "UserController@settings"]);
	Route::any("/help/{topic?}",["as" => "user/help","uses" => "UserController@help"]);
	Route::any("/logout",["as" => "user/logout","uses" => "UserController@logout"]);

	Route::get('/',["as" => "/","uses" => "LibraryController@show"]);
});


Route::get('/templates/{angularTemplate}', function($angularTemplate) {
	return View::make('templates/' . $angularTemplate);
});

Route::group(array('prefix' => 'api/v1', 'before' => 'auth'), function()
{
    App::setLocale(PaperworkHelpers::getUiLanguageFromSession());
    // Route::any('notebook/{num?}', 'ApiNotebooksController@index')->where('num','([0-9]*)');
    Route::resource('notebooks', 'ApiNotebooksController');
    Route::resource('notebooks.notes', 'ApiNotesController');
    Route::resource('notebooks.notes.versions', 'ApiVersionsController');
    Route::resource('notebooks.notes.versions.attachments', 'ApiAttachmentsController');
    Route::resource('shortcuts', 'ApiShortcutsController');
    Route::resource('tags', 'ApiTagsController');
    Route::resource('i18n', 'ApiI18nController');
    Route::get('/tagged/{num}', 'ApiNotesController@tagIndex');

});

// Route::any('/api/v1/notebooks/(:num?)', array('as' => 'api.v1.notebooks', 'uses' => 'ApiNotebooksController@index'));
// Route::any('/api/v1/notes/(:num?)', array('as' => 'api.v1.notes', 'uses' => 'api.v1.notes@index'));
