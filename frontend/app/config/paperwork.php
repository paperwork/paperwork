<?php

if(File::exists(storage_path() . "/config/paperwork.json")) {
    $configuration = json_decode(file_get_contents(storage_path() . "/config/paperwork.json"));
}else{
    $configuration = json_decode(file_get_contents(storage_path() . "/config/default_paperwork.json"));
}

return array(
	/*
	|--------------------------------------------------------------------------
	| Access settings
	|--------------------------------------------------------------------------
	|
	| Configure under what DNS entries and ports your Paperwork server is
	| accessible for clients.
	|
	| 'external' defines the settings for access Paperwork from an external
	| network. Example: If you're hosting Paperwork within your LAN
	| (192.168.1.0/24) and use port-forwarding on your router to allow access
	| from outside of your LAN, this configuration tells clients, which
	| host-/domainname and ports to use for reaching Paperwork.
	|
	| 'internal' defines the settings for access Paperwork within your LAN. If
	| your Paperwork installation is reachable from your LAN using the
	| previously defined 'external' settings, you can skip the 'internal'
	| configuration.
        |
        | trustProxy should be false if no extra reverse proxy/load balancer is
        | used, or can be set to array of proxy ip address' to lock it down,
        | or true to allow all.
	|
	*/
	'access' => array(
		'external' => array(
			'dns'	=> 'paperwork.example.com',
			'ports' => array(
				'http'		 => 80,
				'https' 	 => 443,
				'forceHttps' => true,
				'trustProxy' => true

			)
		),
	//  if same as external:
	//	'internal' => null
		'internal' => array(
			'dns' => 'localhost',
			'ports' => array(
				'http'		 => 8888,
				'https' 	 => 8443,
				'forceHttps' => false,
				'trustProxy' => false

			)
		)
	),

	/*
	|--------------------------------------------------------------------------
	| Enable registration
	|--------------------------------------------------------------------------
	|
	| If set to true, user registration is enabled. If set to false
	| no new users will be able to register.
	|
	*/
	'registration' => isset($configuration->registration) ? ($configuration->registration) : true,

	/*
	|--------------------------------------------------------------------------
	| Enable "forgot password" link
	|--------------------------------------------------------------------------
	|
	| If set to true, forgot password link is enabled.
	|
	*/
	'forgot_password' => isset($configuration->forgot_password) ? ($configuration->forgot_password == "true") : true,

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
	'userAgentLanguage' => isset($configuration->userAgentLanguage) ? ($configuration->userAgentLanguage == "true") : false,

	/*
	|--------------------------------------------------------------------------
	| Set which characters are allowed in user first and last names
	|--------------------------------------------------------------------------
	|
	| By default, alpha, hyphen, apostrophe, and space are allowed
	|
	*/

	'nameCharactersAllowed' => array(
			//Alphabetic characters
			'alpha' => true,
			//-
			'hyphen' => true,
			// 0-9
			'num' => false,
			//_
			'underscore' => false,
			//'
			'apostrophe' => true,
			//" " Note, leading and trailing spaces are still trimmed
			'space' => true,
		),

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
	|
	| 'resolution' defines the generated resolution. The higher this is, the
	| more disk space previews will consume.
	|
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
	'showIssueReportingLink' => isset($configuration->showIssueReportingLink) ? ($configuration->showIssueReportingLink == "true") : true,

	/*
	|--------------------------------------------------------------------------
	| Prefix character that describes a public tag
	|--------------------------------------------------------------------------
	|
	| The prefix character that describes a public tag. Example:
	| When a user adds a new tag (e.g. "meeting") without this character, the
	| tag is only visible to him, even when the note is being shared with
	| other users.
	| If the user prefixes the tag with this character (e.g. "+meeting"), this
	| tag will be visible to him and others he shared the note with.
	|
	| The maximum accepted length of this variable is exactly one character.
	|
	| WARNING: This value may only be changed during setup, as long as no
	| tags have been added. If you change this afterwards, things will
	| break.
	|
	*/
	'tagsPublicPrefixCharacter' => '+',
  	'purgeTagList' => ['script'],

  	/*
  	|------------------------------------------------------------------------
  	| Maximum Attachments Per Note
  	|------------------------------------------------------------------------
  	|
  	| The maximum number of attachments that can be attachned to each note.
  	*/
	'maximumAttachmentsPerNote' => isset($configuration->maximumAttachmentsPerNote) ? ($configuration->maximumAttachmentsPerNote) : 10,

	/*
	|-------------------------------------------------------------------------
	| removeEditorButtonsCKEditor
	|-------------------------------------------------------------------------
	|
	| The default plugins included in the basic setup define some buttons that
	| are not needed in a basic editor. The ones to be removed are defined
	| here.
	*/
	'removeEditorButtonsCKEditor' =>
		isset($configuration->removeEditorButtonsCKEditor) ? $configuration->removeEditorButtonsCKEditor : 'Cut,Copy,Paste,Undo,Redo,Anchor,Underline,Strike,Subscript,Superscript',

);
