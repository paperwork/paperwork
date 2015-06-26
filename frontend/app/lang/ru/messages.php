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
			'language' => array(
				'ui_language' => 'Язык интерфейса',
				'document_languages' => 'Язык документов',
				'document_languages_description' => 'Выбранный язык будет использоваться при анализе документов, которые вы загружаете. Это позволит осуществлять поиск по их содержимому. Загружаемый документ, например, может быть фотографией реального документа, сделанной на смартфон. Выберите язык, на котором вы чаще всего пишете документы.',
			),
			'client' => array(
				'qrcode' => 'QR код',
				'scan' => 'Отсканируйте QR код при помощи мобильного приложения для автоматической настройки вашего аккаунта.'
			),
			'import' => array(
				'evernotexml' => 'Evernote XML:',
				'upload_evernotexml' => 'Для импорта записей из Evernote загрузите XML-файл экспорта из Evernote.'
			),
			'export' => array(
				'evernotexml' => 'Evernote XML:',
				'download_evernotexml' => 'Чтобы перенести свои данные из Paperwork, скачайте ENEX-совместимый файл.'
			)
		)
	)
);
