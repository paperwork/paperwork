<?php

namespace Paperwork\Db;

use Illuminate\Config\Repository;

class PaperworkDbNotebookObject extends PaperworkDbObject {

	public function get($argv = array()) {
		$defaultNotebooksSelect = array('notebooks.id', 'notebooks.parent_id', 'notebooks.type', 'notebooks.title', 'notebook_user.umask', 'notebooks.created_at', 'notebooks.updated_at');

		$userId = $this->getArg($argv, 'userid');
		$id = $this->getArg($argv, 'id');

		$data = \Notebook::with(array(
			'children' => function($query) use(&$userId, &$defaultNotebooksSelect) {
				$query->join('notebook_user', function($join) use(&$userId) {
					$join->on('notebook_user.notebook_id', '=', 'notebooks.id')
						->where('notebook_user.user_id', '=', $userId);
				})->select($defaultNotebooksSelect)
				->whereNull('deleted_at');
			}
		))->join('notebook_user', function($join) use(&$userId) {
				$join->on('notebook_user.notebook_id', '=', 'notebooks.id')
					->where('notebook_user.user_id', '=', $userId);
		})->select($defaultNotebooksSelect);

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