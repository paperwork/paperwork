<?php

return array(

	'account_creation_failed' => '无法创建账户',
	'account_update_failed' => '无法更新账户信息',
	'invalid_credentials' => '输入的登录信息无效',
	'note_version_info' => '你正在查看当前笔记的旧版本',
	'found_bug' => '发现BUG？<a href="https://github.com/twostairs/paperwork/issues/new" target="_blank" title="Submit Issue">到 GitHub 提交 Issue!</a>',
	'new_version_available' => '发现 BUG？当前运行的不是最新版 Paperwork. 请在提交 Issue 前更新至最新版',
	'error_version_check' => '发现BUG？ Paperwork 无法检测当前是否为最新版，请在提交 Issue 前确保已经更新至最新版', 
	'error_message' => 'Whooops!',
	'onbeforeunload_info' => '离开当前页面将会丢失当前数据，确认离开？',
	'user' => array(
		'settings' => array(
			'language_label' => '语言',
			'client_label' => '客户端',
			'import_slash_export' => '导入/导出',
			'language' => array(
				'ui_language' => '用户界面语言',
				'document_languages' => '文档语言',
				'document_languages_description' => '文档语言用于分析以及搜索你上传的附件中的文本内容。',
			),
			'client' => array(
				'qrcode' => '二维码',
				'scan' => '使用手机扫描二维码自动配置账户'
			),
			'import' => array(
				'evernotexml' => 'Evernote/印象笔记 XML:',
				'upload_evernotexml' => '上传你的 Evernote/印象笔记 XML 文件，并导入至 Paperwork。'
			),
			'export' => array(
				'evernotexml' => '导出为 Evernote/印象笔记 XML:',
				'download_evernotexml' => '下载 ENEX 文件，可用于导出至 Evernote/印象笔记。'
			)
		)
	)
);
