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

if (File::exists(storage_path() . "/config/setup") && File::get(storage_path() . "/config/setup") < 7) {
    Route::post('setup/setConfig', ["as" => "setup/setConfig", "uses" => "SetupController@setConfiguration"]);
    Route::get('setup/register', function () {
        return View::make('partials/registration-form', array('ajax' => true));
    });
    Route::post('setup/register', ["as" => "setup/register", "uses" => "UserController@register"]);
    Route::get('setup/finish', ["as" => "setup/finish", "uses" => "SetupController@finishSetup"]);
    Route::get('setup/checkDBStatus', ["as" => "setup/checkDBStatus", "uses" => "SetupController@checkDatabaseStatus"]);
    Route::get('setup/installDatabase', ["as" => "setup/installDatabase", "uses" => "SetupController@installDatabase"]);
} else {
    Route::get('/login', ["as" => "user/login", "uses" => "UserController@showLoginForm"]);
    Route::post('/login', ["as" => "user/login", "uses" => "UserController@login"]);

    if (Config::get('paperwork.registration')) {
        Route::get("/register", ["as" => "user/register", "uses" => "UserController@showRegistrationForm"]);
        Route::post("/register", ["as" => "user/register", "uses" => "UserController@register"]);
    }

    if (Config::get('paperwork.forgot_password')) {
        Route::any("/request", ["as" => "user/request", "uses" => "UserController@request"]);
        Route::any("/reset/{token}", ["as" => "user/reset", "uses" => "UserController@reset"]);
    }

    //Authorized Users
    Route::group(["middleware" => "auth"], function () {
        App::setLocale(PaperworkHelpers::getUiLanguageFromSession());
        Route::any("/profile", ["as" => "user/profile", "uses" => "UserController@profile"]);
        Route::any("/settings", ["as" => "user/settings", "uses" => "UserController@settings"]);
        Route::any("/help/{topic?}", ["as" => "user/help", "uses" => "UserController@help"]);
        Route::any("/logout", ["as" => "user/logout", "uses" => "UserController@logout"]);
        Route::any("/settings/export", ["as" => "user/settings/export", "uses" => "UserController@export"]);
        Route::any("/settings/import", ["as" => "user/settings/import", "uses" => "UserController@import"]);
        Route::get('/', ["as" => "/", "uses" => "LibraryController@show"]);

        //Administrators
        Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
            Route::get('/', ['as' => 'admin/console', 'uses' => 'AdminController@showConsole']);
            Route::post('/users/delete', ['as' => 'admin/users/delete', 'uses' => 'AdminController@deleteOrRestoreUsers']);
        });
    });


    Route::get('/templates/{angularTemplate}', function ($angularTemplate) {
        return View::make('templates/' . $angularTemplate);
    });

    Route::group(array('prefix' => 'api/v1', 'middleware' => 'auth'), function () {
        App::setLocale(PaperworkHelpers::getUiLanguageFromSession());
        // Route::any('notebook/{num?}', 'ApiNotebooksController@index')->where('num','([0-9]*)');
        Route::resource('notebooks', 'Api\V1\ApiNotebooksController');
        Route::get('/notebooks/{notebookId}/share/{toUserId}/{toUMASK}', 'Api\V1\ApiNotebooksController@share');
        Route::get('/notebooks/{notebookId}/remove-collection', 'Api\V1\ApiNotebooksController@removeNotebookFromCollection');
        Route::resource('tags', 'Api\V1\ApiTagsController');
        Route::resource('notebooks.notes', 'Api\V1\ApiNotesController');
        // I really don't know whether that's a great way to solve this...
        Route::get('/notebooks/{notebookId}/notes/{noteId}/move/{toNotebookId}', 'Api\V1\ApiNotesController@move');
        Route::get('/notebooks/{notebookId}/notes/{noteId}/tag/{toTagId}', 'Api\V1\ApiNotesController@tagNote');
        Route::get('/notebooks/{notebookId}/notes/{noteId}/share/{toUserId}/{toUMASK}', 'Api\V1\ApiNotesController@share');
        Route::resource('notebooks.notes.versions', 'Api\V1\ApiVersionsController');
        Route::resource('notebooks.notes.versions.attachments', 'Api\V1\ApiAttachmentsController');
        Route::get('/notebooks/{notebookId}/notes/{noteId}/versions/{versionId}/attachments/{attachmentId}/raw', 'Api\V1\ApiAttachmentsController@raw');
        Route::resource('shortcuts', 'Api\V1\ApiShortcutsController');
        Route::get('/tags/{tagId}/{parentTagId}', 'Api\V1\ApiTagsController@nest');
        Route::resource('tags', 'Api\V1\ApiTagsController');
        Route::resource('i18n', 'Api\V1\ApiI18nController');
        Route::get('/users/notebooks/{notebookId}', 'Api\V1\ApiUsersController@showNotebook');
        Route::resource('users', 'Api\V1\ApiUsersController');
        Route::resource('settings', 'Api\V1\ApiSettingsController');
        Route::resource('calendar', 'Api\V1\ApiCalendarController');
        Route::post('/notebooks/collections', 'Api\V1\ApiNotebooksController@storeCollection');
        Route::post('/notebooks/collections/{collectionId}/edit', 'Api\V1\ApiNotebooksController@updateCollection');

        // Special routes
        Route::get('/tagged/{num}', 'Api\V1\ApiNotesController@tagged');
        Route::get('/search/{query}', 'Api\V1\ApiNotesController@search');
    });

    // Route::any('/api/v1/notebooks/(:num?)', array('as' => 'api.v1.notebooks', 'uses' => 'ApiNotebooksController@index'));
    // Route::any('/api/v1/notes/(:num?)', array('as' => 'api.v1.notes', 'uses' => 'api.v1.notes@index'));

    Route::any('{catchall}', function () {
        return Response::view('404', array(), 404);
    })->where('catchall', '.*');
}
