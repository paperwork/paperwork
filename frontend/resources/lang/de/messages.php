<?php

return array(

	'account_creation_failed' => 'Could not create account.',
	'account_update_failed' => 'Could not update account.',
	'invalid_credentials' => 'Your credentials are invalid.',
	'note_version_info' => 'You are previewing an older version of this note.',
	'found_bug' => 'Found a bug? <a href="https://github.com/twostairs/paperwork/issues/new" target="_blank" title="Submit Issue">Submit it on GitHub!</a>',
	'new_version_available' => 'Found a bug? It seems like you are not running the latest version of Paperwork. Please consider updating before submitting an issue. ',
	'error_version_check' => 'Found a bug? Paperwork cannot check whether your version is the latest. Please make sure you are running the latest version before reporting any issues. ',
	'error_message' => 'Whooops!',
	'onbeforeunload_info' => 'Data will be lost if you leave the page, are you sure?',
	'user' => array(
		'settings' => array(
			'language_label' => 'Language',
			'client_label' => 'Client',
			'import_slash_export' => 'Import/Export',
			'import_error' => 'Der Import war nicht erfolgreich. Die technische Fehlermeldung ist: ',
			'import_success' => 'Die Notizen wurden in folgendes Notizbuch importiert: ',
			'language' => array(
				'ui_language' => 'Benutzeroberflächensprache',
				'document_languages' => 'Dokumentensprachen',
				'document_languages_description' => 'Die Sprachen, welche Sie hier auswählen, werden verwendet, um hochgeladene Anhänge zu analysieren und Ihnen damit eine Suche über den Inhalt dieser zu erlauben. Ein Anhang könnte beispielsweise ein Foto eines Dokuments sein, welches sie mit ihrem Smartphone aufgenommen haben. Wählen Sie die Sprachen aus, in welchen Ihre Dokumente üblicherweise geschrieben werden.',
			),
			'client' => array(
				'qrcode' => 'QR Code',
				'scan' => 'Scannen Sie diesen QR Code mit Ihrer mobilen App um eine Autokonfiguration Ihres Paperwork Accounts durchzuführen.'
			),
			'import' => array(
				'evernotexml' => 'Import einer Evernote XML-Datei:',
				'upload_evernotexml' => 'Laden Sie hier den Evernote XML Export hoch um Ihre Notizen aus Evernot in Paperwork zu importieren.'
			),
			'export' => array(
				'evernotexml' => 'Export als Evernote XML-Datei:',
				'download_evernotexml' => 'Laden Sie eine ENEX kompatible Evernote Datei herunter um Ihre Paperwork Notizen zu exportieren.'
			)
		)
	)
);
