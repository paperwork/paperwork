<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Enable registration
	|--------------------------------------------------------------------------
	|
	| If set to true, user registration is enabled. If set to false
	| no new users will be able to register.
	|
	*/
	'registration' => true,

	/*
	|--------------------------------------------------------------------------
	| Automatically detect language through user agent
	|--------------------------------------------------------------------------
	|
	| If set to true, Paperwork will automatically set the user-interface
	| language depending on the user-agent languages. If set to false, the
	| language set in app.php -> locale will be used.
	|
	*/
	'userAgentLanguage' => false,

	/*
	|--------------------------------------------------------------------------
	| Directory where uploaded files are being saved in
	|--------------------------------------------------------------------------
	|
	| The directory for saving uploaded files in.
	|
	*/
	'attachmentsDirectory' => storage_path() . '/attachments',

	/*
	|--------------------------------------------------------------------------
	| Attachments preview settings
	|--------------------------------------------------------------------------
	|
	| Settings regarding attachments preview generation.
	| 'resolution' defines the generated resolution. The higher this is, the
	| more disk space previews will consume.
	| 'directory' defines the directory in which to store the previews.
	| This usually is the same as 'attachmentsDirectory'.
	|
	*/
	'attachmentsPreview' => array(
		'resolution' => array(
			'x' => 500,
			'y' => 500
		),
		'directory' => storage_path() . '/attachments'
	),

	/*
	|--------------------------------------------------------------------------
	| Tesseract temporary directory
	|--------------------------------------------------------------------------
	|
	| The directory where temporary tesseract files are being store into.
	|
	*/
	'tesseractTempDirectory' => storage_path() . '/cache',

	/*
	|--------------------------------------------------------------------------
	| Show issue reporting link
	|--------------------------------------------------------------------------
	|
	| If set to true, a link for reporting issues is being displayed.
	|
	*/
	'showIssueReportingLink' => true,
);
