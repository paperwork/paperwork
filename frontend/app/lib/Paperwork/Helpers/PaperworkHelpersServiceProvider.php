<?php

namespace Paperwork\Helpers;

use Illuminate\Support\ServiceProvider;

class PaperworkHelpersServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('paperworkhelpers', function()
        {
            return new \Paperwork\Helpers\PaperworkHelpers();
        });
    }

}
