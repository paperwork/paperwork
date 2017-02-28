<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Config;
use Validator;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
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
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
