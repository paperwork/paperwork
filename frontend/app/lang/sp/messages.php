<?php

return array(

	'account_creation_failed' => 'No se pudo crear la cuenta.',
	'account_update_failed' => 'No se pudo actualizar la cuenta.',
	'invalid_credentials' => 'Sus credenciales son inválidas.',
	'note_version_info' => 'Está previsualizando una versión antigua de esta nota.',
	'found_bug' => '¿Ha encontrado un fallo? <a href="https://github.com/twostairs/paperwork/issues/new" target="_blank" title="Publicar fallo">Publíquelo en GitHub!</a>',
	'error_message' => 'Vaya!',
	'onbeforeunload_info' => 'Los datos se perderán si sale de la página, ¿está seguro?',
	'user' => array(
		'settings' => array(
			'language' => array(
				'ui_language' => 'Idioma de la Interfaz de Usuario',
				'document_languages' => 'Idiomas del Documento',
				'document_languages_description' => 'Los idiomas que seleccione aquí serán utilizados para detectar el texto de los archivos adjuntos que usted suba, permitiéndole buscar entre el condenido de los mismos. Un archivo adjunto puede ser una fotografía de un documento que haya tomado con su smartphone, por ejemplo. Seleccione los idiomas en los que habitualmente estarán escritos estos documentos.',
			),
			'client' => array(
				'qrcode' => 'Código QR',
				'scan' => 'Escanee este código QR desde su aplicación móvil para configurar automáticamente su cuenta de Paperwork.'
			),
			'import' => array(
				'evernotexml' => 'XML de Evernote:',
				'upload_evernotexml' => 'Suba su XML exportado de Evernote aquí para importar sus notas de Evernote a Paperwork.'
			),
			'export' => array(
			    'evernotexml' => 'Exportar como XML de Evernote:',
			    'download_evernotexml' => 'Descargue un archivo ENEX compatible con Evernote para mover sus notas desde Paperwork. '
			)
		)
	)
);
