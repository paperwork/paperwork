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
				->select('notes.id', 'notes.notebook_id', 'notebooks.title as notebook_title', 'notes.title', 'notes.content_preview', 'notes.content', 'notes.created_at', 'notes.updated_at', 'note_user.umask')
				->where('notes.notebook_id', '=', $notebookId)
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
				->select('notes.id', 'notes.notebook_id', 'notebooks.title as notebook_title', 'notes.title', 'notes.content_preview', 'notes.content', 'notes.created_at', 'notes.updated_at', 'note_user.umask')
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
			->join('tag_note', function($join) {
				$join->on('notes.id', '=', 'tag_note.tag_id');
			})
			->select('notes.id', 'notes.notebook_id', 'notebooks.title as notebook_title', 'notes.title', 'notes.content_preview', 'notes.content', 'notes.created_at', 'notes.updated_at', 'note_user.umask')
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
					->select('notes.id', 'notes.notebook_id', 'notebooks.title as notebook_title', 'notes.title', 'notes.content_preview', 'notes.content', 'notes.created_at', 'notes.updated_at', 'note_user.umask')
					->where('notes.notebook_id', '=', $notebookId)
					->where('notes.id', '=', $id)
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
						->select('notes.id', 'notes.notebook_id', 'notebooks.title as notebook_title', 'notes.title', 'notes.content_preview', 'notes.content', 'notes.created_at', 'notes.updated_at', 'note_user.umask')
						->where('notes.id', '=', $id)
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


	public function create()
	{
		$newNotebook = Input::json();

		$notebook = new Notebook();
		$notebook->title = $newNotebook->title;
		$notebook->completed = $newNotebook->completed;
		$notebook->save();

		return Response::json($notebook);
	}

	public function store()
	{
		$updateNotebook = Input::json();

		$notebook = Notebook::find($updateNotebook->id);
		if(is_null($notebook)){
			return Response::json('Notebook not found', 404);
		}
		$notebook->title = $updateNotebook->title;
		$notebook->completed = $updateNotebook->completed;
		$notebook->save();
		return Response::json($notebook);
	}

	public function delete($id = null)
	{
		$notebook = Notebook::find($id);

		if(is_null($notebook))
		{
			return Response::json('Notebook not found', 404);
		}
		$deletedNotebook = $notebook;
		$notebook->delete();
		return Response::json($deletedNotebook);
	}
}

?>