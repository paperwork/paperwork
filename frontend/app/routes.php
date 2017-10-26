<?php

/*
|--------------------------------------------------------------------------
| Taken from JamborJan/paperwork repo
|--------------------------------------------------------------------------
| Set $_SERVER['HTTPS'] depending on HTTP_X_FORWARDED_PROTO
|--------------------------------------------------------------------------
|
| See: https://github.com/twostairs/paperwork/issues/281
| See: https://github.com/JamborJan/paperwork/issues/20
|
*/
if ((array_key_exists('HTTP_X_FORWARDED_PROTO', $_SERVER) ? $_SERVER[ 'HTTP_X_FORWARDED_PROTO'] : 'HTTP_X_FORWARDED_PROTO not set') == "https") {
	$_SERVER['HTTPS'] = "on";
	URL::forceSchema('https');
}

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
App::missing(function ($exception) {
    return Response::view('404', array(), 404);
});

$setupFilePath = "../app/storage/config/setup";

if(File::exists($setupFilePath) && File::get($setupFilePath) < 7) {
    Route::post('setup/setConfig', ["as" => "setup/setConfig", "uses" => "SetupController@setConfiguration"]);
    Route::get('setup/register', function() {
        return View::make('partials/registration-form');
    });
    Route::post('setup/register', ["as" => "setup/register", "uses" => "UserController@register"]);
    Route::get('setup/finish', ["as" => "setup/finish", "uses" => "SetupController@finishSetup"]);

    /* This is not needed for now since it is being handled by check_database_credentials.php */
    //Route::get('setup/installDatabase', ["as" => "setup/installDatabase", "uses" => "SetupController@installDatabase"]);

    /* TODO - Not implemented yet in the controller */
    //Route::get('setup/checkDBStatus', ["as" => "setup/checkDBStatus", "uses" => "SetupController@checkDatabaseStatus"]);

}else{
    Route::get('/login', ["as" => "user/login", "uses" => "UserController@showLoginForm"]);
    Route::post('/login', ["as" => "user/login", "uses" => "UserController@login"]);

    if (Config::get('paperwork.registration') === "true") {
        Route::get("/register", ["as" => "user/register", "uses" => "UserController@showRegistrationForm"]);
        Route::post("/register", ["as" => "user/register", "uses" => "UserController@register"]);
    }

    if (Config::get('paperwork.forgot_password')) {
        Route::any("/request", ["as" => "user/request", "uses" => "UserController@request"]);
        Route::any("/reset/{token}", ["as" => "user/reset", "uses" => "UserController@reset"]);
    }

    //Authorized Users
    Route::group(["before" => "auth"], function () {
        App::setLocale(PaperworkHelpers::getUiLanguageFromSession());
        Route::any("/profile", ["as" => "user/profile", "uses" => "UserController@profile"]);
        Route::any("/settings", ["as" => "user/settings", "uses" => "UserController@settings"]);
        Route::any("/help/{topic?}", ["as" => "user/help", "uses" => "UserController@help"]);
        Route::any("/logout", ["as" => "user/logout", "uses" => "UserController@logout"]);
        Route::any("/settings/export", ["as" => "user/settings/export", "uses" => "UserController@export"]);
        Route::any("/settings/import", ["as" => "user/settings/import", "uses" => "UserController@import"]);
        Route::get('/', ["as" => "/", "uses" => "LibraryController@show"]);

        //Administrators
        Route::group(['prefix' => 'admin', 'before' => ['admin']], function () {
            Route::get('/', ['as' => 'admin/console', 'uses' => 'AdminController@showConsole']);
            Route::post('/users/delete', ['as' => 'admin/users/delete', 'uses' => 'AdminController@deleteOrRestoreUsers']);

            if(Config::get('paperwork.registration') === "admin") {
                Route::get("/register", ["as" => "user/register", "uses" => "UserController@showRegistrationForm"]);
                Route::post("/register", ["as" => "user/register", "uses" => "UserController@register"]);
            }
        });
    });


    Route::get('/templates/{angularTemplate}', function ($angularTemplate) {
        return View::make('templates/' . $angularTemplate);
    });

    Route::group(array('prefix' => 'api/v1', 'before' => 'auth'), function () {
        App::setLocale(PaperworkHelpers::getUiLanguageFromSession());
        // Route::any('notebook/{num?}', 'ApiNotebooksController@index')->where('num','([0-9]*)');
        Route::resource('notebooks', 'ApiNotebooksController');
    	Route::get('/notebooks/{notebookId}/share/{toUserId}/{toUMASK}', 'ApiNotebooksController@share');
        Route::get('/notebooks/{notebookId}/remove-collection', 'ApiNotebooksController@removeNotebookFromCollection');
        Route::resource('tags', 'ApiTagsController');
        Route::resource('notebooks.notes', 'ApiNotesController');
        // I really don't know whether that's a great way to solve this...
        Route::get('/notebooks/{notebookId}/notes/{noteId}/move/{toNotebookId}', 'ApiNotesController@move');
        Route::get('/notebooks/{notebookId}/notes/{noteId}/tag/{toTagId}', 'ApiNotesController@tagNote');
    	Route::get('/notebooks/{notebookId}/notes/{noteId}/share/{toUserId}/{toUMASK}', 'ApiNotesController@share');
        Route::resource('notebooks.notes.versions', 'ApiVersionsController');
        Route::resource('notebooks.notes.versions.attachments', 'ApiAttachmentsController');
        Route::get('/notebooks/{notebookId}/notes/{noteId}/versions/{versionId}/attachments/{attachmentId}/raw', 'ApiAttachmentsController@raw');
        Route::resource('shortcuts', 'ApiShortcutsController');
        Route::get('/tags/{tagId}/{parentTagId}','ApiTagsController@nest');
        Route::resource('tags', 'ApiTagsController');
        Route::resource('i18n', 'ApiI18nController');
        Route::get('/users/notebooks/{notebookId}', 'ApiUsersController@showNotebook');
        Route::resource('users', 'ApiUsersController');
        Route::resource('settings', 'ApiSettingsController');
        Route::resource('calendar', 'ApiCalendarController');
        Route::post('/notebooks/collections', 'ApiNotebooksController@storeCollection');
        Route::post('/notebooks/collections/{collectionId}/edit', 'ApiNotebooksController@updateCollection');

        // Special routes
        Route::get('/tagged/{num}', 'ApiNotesController@tagged');
        Route::get('/search/{query}', 'ApiNotesController@search');
    });

    // Route::any('/api/v1/notebooks/(:num?)', array('as' => 'api.v1.notebooks', 'uses' => 'ApiNotebooksController@index'));
    // Route::any('/api/v1/notes/(:num?)', array('as' => 'api.v1.notes', 'uses' => 'api.v1.notes@index'));
}