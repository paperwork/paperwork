<?php

// TODO this should be done in middleware
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
}
