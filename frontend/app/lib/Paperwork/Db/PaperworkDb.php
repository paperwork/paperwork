<?php

namespace Paperwork\Db;

use Illuminate\Config\Repository;

class PaperworkDb {

	public function notebook() {
		return new PaperworkDbNotebookObject();
	}

	public function note() {
		return new PaperworkDbNoteObject();
	}

	public function version() {
		return new PaperworkDbVersionObject();
	}

	public function attachment() {
		return new PaperworkDbAttachmentObject();
	}

}

?>