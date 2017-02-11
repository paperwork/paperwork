<?php

Route::get('/templates/{angularTemplate}', function ($angularTemplate) {
    return View::make('templates/' . $angularTemplate);
});
