<?php

use Illuminate\Support\Facades\Facade;

class PaperworkHelpers extends Facade {
	const STATUS_SUCCESS = 200;
	const STATUS_ERROR = 400;
	const STATUS_NOTFOUND = 404;

	const MULTIPLE_REST_RESOURCE_DELIMITER = ',';

    protected static function getFacadeAccessor() { return 'paperworkhelpers'; }

}

?>