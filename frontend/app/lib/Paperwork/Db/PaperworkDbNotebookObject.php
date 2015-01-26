<?php

namespace Paperwork\Db;

use Illuminate\Config\Repository;

class PaperworkDbNotebookObject extends PaperworkDbObject {

	public function get($argv = array()) {
		$defaultSelect = array('notebooks.id', 'notebooks.parent_id', 'notebooks.type', 'notebooks.title', 'notebook_user.umask', 'notebooks.created_at', 'notebooks.updated_at');

		$userId = array_key_exists('userid', $argv) ? $argv['userid'] : \Auth::user()->id;
		$id = array_key_exists('id', $argv) ?
				(is_array($argv['id']) ?
					$argv['id']
				: array($argv['id']))
			: array();

		$data = \Notebook::with(array(
			'children' => function($query) use(&$userId, &$defaultSelect) {
				$query->join('notebook_user', function($join) use(&$userId) {
					$join->on('notebook_user.notebook_id', '=', 'notebooks.id')
						->where('notebook_user.user_id', '=', $userId);
				})->select($defaultSelect)
				->whereNull('deleted_at');
			}
		))->join('notebook_user', function($join) use(&$userId) {
				$join->on('notebook_user.notebook_id', '=', 'notebooks.id')
					->where('notebook_user.user_id', '=', $userId);
		})->select($defaultSelect);

		$idCount = count($id);
		if($idCount > 0) {
			$data->where('notebooks.id', '=', $argv['id'][0]);
		}
		if($idCount > 1) {
			for($i = 1; $i < $idCount; $i++) {
				$data->orWhere('notebooks.id', '=', $argv['id'][$i]);
			}
		}

		$data->whereNull('deleted_at');

		return $data->get();
	}

}

?>