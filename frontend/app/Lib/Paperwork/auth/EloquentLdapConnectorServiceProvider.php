<?php namespace Paperwork;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Guard;
use \Exception;
class EloquentLdapConnectorServiceProvider extends ServiceProvider
{

    public function boot(){
        $this->app['auth']->extend('eloquentldap', function($app) {
            return new Guard(
                new EloquentLdapAuthenticatedUserProvider($app['hash'],
                    $app['config']['auth.model'],
                    $this->getConfig()),
                $app['session.store']);
        });
    }
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(){}

    public function getConfig()
    {
        if (!$this->app['config']['ldap']){
            throw new Exception('LDAP config not found. Check if app/config/ldap.php exists.');
        }

        return $this->app['config']['ldap'];
    }

}