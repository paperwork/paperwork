<?php

namespace Paperwork\Db;

use Illuminate\Support\Facades\Facade;

class PaperworkDbFacade extends Facade {
	const DB_ALL_ID = '00000000-0000-0000-0000-000000000000';

    protected static function getFacadeAccessor() { return 'paperworkdb'; }

}

?>