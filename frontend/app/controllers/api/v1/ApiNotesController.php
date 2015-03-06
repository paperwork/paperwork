<?php

class ApiNotesController extends BaseController {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	public $restful = true;

	private function getNoteTags($noteId) {
		$note = Note::with('tags')->where('notes.id', '=', $noteId)->first();
		$tags = array();
		foreach($note->tags as $tag) {
			$tags[] = array(
				'id' => $tag->id,
				'title' => $tag->title,
				'visibility' => $tag->visibility
			);
		}
		return $tags;
	}

	private function getNoteVersionsBrief($noteId) {
		$note = Note::with('version')->where('notes.id', '=', $noteId)->first();
		$versionsObject = $note->version()->first();
		if(is_null($versionsObject)) {
			return null;
		}

		$versionsArray = [];
		$tmp = $versionsObject;
		$isLatest = true;

		$versions = array();
		while(!is_null($tmp)) {
			$versionsArray[] = $tmp;

			$versions[] = array(
				'id' => $tmp->id,
				'previous_id' => $tmp->previous_id,
				'next_id' => $tmp->next_id,
				'latest' => $isLatest,
				'timestamp' => $tmp->created_at->getTimestamp()
			);
			$isLatest = false;
			$tmp = $tmp->previous()->first();
		}

		return $versions;
	}

	public function index($notebookId)
	{
		$notes = null;

		$notes = DB::table('notes')
			->join('note_user', function($join) {
				$join->on('notes.id', '=', 'note_user.note_id')
					->where('note_user.user_id', '=', Auth::user()->id);
			})
			->join('notebooks', function($join) {
				$join->on('notes.notebook_id', '=', 'notebooks.id');
			})
			->join('versions', function($join) {
				$join->on('notes.version_id', '=', 'versions.id');
			})
			->select('notes.id', 'notes.notebook_id', 'notebooks.title as notebook_title', 'versions.title', 'versions.content_preview', 'versions.content', 'notes.created_at', 'notes.updated_at', 'note_user.umask')
			->where('notes.notebook_id', ($notebookId>0 ? '=' : '>'), ($notebookId>0 ? $notebookId : '0'))
			->whereNull('notes.deleted_at')
			->whereNull('notebooks.deleted_at')
			->get();

		if(is_null($notes)){
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
		} else {
			foreach($notes as $note) {
				$note->tags = $this->getNoteTags($note->id);
				$note->versions = $this->getNoteVersionsBrief($note->id);
			}
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $notes);
		}
	}

	public function search($queryBase64Encoded)
	{
		// Warning: For some reason the decoded value contains encoded signs?
		// How to fix?
		$searchQuery = urldecode(base64_decode($queryBase64Encoded));

		$notes = DB::table('notes')
			->join('note_user', function($join) {
				$join->on('notes.id', '=', 'note_user.note_id')
					->where('note_user.user_id', '=', Auth::user()->id);
			})
			->join('notebooks', function($join) {
				$join->on('notes.notebook_id', '=', 'notebooks.id');
			})
			->join('versions', function($join) {
				$join->on('notes.version_id', '=', 'versions.id');
			});

		$dateFilter = preg_match_all("/\s*date\:((?:19|20)\d\d)(?:[-\.\/](0[1-9]|1[012])(?:[-\.\/](0[1-9]|[12][0-9]|3[01]))?)?/", $searchQuery, $matches, PREG_SET_ORDER);
		if($dateFilter !== false && $dateFilter > 0) {
			// Only use last date
			$date = end($matches);

			$notes = $notes->where(DB::raw('YEAR(notes.updated_at)'), '=', $date[1]);
			if(isset($date[2])) {
				$notes = $notes->where(DB::raw('MONTH(notes.updated_at)'), '=', sprintf("%02s", $date[2]));
			}
			if(isset($date[3])) {
				$notes = $notes->where(DB::raw('DAY(notes.updated_at)'), '=', sprintf("%02s", $date[3]));
			}

			$searchQuery = PaperworkHelpers::cleanupMatches($searchQuery, $matches);
		}

		$filters = preg_match_all("/\s*(tagid|note(?:book)?id)\:(\d+)/", $searchQuery, $matches, PREG_SET_ORDER);
		if($filters !== false && $filters > 0) {
			foreach($matches as $match) {
				switch($match[1]) {
					case "tagid" :
						$notes = $notes->join('tag_note', function($join) {
							$join->on('notes.id', '=', 'tag_note.note_id');
						})
						->where('tag_note.tag_id', '=', $match[2]);
						break;
					case "noteid" :
						$notes = $notes->where('notes.id', '=', $match[2]);
					case "notebookid" :
						$notes = $notes->where('notes.notebook_id', '=', $match[2]);
					break;
				}
			}

			$searchQuery = PaperworkHelpers::cleanupMatches($searchQuery, $matches);
		}

		$notes = $notes->whereNull('notes.deleted_at')
			->whereNull('notebooks.deleted_at')
			->where(function($query) use( &$searchQuery ) {
				$query->orWhere('versions.title', 'LIKE', '%' . $searchQuery . '%')
						->orWhere('versions.content', 'LIKE', '%' . $searchQuery . '%')
						->orWhere('versions.content_preview', 'LIKE', '%' . $searchQuery . '%');
						// ->orWhere('attachment.content', 'LIKE', '%' . $searchQuery . '%')
			})
			->select('notes.id', 'notes.notebook_id', 'notebooks.title as notebook_title', 'versions.title', 'versions.content_preview', 'versions.content', 'notes.created_at', 'notes.updated_at', 'note_user.umask')
			->distinct()
			// ->toSql();
			->get();
		if(is_null($notes)){
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
		} else {
			foreach($notes as $note) {
				$note->tags = $this->getNoteTags($note->id);
				$note->versions = $this->getNoteVersionsBrief($note->id);
			}
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $notes);
		}
	}

	public function show($notebookId, $id = null)
	{
		if (is_null($id ))
		{
			return index($notebookId);
		}
		else
		{
			$note = null;

			$note = DB::table('notes')
				->join('note_user', function($join) {
					$join->on('notes.id', '=', 'note_user.note_id')
						->where('note_user.user_id', '=', Auth::user()->id);
				})
				->join('notebooks', function($join) {
					$join->on('notes.notebook_id', '=', 'notebooks.id');
				})
				->join('versions', function($join) {
					$join->on('notes.version_id', '=', 'versions.id');
				})
				->select('notes.id', 'notes.notebook_id', 'notebooks.title as notebook_title', 'versions.title', 'versions.content_preview', 'versions.content', 'notes.created_at', 'notes.updated_at', 'note_user.umask')
				->where('notes.notebook_id', ($notebookId>0 ? '=' : '>'), ($notebookId>0 ? $notebookId : '0'))
				->where('notes.id', '=', $id)
				->whereNull('notes.deleted_at')
				->first();
			if(is_null($note)){
				return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
			} else {
				$note->tags = $this->getNoteTags($id);
				$note->versions = $this->getNoteVersionsBrief($id);
				return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $note);
			}
		}
	}


	public function store($notebookId)
	{
		$newNote = Input::json();

		$note = new Note();

		$version = new Version(array('title' => $newNote->get("title"), 'content' => $newNote->get("content"), 'content_preview' => $newNote->get("content_preview")));
		$version->save();
		$note->version()->associate($version);

		$notebook = DB::table('notebooks')
			->join('notebook_user', function($join) {
				$join->on('notebooks.id', '=', 'notebook_user.notebook_id')
					->where('notebook_user.user_id', '=', Auth::user()->id);
			})
			->select('notebooks.id', 'notebooks.type', 'notebooks.title')
			->where('notebooks.id', '=', $notebookId)
			->whereNull('notebooks.deleted_at')
			->first();

		if(is_null($notebook)){
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
		}

		$note->notebook_id = $notebookId;

		$note->save();

        // TODO: Should we inherit the umask from the notebook?
		$note->users()->attach(Auth::user()->id, array('umask' => PaperworkHelpers::UMASK_OWNER));

		$tagIds = ApiTagsController::createOrGetTags($newNote->get('tags'));

		if(!is_null($tagIds)) {
			$note->tags()->sync($tagIds);
		}

		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $note);
	}

	public function update($notebookId, $noteId)
	{
		$validator = Validator::make(Input::all(), [ "title" => "required" ]);
		if(!$validator->passes()) {
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_ERROR, $validator->getMessageBag()->toArray());
		}

		$updateNote = Input::json();

		$note = Note::find($noteId);
		if(is_null($note)){
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array('item'=>'note', 'id'=>$noteId));
		}

		$user = $note->users()->where('users.id', '=', Auth::user()->id)->first();
		if(is_null($user)){
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array('item'=>'user'));
		}

		$previousVersion = $note->version()->first();
		$previousAttachments = $previousVersion->attachments()->get();

		if($previousVersion->title != $updateNote->get("title") || $previousVersion->content != $updateNote->get("content")) {

			// TODO: This is a temporary workaround for the content_preview. We need to check, whether there is content or at least one attachment.
			// If there's no content, parse the attachment and set the result as content_preview. This should somehow be done within the DocumentParser, I guess.
			$version = new Version(array('title' => $updateNote->get("title"), 'content' => $updateNote->get("content"), 'content_preview' => strip_tags($updateNote->get("content"))));
			$version->save();


			$previousVersion->next()->associate($version);
			$previousVersion->save();

			$version->previous()->associate($previousVersion);

			if(!is_null($previousAttachments) && $previousAttachments->count() > 0) {
				foreach($previousAttachments as $previousAttachment) {
					$version->attachments()->attach($previousAttachment);
				}
			}

			$version->save();

			$note->version_id = $version->id;

			$note->save();

		}

		$tagIds = ApiTagsController::createOrGetTags($updateNote->get('tags'));

		if(!is_null($tagIds)) {
			$note->tags()->sync($tagIds);
		}

		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $note);
	}

	private function destroyNote($notebookId, $noteId)
	{
		$note = User::find(Auth::user()->id)->notes()->where('notes.id', '=', $noteId)->whereNull('notes.deleted_at')->first();

		if(is_null($note)){
			// return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array('item'=>'note', 'id'=>$noteId));
			return null;
		}

		$deletedNote = $note;
		$note->delete();
		// return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $deletedNote);
		return $deletedNote;
	}

	public function destroy($notebookId, $noteId)
	{
		$noteIds = explode(PaperworkHelpers::MULTIPLE_REST_RESOURCE_DELIMITER, $noteId);
		$responses = array();
		$status = PaperworkHelpers::STATUS_SUCCESS;

		foreach($noteIds as $singleNoteId) {
			 $tmp = $this->destroyNote($notebookId, $singleNoteId);
			 if(is_null($tmp)) {
			 	$status = PaperworkHelpers::STATUS_ERROR;
			 	$responses[] = array('error_id' => $singleNoteId);
			 } else {
			 	$responses[] = $tmp;
			 }
		}
		return PaperworkHelpers::apiResponse($status, $responses);
	}

	private function moveNote($notebookId, $noteId, $toNotebookId) {
		$note = Note::find($noteId);
		if(is_null($note)){
			// return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array('item'=>'note', 'id'=>$noteId));
			return null;
		}

		$user = $note->users()->where('users.id', '=', Auth::user()->id)->first();
		if(is_null($user)){
			// return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array('item'=>'user'));
			return null;
		}

		$toNotebook = Notebook::find($toNotebookId);
		if(is_null($toNotebook)){
			// return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array('item'=>'notebook', 'id'=>$toNotebookId));
			return null;
		}

		$toNotebookUser = $toNotebook->users()->where('notebook_user.user_id', '=', Auth::user()->id)->first();
		if(is_null($toNotebookUser)){
			// return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array('item'=>'toNotebookUser'));
			return null;
		}

		$note->notebook()->associate($toNotebook);
		$note->save();

		return $note;
	}

	public function move($notebookId, $noteId, $toNotebookId) {
		$noteIds = explode(PaperworkHelpers::MULTIPLE_REST_RESOURCE_DELIMITER, $noteId);
		$responses = array();
		$status = PaperworkHelpers::STATUS_SUCCESS;

		foreach($noteIds as $singleNoteId) {
			 $tmp = $this->moveNote($notebookId, $singleNoteId, $toNotebookId);
			 if(is_null($tmp)) {
			 	$status = PaperworkHelpers::STATUS_ERROR;
			 	$responses[] = array('error_id' => $singleNoteId);
			 } else {
			 	$responses[] = $tmp;
			 }
		}
		return PaperworkHelpers::apiResponse($status, $responses);
	}
}

?>
