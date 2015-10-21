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
				'ui_language' => '用户界面语言',
				'document_languages' => '文档语言',
				'document_languages_description' => '文档语言用于分析以及搜索你上传的附件中的文本内容。',
			),
			'client' => array(
				'qrcode' => '二维码',
				'scan' => '用手机 App 扫描二维码，自动配置你的 Paperwork 账户。'
			),
			'import' => array(
				'evernotexml' => 'Evernote XML文件:',
				'upload_evernotexml' => '上传 Evernote XML 文件，将其导入到 Paperwork 中。'
			),
			'export' => array(
				'evernotexml' => 'Evernote XML文件:',
				'download_evernotexml' => '下载 ENEX 文件，将其导出至 Evernote/印象笔记。'
			)
		)
	)
);
