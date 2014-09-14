<?php

class ApiAttachmentsController extends BaseController {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	public $restful = true;

	public function index($notebookId, $noteId, $versionId)
	{
		// This is the same source as used in ApiVersionsController@show
		// -> TODO: DRY it.

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
		$version = null;

		if(is_null($tmp)) {
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
		}

		while(!is_null($tmp)) {
			if($tmp->id == $versionId || $versionId == 0) {
				$version = $tmp;
				break;
			}
			$tmp = $tmp->previous()->first();
		}

		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $version->attachments()->whereNull('attachments.deleted_at')->get());
	}

	public function show($notebookId, $noteId, $versionId, $attachmentId)
	{
		// This is the same source as used in ApiVersionsController@show
		// -> TODO: DRY it.

		$note = Note::with(
			array(
			'users' => function($query) {
				$query->where('note_user.user_id', '=', Auth::user()->id);
			},
			'notebook' => function($query) use(&$notebookId) {
				$query->where('id', ($notebookId>0 ? '=' : '>'), ($notebookId>0 ? $notebookId : '0'));
			},
			'version' => function($query) {
			}
			)
		)->where('id', '=', $noteId)->whereNull('deleted_at')->first();

		$tmp = $note->version()->first();
		$version = null;

		if(is_null($tmp)) {
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
		}

		while(!is_null($tmp)) {
			if($tmp->id == $versionId || $versionId == 0) {
				$version = $tmp;
				break;
			}
			$tmp = $tmp->previous()->first();
		}

		$attachment = $version->attachments()->where('attachments.id', '=', $attachmentId)->whereNull('attachments.deleted_at')->first();

		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $attachment);
	}


	public function store($notebookId, $noteId, $versionId)
	{
		if(Input::hasFile('file') && Input::file('file')->isValid()) {
			$fileUpload = Input::file('file');

			$newAttachment = new Attachment(array(
				'filename' => $fileUpload->getClientOriginalName(),
				'fileextension' => $fileUpload->getClientOriginalExtension(),
				'mimetype' => $fileUpload->getMimeType(),
				'filesize' => $fileUpload->getSize()
			));
			$newAttachment->save();

			// Move file to (default) /app/storage/attachments/$newAttachment->id/$newAttachment->filename
			$destinationFolder = Config::get('paperwork.attachmentsDirectory') . '/' . $newAttachment->id;

			if(!File::makeDirectory($destinationFolder, 0700)) {
				$newAttachment->delete();
				return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_ERROR, array('message' => 'Internal Error'));
			}

			// Get Version with versionId
			// This code is pretty much the same as in ApiVersionsController@show
			// -> TODO: DRY it.

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
			$version = null;

			if(is_null($tmp)) {
				$newAttachment->delete();
				File::deleteDirectory($destinationFolder);
				return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array('message' => 'version->first'));
			}

			while(!is_null($tmp)) {
				if($tmp->id == $versionId || $versionId == 0) {
					$version = $tmp;
					break;
				}
				$tmp = $tmp->previous()->first();
			}

			if(is_null($version)) {
				$newAttachment->delete();
				File::deleteDirectory($destinationFolder);
				return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array('message' => 'version'));
			}

			$fileUpload->move($destinationFolder, $fileUpload->getClientOriginalName());
			$version->attachments()->attach($newAttachment);

			// Let's push that parsing job, which analyzes the document, converts it if needed and parses the crap out of it.
			Queue::push('DocumentParserWorker', array('user_id' => Auth::user()->id, 'document_id' => $newAttachment->id));

			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $newAttachment);
		} else {
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_ERROR, array('message' => 'Invalid input'));
		}
	}

	public function update($notebookId, $noteId, $versionId, $attachmentId)
	{
		// We actually don't need this. If the user wants to update an attachment, he'd probably
		// upload the new version and delete the old one, right?
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, null);
	}

	public function destroy($notebookId, $noteId, $versionId, $attachmentId)
	{
		// This is the same source as used in ApiVersionsController@show
		// -> TODO: DRY it.

		$note = Note::with(
			array(
			'users' => function($query) {
				$query->where('note_user.user_id', '=', Auth::user()->id);
			},
			'notebook' => function($query) use(&$notebookId) {
				$query->where('id', ($notebookId>0 ? '=' : '>'), ($notebookId>0 ? $notebookId : '0'));
			},
			'version' => function($query) {
			}
			)
		)->where('id', '=', $noteId)->whereNull('deleted_at')->first();

		$tmp = $note->version()->first();
		$version = null;

		if(is_null($tmp)) {
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
		}

		while(!is_null($tmp)) {
			if($tmp->id == $versionId || $versionId == 0) {
				$version = $tmp;
				break;
			}
			$tmp = $tmp->previous()->first();
		}

		$attachment = $version->attachments()->where('attachments.id', '=', $attachmentId)->whereNull('attachments.deleted_at')->first();

		// $version->attachments()->detach($attachment);
		if(is_null($attachment)) {
			return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_NOTFOUND, array());
		}

		$oldAttachment = $attachment;
		$attachment->delete();

		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $oldAttachment);
	}
}

?>