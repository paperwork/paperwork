<?php

namespace Paperwork\Db;

use Illuminate\Support\ServiceProvider;

class PaperworkDbServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('paperworkdb', function()
        {
            return new \Paperwork\Db\PaperworkDb();
        });
    }

}

?>