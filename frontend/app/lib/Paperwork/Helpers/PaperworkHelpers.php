<?php

namespace Paperwork\Helpers;

use Config;
use DOMDocument;
use Illuminate\Config\Repository;
use Carbon\Carbon;

class PaperworkHelpers {

	/**
     * Clears html on note save
     * @param $html
     *
     * @return bool|mixed|string
     */
	public static function purgeHtml($html)
	{
		if (!trim($html)) {
			return '';
		}

		$html = mb_convert_encoding($html, 'UTF-8', mb_detect_encoding($html));
		$html = mb_convert_encoding($html, 'html-entities', 'utf-8');

		$dom                     = new DOMDocument('1.0', 'UTF-8');
		$dom->substituteEntities = true;

		// Suppress warnings about malformed html.
		$previous_value = libxml_use_internal_errors(true);

		$dom->loadHTML($html);

		libxml_clear_errors();
		libxml_use_internal_errors($previous_value);

		// @formatter:off
		$tags_to_remove = Config::get('paperwork.purgeTagList', ['script']);
		// @formatter:on

		$remove = [];

		foreach ($tags_to_remove as $removal_target) {
			$sentenced = $dom->getElementsByTagName($removal_target);

			foreach ($sentenced as $item) {
				$remove[] = $item;
			}
		}

		foreach ($remove as $sentenced_item) {
			$sentenced_item->parentNode->removeChild($sentenced_item);
		}

		// Convert dom object back to html.
		$html = '';

		$body_node = $dom->getElementsByTagName('body')->item(0);

		foreach ($body_node->childNodes as $child) {
			$html .= $dom->saveXML($child);
		}

		return $html;
	}

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
        $cachedInfo = !\Cache::get('paperwork.commitInfo', [null, false]);

        if (!$cachedInfo[0] && !$cachedInfo[1]) {
            $resolver = strtolower(substr(PHP_OS, 0, 3)) == 'win' ? 'where.exe' : 'command -v';
            $gitOutput = "";
            exec("$resolver git", $gitOutput);

            if (!empty($gitOutput) && (function_exists('curl_init') !== false)) {
                $branch = exec("git symbolic-ref --short HEAD");

                $ch = curl_init("https://api.github.com/repos/twostairs/paperwork/git/refs/heads/$branch");

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
                curl_setopt($ch, CURLOPT_USERAGENT, "Colorado");

                $content = curl_exec($ch);
                
                /* Check if user is in a branch not found in Paperwork's source code */
                $info = curl_getinfo($ch);
                if($info["http_code"] != 200) {
                    return [0, 0, 0, 0];
                }

                $jsonFromApi   = array();
                $jsonFromApi[] = json_decode($content);
                $jsonResult    = $jsonFromApi[0];

                if (isset($jsonResult->object->sha)) {
                    $upstreamHeadSha1 = str_replace('"', '', $jsonResult->object->sha);
                    $commit_url = isset($jsonResult->object->url) ? $jsonResult->object->url : "";
                } else {
                    $upstreamHeadSha1 = "";
                    $commit_url = "";
                }

                // Retrieve last commit on install.
                preg_match('/^.*\n/', shell_exec('git log'), $matches);

                $localLatestSha1 = '';

                if (!empty($matches[0]) && stripos($matches[0], 'commit') !== false) {
                    $matchSeparated = explode(' ', $matches[0]);

                    $localLatestSha1 = trim(end($matchSeparated));
                }
                
                $localTimestamp = "";
                $upstreamTimestamp = ""; 
                
                // If user is not running latest official source code, check if last commit installed is earlier than last on git 
                if($localLatestSha1 !== $upstreamHeadSha1){
                    $localTimestamp = exec("git show -s --format=%ci $localLatestSha1");
                    curl_setopt($ch, CURLOPT_URL, $commit_url);
                    $contentTimestamp = curl_exec($ch);
                    $jsonFromApiTimestamp = [];
                    $jsonFromApiTimestamp[] = json_decode($contentTimestamp);
                    $jsonResultTimestamp = $jsonFromApiTimestamp[0];
                    $upstreamTimestamp = isset($jsonResultTimestamp->committer->date) ? $jsonResultTimestamp->committer->date : 0;
                }

                // Check for update daily(UTC).
                $now = Carbon::now();

                $tomorrow = Carbon::parse('tomorrow');

                \Cache::put(
                    'paperwork.commitInfo',
                    [$localLatestSha1, $upstreamHeadSha1, $localTimestamp, $upstreamTimestamp],
                    $now->diffInMinutes($tomorrow));
            }

        }

        return \Cache::get('paperwork.commitInfo', [null, false]);
    }
}
