<?php

return array(

	'account_creation_failed' => 'アカウントを作成できませんでした。',
	'account_update_failed' => 'アカウントを更新できませんでした。',
	'invalid_credentials' => '認証情報が正しくありません。',
	'note_version_info' => 'このノートの古いバージョンをプレビューしています。',
	'found_bug' => 'バグがありましたか? <a href="https://github.com/twostairs/paperwork/issues/new" target="_blank" title="問題を報告">Github で報告して下さい! (ただし英語で)</a>',
	'error_message' => 'うわぁぁぁぁ!',
	'onbeforeunload_info' => 'ページから移動するとデータは破棄されます。よろしいですか?',
	'user' => array(
		'settings' => array(
			'language_label' => '言語',
		    'client_label' => 'クライアント',
		    'import_slash_export' => '読み込み/書き出し',
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
			    'evernotexml' => 'Evernote XML として書き出す:',
			    'download_evernotexml' => 'Paperwork からノートを他のアプリに移す場合は、Evernote と互換性のある ENEX ファイルをダウンロードします。'
			)
		)
	)
);
