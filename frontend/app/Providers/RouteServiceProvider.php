<?php namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @return void
	 */
	public function boot()
	{
		parent::boot();

		// TODO
        // Route::filter('auth.basic', function()
        // {
        // 	return Auth::basic("username");
        // });
		//
        // Route::filter('admin', function($route, $request)
        // {
        //  if ( ! Auth::user()->isAdmin()) {
        // 	 return App::abort(401, 'You are not authorized.');
        //  }
        // });
	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router)
	{
        $this->mapWebRoutes();

		$this->mapApiRoutes();

		$this->mapAngularTemplates();
	}


    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => ['api', 'auth'],
            'namespace' => $this->namespace,
            'prefix' => 'api/v1',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }

	/**
	 * Define the Angular templates helper.
	 *
	 * @return void
	 */
	protected function mapAngularTemplates()
	{
		Route::group([
			'namespace' => $this->namespace,
		], function($router) {
			require base_path('routes/templates.php');
		});
	}

}
