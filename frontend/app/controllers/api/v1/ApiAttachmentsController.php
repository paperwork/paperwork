<?php

class ApiAttachmentsController extends BaseController {
	use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
	public $restful = true;

	public function index($notebookId, $noteId, $versionId)
	{
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, null);
	}

	public function show($notebookId, $noteId, $versionId, $attachmentId)
	{
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, null);
	}


	public function store($notebookId, $noteId, $versionId)
	{
		if(Input::hasFile('file') && Input::file('file')->isValid()) {
			$fileUpload = Input::file('file');

			// $newAttachment = new Attachment(array(
			// 	'filename' => $fileUpload->getClientOriginalName(),
			// 	'fileextension' => $fileUpload->getClientOriginalExtension(),
			// 	'mimetype' => $fileUpload->getMimeType(),
			// 	'filesize' => $fileUpload->getSize()
			// ));
			// $newAttachment->save();

			// Move file to /app/storage/attachments/$newAttachment->id/$newAttachment->filename


		}


		// return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, $newAttachment);
	}

	public function update($notebookId, $noteId, $versionId, $attachmentId)
	{
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, null);
	}

	public function destroy($notebookId, $noteId, $versionId, $attachmentId)
	{
		return PaperworkHelpers::apiResponse(PaperworkHelpers::STATUS_SUCCESS, null);
	}
}

?>