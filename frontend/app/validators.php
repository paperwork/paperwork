<?php

/*
|--------------------------------------------------------------------------
| Application Validators
|--------------------------------------------------------------------------
|
| Here you can add custom validators, for those cases not covered 
| by the ones given by Laravel.
|
*/
Validator::extend('alpha_dash_spaces', function($attribute, $value)
{
    return preg_match('/^[\pL0-9\-_\s]+$/u', $value);
});
