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

//Custom validator that calls custom settings from app/config/paperwork
//used for first and last names
Validator::extend('name_validator', function($attribute, $value)
{
	$allowed = Config::get('paperwork.nameCharactersAllowed');

	$alpha      = $allowed['alpha']      ? '\pL' : '';
	$hyphen     = $allowed['hyphen']     ? '\-'  : '';
	$num        = $allowed['num']        ? '0-9' : '';
	$underscore = $allowed['underscore'] ? '_'   : '';
	$apostrophe = $allowed['apostrophe'] ? '\''  : '';
	$space      = $allowed['space']      ? ' '   : '';

	$regex = '/^['.$alpha.$hyphen.$num.$underscore.$apostrophe.$space.']+$/u';

    return preg_match($regex, $value);
});
