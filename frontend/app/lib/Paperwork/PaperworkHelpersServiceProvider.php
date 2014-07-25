<?php

namespace Paperwork;

use Illuminate\Support\ServiceProvider;

class PaperworkHelpersServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('paperworkhelpers', function()
        {
            return new PaperworkHelpers;
        });
    }

}

?>