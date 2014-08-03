<?php

class ApiVersionsController extends BaseController {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	public $restful = true;

	public function index($notebookId, $noteId)
	{
		$note = Note::with(
			array(
			'users' => function($query) {
				$query->where('note_user.user_id', '=', Auth::user()->id);
			},
			'notebook' => function($query) use( &$notebookId) {
				$query->where('id', ($notebookId>0 ? '=' : '>'), ($notebookId>0 ? $notebookId : '0'));
			},
			'version' => function($query) {

			}
			)
		)->where('id', '=', $noteId)->whereNull('deleted_at')->first();


		$versionsObject = $note->version()->first();
		$versionsArray = array();

		if(is_null($versionsObject)) {
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
		}

		$versionsArray[] = $versionsObject;

		$tmp = $versionsObject->previous()->first();

		while(!is_null($tmp)) {
			$versionsArray[] = $tmp;
			$tmp = $tmp->previous()->first();
		}

		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $versionsArray);
	}

	public function show($notebookId, $noteId, $versionId)
	{
		$note = Note::with(
			array(
			'users' => function($query) {
				$query->where('note_user.user_id', '=', Auth::user()->id);
			},
			'notebook' => function($query) use( &$notebookId) {
				$query->where('id', ($notebookId>0 ? '=' : '>'), ($notebookId>0 ? $notebookId : '0'));
			},
			'version' => function($query) {

			}
			)
		)->where('id', '=', $noteId)->whereNull('deleted_at')->first();


		$tmp = $note->version()->first();

		if(is_null($tmp)) {
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
		}

		while(!is_null($tmp)) {
			if($tmp->id == $versionId) {
				return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $tmp);
			}
			$tmp = $tmp->previous()->first();
		}

		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
	}


	public function store($notebookId, $noteId)
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

	public function update($notebookId, $noteId, $versionId)
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

	public function destroy($notebookId, $noteId, $versionId)
	{
	}
}

?>