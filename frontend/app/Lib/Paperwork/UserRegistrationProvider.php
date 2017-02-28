<?php namespace Paperwork;

use Illuminate\Support\ServiceProvider;

class UserRegistrationProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("UserRegistrator", function () {
            return new UserRegistrator();
        });
    }

}
