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
				'ui_language' => 'ユーザーインターフェースの言語',
				'document_languages' => '文書の言語',
				'document_languages_description' => 'ここで選択する言語は、内容の検索が許可されていれば、あなたがアップロードする添付ファイルのテキストを解析する際に適用されます。例えば、添付ファイルがスマートフォンなどで撮った文書の写真ということもありえるわけで、通常、そこに書かれている言語を選択して下さい。',
			),
			'client' => array(
				'qrcode' => 'QR コード',
				'scan' => 'QR コードをモバイルアプリでスキャンして、Paperwork アカウントを自動で構成します。'
			),
			'import' => array(
				'evernotexml' => 'Evernote XML:',
				'upload_evernotexml' => 'Evernote から書き出した XML データをここにアップロードすると、Paperwork に Evernote のノートが読み込まれます。'
			),
			'export' => array(
				'evernotexml' => 'Evernote XML:',
				'download_evernotexml' => 'Paperwork からノートを他のアプリに移す場合は、Evernote と互換性のある ENEX ファイルをダウンロードします。'
			)
		)
	)
);
