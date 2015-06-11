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
				'ui_language' => 'Idioma de la interfaz de usuario',
				'document_languages' => 'Idiomas del documento',
				'document_languages_description' => 'Los idiomas que seleccione aquí serán los que se utilizarán en los análisis de texto de los archivos adjuntos que suba, lo que le permitirá buscar contenido en esos idiomas. Un documento adjunto puede ser, por ejemplo, una foto de un documento tomada con un teléfono inteligente.',
			),
			'client' => array(
				'qrcode' => 'Código QR',
				'scan' => 'Escanear este código QR con la aplicación de su teléfono para configurar automáticamente su cuenta de Paperwork.'
			),
			'import' => array(
				'evernotexml' => 'XML de Evernote:',
				'upload_evernotexml' => 'Suba el archivo XML de Evernote aquí para importar las notas de dicho servicio a Paperworks.'
			),
			'export' => array(
				'evernotexml' => 'XML de Evernote:',
				'download_evernotexml' => 'Descargue un archivo ENEX compatible con Evernote para exportar las notas de Paperwork a dicho servicio.'
			)
		)
	)
);
