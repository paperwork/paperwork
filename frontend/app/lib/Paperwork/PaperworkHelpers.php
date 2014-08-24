<?php

namespace Paperwork;

class PaperworkHelpers {

	public function apiResponse($status, $data)	{
		$return = array();

		switch($status) {
			case 200:
				$return['success'] = true;
				$return['response'] = $data;
			break;
			default:
				$return['success'] = false;
				$return['errors'] = $data;
			break;
		}

		return \Response::json($return, $status);
	}

	public function getUiLanguages() {
		$directories = \File::directories(app_path() . '/lang/');
		$uiLanguages = array();

		foreach($directories as $directory) {
			$dir = basename($directory);
			$uiLanguages[$dir] = \Lang::get('languages.' . $dir);
		}
		return $uiLanguages;
	}

	public function getDocumentLanguages() {
		$languages = \Language::all();
		$documentLanguages = array();

		foreach($languages as $language) {
			$documentLanguages[$language->language_code] = \Lang::get('languages.' . $language->language_code);
		}
		return $documentLanguages;
	}

}

?>