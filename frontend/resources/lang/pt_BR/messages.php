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
				'ui_language' => 'Idioma da Interface do Usuário',
				'document_languages' => 'Idiomas do Documento',
				'document_languages_description' => 'Os idiomas que você selecionar aqui serão usados para análise de texto dentro de anexos que você fazer o upload, permitindo a você pesquisar o conteúdo destes. Um anexo pode ser uma foto de um documento que você tirou com seu smartphone, por exemplo. Selecione as línguas que estes documentos são geralmente escritos.',
			),
			'client' => array(
				'qrcode' => 'Código QR',
				'scan' => 'Digitalize o código QR com o seu aplicativo móvel para auto-configurar sua conta no Paperwork.'
			),
			'import' => array(
				'evernotexml' => 'XML do Evernote:',
				'upload_evernotexml' => 'Envie sua exportação XML do Evernote aqui, para importar as suas anotações do Evernote dentro de Paperwork.'
			),
			'export' => array(
				'evernotexml' => 'XML do Evernote:',
				'download_evernotexml' => 'Fazer download de um arquivo ENEX compatível com Evernote para mover as suas anotações de Paperwork.'
			)
		)
	)
);
