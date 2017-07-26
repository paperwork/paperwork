<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use Lang;
use Paperwork\Helpers\PaperworkHelpers;
use Paperwork\Helpers\PaperworkHelpersFacade;

class ApiI18nController extends BaseController {
	public $restful = true;

	public function index()
	{
		$i18n = array(
			'keywords' => Lang::get('keywords'),
			'messages' => Lang::get('messages'),
			'notebooks' => Lang::get('notebooks'),
			'notifications' => Lang::get('notifications'),
			'pagination' => Lang::get('pagination'),
			'reminders' => Lang::get('reminders'),
			'users' => Lang::get('users'),
			'validation' => Lang::get('validation')
		);
		return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, $i18n);
	}

	public function show($translation)
	{
		return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, Lang::get($translation));
	}
}

?>
