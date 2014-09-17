<?php

class DocumentParserWorker {
	private $job;
	private $jobData;
	private $user;
	private $attachment;
	private $fileUri;
	private $languages;
	private $content;

	public function fire($job, $jobData) {
		if(is_null($jobData) || is_null($job)) {
			Log::error('Document parsing job #' . (is_null($job) ? '???' : $job->getJobId()) . ' is empty. Not doing anything.');
			$this->job->delete();
			return;
		}

		$this->job = $job;
		$this->jobData = $jobData;

		try {
			$this->user = $this->loadUser($this->jobData['user_id']);
			$this->attachment = $this->loadAttachment($this->jobData['document_id']);
		} catch(Exception $e) {
			Log::error($e->getMessage());
			$this->job->delete();
			return;
		}

		$this->fileUri = Config::get('paperwork.attachmentsDirectory') . '/' . $this->attachment->id . '/' . $this->attachment->filename;
		$this->languages = $this->user->languages()->get();
		$this->content = array();

		try {
			foreach($this->languages as $language) {
				$content[$language->language_code] = $this->parseContent($this->fileUri, $language->language_code);
			}
		} catch(Exception $e) {
			Log::error($e->getMessage());
			$this->job->delete();
			return;
		}

		$this->attachment->content = json_encode($content);
		$this->attachment->save();

		if(!$this->runPreviewImagesGenerator($this->attachment->id, $this->attachment->fileextensions, $this->attachment->mimetype, $this->fileUri)) {
			// What to do now?
		} else {
			Log::info('Document parsing job #' . $this->job->getJobId() . ' finished successfully.');
			$this->job->delete();
		}
		return;
	}

	private function loadUser($userId) {
		$user = User::find($userId);

		if(is_null($user)) {
			throw new Exception('Document parsing job #' . $this->job->getJobId() . ' contains an invalid user_id. Aborting.');
		}

		return $user;
	}

	private function loadAttachment($attachmentId) {
		$attachment = Attachment::find($attachmentId);

		if(is_null($attachment)) {
			throw new Exception('Document parsing job #' . $this->job->getJobId() . ' contains an invalid document_id. Aborting.');
		}

		return $attachment;
	}

	private function runPreviewImagesGenerator($attachmentId, $attachmentExtension, $attachmentMimetype, $fileUri) {
		switch($attachmentMimetype) {
			case 'application/pdf':
				return $this->generatePreviewImagesFromPdf($attachmentId, $attachmentExtension, $fileUri);
			case 'image/png':
			case 'image/jpeg':
			case 'image/tiff':
			case 'image/bmp':
			case 'image/gif':
			case 'image/x-icon':
				return $this->generatePreviewImages($attachmentId, $attachmentExtension, $fileUri);
		}
	}

	private function generatePreviewImages($attachmentId, $attachmentExtension, $fileUri) {
		$previewImageConfig = Config::get('paperwork.attachmentsPreview');
		$previewImagePath = $previewImageConfig['directory'] . '/' . $attachmentId . '/' . basename($fileUri, '.' . $attachmentExtension) . '_preview';
		$previewImageVersions = array('.png', '@2x.png');

		$previewImage = new Imagick($fileUri);
		$previewImage->setImageFormat("png");

		try {
			foreach($previewImageVersions as $imageVersion) {
				$previewImage->setResolution(intval($previewImageConfig['resolution']['x']), intval($previewImageConfig['resolution']['y']));
				$previewImage->writeImage($previewImagePath . $imageVersion);
			}
		} catch(Exception $e) {
			Log::info('Document parsing job #' . $this->job->getJobId() . ' received an exception while generating preview images: ' . $e->getMessage());
			return false;
		}
		return true;
	}

	private function generatePreviewImagesFromPdf($attachmentId, $attachmentExtension, $fileUri) {
		return $this->$generatePreviewImage($attachmentId, $attachmentExtension, $fileUri  . '[1]');
	}

	private function parseContent($fileUri, $language) {
		if(!File::exists($fileUri)) {
			throw new Exception('Document parsing job #' . $this->job->getJobId() . ' received a uri to a file that does not seem to exist.');
		}

		$tesseract = new TesseractOCR($fileUri);
		$tesseract->setTempDir(Config::get('paperwork.tesseractTempDirectory'));

		if(isset($language)) {
			$tesseract->setLanguage($language);
		}

		return $tesseract->recognize();
	}
}

?>
