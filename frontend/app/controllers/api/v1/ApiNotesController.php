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
				'title' => $tag->title
				);
		}
		return $tags;
	}


	public function index($notebookId)
	{
		$notes = null;

		if($notebookId>0) {
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
				->where('notes.notebook_id', '=', $notebookId)
				->whereNull('notes.deleted_at')
				->get();
		} else {
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
				->whereNull('notes.deleted_at')
				->get();
		}

		return Response::json($notes);
	}

	public function tagIndex($tagId)
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
			->join('tag_note', function($join) {
				$join->on('notes.id', '=', 'tag_note.tag_id');
			})
			->select('notes.id', 'notes.notebook_id', 'notebooks.title as notebook_title', 'versions.title', 'versions.content_preview', 'versions.content', 'notes.created_at', 'notes.updated_at', 'note_user.umask')
			->get();

		return Response::json($notes);
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

			if($notebookId > 0) {
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
					->where('notes.notebook_id', '=', $notebookId)
					->where('notes.id', '=', $id)
					->whereNull('notes.deleted_at')
					->first();

			} else {
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
						->where('notes.id', '=', $id)
						->whereNull('notes.deleted_at')
						->first();

			}
			if(is_null($note)){
				return Response::json('Notebook not found', 404);
			} else {
				$note->tags = $this->getNoteTags($id);
				return Response::json($note);
			}
		}
	}


	public function store($notebookId)
	{
		$newNote = Input::json();

		$note = new Note();

		$version = new Version(array('title' => $newNote->get("title"), 'content' => $newNote->get("content")));
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

		$note->users()->attach(Auth::user()->id);

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

		$version = new Version(array('title' => $updateNote->get("title"), 'content' => $updateNote->get("content")));
		$version->save();

		$previousVersion = $note->version()->first();

		$previousVersion->next()->associate($version);
		$previousVersion->save();

		$version->previous()->associate($previousVersion);
		$version->save();

		$note->version_id = $version->id;

		$note->save();
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $note);
	}

	public function destroy($notebookId, $noteId = null)
	{
		$note = User::find(Auth::user()->id)->notes()->where('notes.id', '=', $noteId)->whereNull('notes.deleted_at')->first();

		if(is_null($note)){
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array('item'=>'note', 'id'=>$noteId));
		}

		$deletedNote = $note;
		$note->delete();
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $note);
	}
}

?>