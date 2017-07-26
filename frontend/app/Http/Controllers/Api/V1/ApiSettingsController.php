<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use Paperwork\Helpers\PaperworkHelpersFacade;

class ApiSettingsController extends BaseController {
	public $restful = true;

	public function index()
	{
		return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, array());
	}

	public function show()
	{
		return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, array());
	}

	public function store()
	{
		return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, array());
	}

	public function delete()
	{
		return PaperworkHelpers::apiResponse(PaperworkHelpersFacade::STATUS_SUCCESS, array());
	}
}

?>
