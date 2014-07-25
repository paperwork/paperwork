<?php

namespace Paperwork;

class PaperworkHelpers {

	public function apiResponse($status, $data)	{
		$return = array();
		$returnCode = 400;

		switch($status) {
			case 0:
				$return['success'] = true;
				$return['response'] = $data;
				$returnCode = 200;
			break;
			case 1:
				$return['success'] = false;
				$return['errors'] = $data;
				$returnCode = 400;
			break;
		}

		return \Response::json($return, $returnCode);
	}

}

?>