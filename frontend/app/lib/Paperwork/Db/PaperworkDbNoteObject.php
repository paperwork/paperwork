<?php

namespace Paperwork\Db;

use Illuminate\Config\Repository;

class PaperworkDbNoteObject extends PaperworkDbObject {

	public function get($argv = array()) {
		$defaultNotesSelect = array('notes.id', 'notes.notebook_id', 'notes.created_at', 'notes.updated_at');
		$defaultVersionsSelect = array('versions.title', 'versions.content_preview', 'versions.content');
		$defaultTagsSelect = array('tags.visibility', 'tags.title');

		$userId = $this->getArg($argv, 'userid');
		$id = $this->getArg($argv, 'id');
		$notebookId = $this->getArg($argv, 'notebookid');

		$data = \Note::with(array(
			'version' => function($query) use(&$defaultVersionsSelect) {
				$query->select($defaultVersionsSelect);
			},
			'tags' => function($query) use(&$defaultTagsSelect) {
				$query->select($defaultTagsSelect);
			}
		))->join('note_user', function($join) use(&$userId) {
				$join->on('note_user.note_id', '=', 'notes.id')
					->where('note_user.user_id', '=', $userId);
		})->select($defaultNotesSelect);

		$idCount = count($id);
		if($idCount > 0) {
			$data->where('notes.id', '=', $argv['id'][0]);
		}
		if($idCount > 1) {
			for($i = 1; $i < $idCount; $i++) {
				$data->orWhere('notes.id', '=', $argv['id'][$i]);
			}
		}
		if(isset($notebookId)) {
			$data->where('notes.notebook_id', '=', $notebookId);
		}
		$data->whereNull('deleted_at');

		return $data->get();
	}

}

?>