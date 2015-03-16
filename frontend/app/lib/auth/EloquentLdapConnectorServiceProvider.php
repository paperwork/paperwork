<?php namespace Paperwork;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Guard;
use \Exception;
class EloquentLdapConnectorServiceProvider extends ServiceProvider {

    public function __construct($app){
        $this->app = $app;
    }
    
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    public function boot(){
        Auth::extend('eloquentldap', function($app) {
            return new Guard(new EloquentLdapAuthenticatedUserProvider($app['hash'],$app['config']['auth.model']), $app['session']);
        });
    }
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Auth::extend('eloquentldap', function($app) {
            $provider =  new EloquentLdapAuthenticatedUserProvider($app['hash'],$app['config']['auth.model']);
            return new Guard($provider, $app['session']);
        });
    }

    public function getConfig()
    {
        if(!$this->app['config']['ldap']) throw new Exception('LDAP config not found. Check if app/config/ldap.php exists.');

        return $this->app['config']['ldap'];
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('auth');
    }
}