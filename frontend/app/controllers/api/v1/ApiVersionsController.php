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
			if($tmp->id == $versionId || $versionId == 0) {
				return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $tmp);
			}
			$tmp = $tmp->previous()->first();
		}

		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
	}


	// public function store($notebookId, $noteId)
	// {
	// 	// Is being done through ApiNotesController
	// }

	// public function update($notebookId, $noteId, $versionId)
	// {
	// 	// Not sure yet. I don't believe it's a good idea to allow updating of versions.
	// }

	// public function destroy($notebookId, $noteId, $versionId)
	// {
	// 	// This doesn't make any sense atm.
	// }
}

?>