<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	$access = Config::get('paperwork.access');
	$requestServerName = Request::server ("SERVER_NAME");
	$zones = array('external', 'internal');

    App::singleton('paperworkSession', function(){
        $app = new stdClass;
        $app->currentZone = null;
        return $app;
    });
    $paperworkSession = App::make('paperworkSession');

	foreach($zones as $zone) {
		if(array_key_exists($zone, $access) &&
		is_array($access[$zone]) &&
		array_key_exists('dns', $access[$zone]) &&
		$access[$zone]['dns'] == $requestServerName) {
			if(array_key_exists('ports', $access[$zone]) &&
			is_array($access[$zone]['ports']) &&
			array_key_exists('forceHttps', $access[$zone]['ports'])) {

				if($access[$zone]['ports']['forceHttps'] === true && !Request::secure()) {
			        return Redirect::secure(Request::path());
				}
			}

			$paperworkSession->currentZone = $zone;
		}
	}

	View::share('paperworkSession', $paperworkSession);
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if(Request::header('Authorization') === null) {
		if (Auth::guest())
		{
			if (Request::ajax())
			{
				return Response::make('Unauthorized', 401);
			}
			else
			{
				return Redirect::guest('/login');
			}
		}
	} else {
		return Auth::basic("username");
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic("username");
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('admin', function($route, $request)
{
 if ( ! Auth::user()->isAdmin()) {
	 return App::abort(401, 'You are not authorized.');
 }
});
