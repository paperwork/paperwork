<?php

return array(

	'account_creation_failed' => 'Impossible de créer un compte.',
	'account_update_failed' => 'Impossible de mettre à jour le compte.',
	'invalid_credentials' => 'Vos informations d\'identification ne sont pas valides.',
	'note_version_info' => 'Vous affichez l\'aperçu d\'une ancienne version de cette note.',
	'found_bug' => 'Vous avez trouvé un bug ? <a href="https://github.com/twostairs/paperwork/issues/new" target="_blank" title="Soumettre un problème">Soumettez le sur GitHub!</a>',
	'error_message' => 'Whooops!',
	'onbeforeunload_info' => 'Les données vont être perdu si vous quittez la page, êtes vous sûre ?',
	'user' => array(
		'settings' => array(
			'language' => array(
				'language' => 'Langage',
				'ui_language' => 'Langage de l\'interface utilisateur',
				'document_languages' => 'Langages des documents',
				'document_languages_description' => 'The languages you select here will be used for parsing text within attachments you upload, allowing you to search for the content of these. An attachment could be a photo of a document you took with your smartphone, for example. Select the languages these documents are usually written in.',
			),
			'client' => array(
				'qrcode' => 'QR Code',
				'scan' => 'Scannez ce QR code avec votre application mobile pour configurer automatiquement votre compte Paperwork.'
			),
			'import' => array(
				'evernotexml' => 'Evernote XML :',
				'upload_evernotexml' => 'Importez votre export Evernote XML ici, pour importer vos notes Evernote dans Paperwork.'
			)
		)
	)
);
