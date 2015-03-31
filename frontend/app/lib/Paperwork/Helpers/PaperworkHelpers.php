<?php

namespace Paperwork\Helpers;

use Illuminate\Config\Repository;
use Carbon\Carbon;

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

	public function hasUiLanguage($languageCode) {
		$directories = \File::directories(app_path() . '/lang/');
		$uiLanguages = array();

		foreach($directories as $directory) {
			$dir = basename($directory);
			if($dir === $languageCode) {
				return true;
			}
		}
		return false;

	}

	public function getUiLanguageFromSession() {
	    $setLanguage = \Session::get('ui_language', \Config::get('app.locale'));
	    if(\Config::get('paperwork.userAgentLanguage')) {
	        $uaLanguages = \Agent::languages();
	        foreach($uaLanguages as $uaLanguage) {
	            if(PaperworkHelpers::hasUiLanguage($uaLanguage)) {
	                $setLanguage = $uaLanguage;
	                break;
	            }
	        }
	    }
	    return $setLanguage;
	}

	public function getDocumentLanguages() {
		$languages = \Language::all();
		$documentLanguages = array();

		foreach($languages as $language) {
			$documentLanguages[$language->language_code] = \Lang::get('languages.' . $language->language_code);
		}
		array_multisort($documentLanguages);
		return $documentLanguages;
	}

	public function generateClientQrCodeJson() {
		$data = array(
			'paperwork' => array(
				'user' => array(
					'username' => \Auth::user()->username,
					'firstname' => \Auth::user()->firstname,
					'lastname' => \Auth::user()->lastname,
					'language' => $this->getUiLanguageFromSession()
				),
				'access' => \Config::get('paperwork.access')
			)
		);
		return json_encode($data);
	}

	// Let's abstract the UUID generation process, so we can easily switch levels or even libraries
	public function generateUuid($info) {
		// $info isn't yet used, but could be in future
		return \Uuid::generate(4);
	}

	public function extendAttributes($attributes, $extensions, $info) {
		foreach($extensions as $extension) {
			switch($extension) {
				case 'uuid':
					$attributes['uuid'] = PaperworkHelpers::generateUuid($info);
				break;
			}
		}
		return $attributes;
	}

	public function cleanupMatches($string, $matches, $key = 0) {
		foreach($matches as $match) {
			$pos = strpos($string, $match[$key]);
			if($pos !== false) {
				$string = substr_replace($string, "", $pos, strlen($match[$key]));
			}
		}

		return $string;
	}
    
    public function isLdap()
    {
        return strpos(\Config::get('auth.driver'),'ldap') !== false;
    }

    /**
     * Get last commit hash and latest github hash.
     *
     * @return mixed
     */
    public function getHashes(){
        if (!\Cache::get('paperwork.commitInfo', [null, false])) {
            $resolver = strtolower(substr(PHP_OS, 0, 3)) == 'win' ? 'where.exe' : 'command -v';

            exec("$resolver git", $output);

            if (!empty($output)) {
                $branch = exec("git symbolic-ref --short HEAD");

                $ch = curl_init("https://api.github.com/repos/twostairs/paperwork/git/refs/heads/$branch");

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
                curl_setopt($ch, CURLOPT_USERAGENT, "Colorado");

                $content = curl_exec($ch);

                $jsonFromApi   = array();
                $jsonFromApi[] = json_decode($content);
                $jsonResult    = $jsonFromApi[0];

                if (isset($jsonResult->object->sha)) {
                    $upstreamHeadSha1 = str_replace('"', '', $jsonResult->object->sha);
                } else {
                    $upstreamHeadSha1 = "";
                }

                // Retrieve last commit on install.
                preg_match('/^.*\n/', shell_exec('git log'), $matches);

                $localLatestSha1 = '';

                if (!empty($matches[0]) && stripos($matches[0], 'commit') !== false) {
                    $matchSeparated = explode(' ', $matches[0]);

                    $localLatestSha1 = trim(end($matchSeparated));
                }

                // Check for update daily(UTC).
                $now = Carbon::now();

                $tomorrow = Carbon::parse('tomorrow');

                \Cache::put(
                    'paperwork.commitInfo',
                    [$localLatestSha1, $upstreamHeadSha1],
                    $now->diffInMinutes($tomorrow));
            }

        }

        return \Cache::get('paperwork.commitInfo', [null, false]);
    }
}
