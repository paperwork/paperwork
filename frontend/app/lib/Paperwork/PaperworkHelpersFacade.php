<?php

use Illuminate\Support\Facades\Facade;

class PaperworkHelpers extends Facade {
	const STATUS_SUCCESS = 0;
	const STATUS_ERROR = 1;

    protected static function getFacadeAccessor() { return 'paperworkhelpers'; }

}

?>