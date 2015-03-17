<?php

namespace Paperwork\Db;

use Illuminate\Config\Repository;

class PaperworkDbObject {
	protected function getArg($argv, $arg) {
		$ret = null;

		switch($arg) {
			case 'userid':
				$ret = array_key_exists($arg, $argv) ? $argv[$arg] : \Auth::user()->id;
			break;
			case 'id':
				// ID should always be returned as an array, no matter whether it has no values, one value or multiple
				$ret = array_key_exists($arg, $argv) ?
						(is_array($argv[$arg]) ?
							($argv[$arg][0] === \PaperworkDb::DB_ALL_ID ? array() : $argv[$arg])
						: ($argv[$arg] === \PaperworkDb::DB_ALL_ID ? array() : array($argv[$arg])))
					: array();
			break;
			case 'notebookid':
				$ret = array_key_exists($arg, $argv) ? $argv[$arg] : null;
			break;
		}

		return $ret;
	}
}

?>