<?php

return array(

	'account_creation_failed' => 'Could not create account.',
	'account_update_failed' => 'Could not update account.',
	'invalid_credentials' => 'Your credentials are invalid.',
	'note_version_info' => 'You are previewing an older version of this note.',
	'found_bug' => 'Found a bug? <a href="https://github.com/twostairs/paperwork/issues/new" target="_blank" title="Submit Issue">Submit it on GitHub!</a>',
	'new_version_available' => 'Found a bug? It seems like you are not running the latest version of Paperwork. Please consider updating before submitting an issue. ',
	'error_version_check' => 'Found a bug? Paperwork cannot connect to Github to check the latest version. A solution to this can be installling the curl PHP extension. This is not mandatory, however before reporting any issues, please make sure that you are using the latest version.  ',
	'found_bug_newer_commit_installed' => 'Found a bug? It seems like you have done some changes to the Paperwork code. Before opening a new issue, please check if this issue is present in the official source code available in our Github repository. ',
	'error_message' => 'Whooops!',
	'dblclick_dismiss' => 'Double click to dismiss.',
	'onbeforeunload_info' => 'Data will be lost if you leave the page, are you sure?',
	'nothing_here' => 'Nothing here',
	'no_notes_in_notebook' => 'Paperwork did not find any notes in this notebook. Go on and create a new one from the File menu. ',
	'user' => array(
		'settings' => array(
			'language_label' => 'Language',
			'client_label' => 'Client',
			'about_label' => 'About',
			'import_slash_export' => 'Import/Export',
			'import_error' => 'The import failed. The technical error message is: ',
			'import_success' => 'Your notes have been imported into the notebook: ',
			'language' => array(
				'ui_language' => 'User Interface Language',
				'document_languages' => 'Document Languages',
				'document_languages_description' => 'The languages you select here will be used for parsing text within attachments you upload, allowing you to search for the content of these. An attachment could be a photo of a document you took with your smartphone, for example. Select the languages these documents are usually written in.',
			),
			'client' => array(
				'qrcode' => 'QR Code',
				'scan' => 'Scan this QR code with your mobile app to auto-configure your Paperwork account.'
			),
			'import' => array(
				'evernotexml' => 'Import an Evernote XML::',
				'upload_evernotexml' => 'Upload your Evernote XML export here, to import your Evernote notes into Paperwork.'
			),
			'export' => array(
				'evernotexml' => 'Export as Evernote XML:',
				'download_evernotexml' => 'Download an ENEX file compatible with Evernote to move your notes from Paperwork. '
			),
			'about' => array(
			    'about_help_text' => 'Please include this identification code in any issues you open on our Github repository. This code does not contain any personal information and can be shared freely. ',
			)
		)
	),
	'setup' => array(
        'update_check' => array(
            'checking_for_updates' => 'Checking for Updates',
            'cannot_connect_error_no_solution' => 'Paperwork cannot connect to Github to check the latest version. Please make sure that you are installing the latest version. ',
            'cannot_connect_error_curl' => 'Paperwork cannot connect to Github to check the latest version because you do not have php5-curl installed on your system. A solution to this can be installing the curl PHP extension.',
            'newer_commit_found' => 'It seems like you have done some changes to the Paperwork code. Before opening a new issue, please check if this issue is present in the official source code available in our Github repository. ',
            'newer_version_available' => 'It seems like this is not the latest version of Paperwork. Please consider installing a newer version. ',
            'update_check_button' => 'Update (coming soon)',
            'coming_soon' => 'Coming Soon',

        ),
        'database_setup' => array(
            'setting_up_database' => 'Setting up the database',
            'requirements_met' => 'All requirements have been met. ',
            'requirements_not_met' => 'Not all system requirements have been met. Please use another database system. ',
            'credentials_correct' => 'Credentials Correct',
            'credentials_not_correct' => 'Credentials Not Correct. Please delete db_settings file in storage directory and try again. ',
            'server_form_label' => 'Server',
            'port_form_label' => 'Port',
            'username_form_label' => 'Username',
            'password_form_label' => 'Password',
            'database_form_label' => 'Database',
            'button_check_connection_install_database' => 'Check Connection and Install Database',
            'new_db_options_soon' => 'New Database Options - Coming Soon',
        ),
        'configuration' => array(
            'configurating' => 'Configurating',
            'configuration_settings' => 'Configuration Settings',
            'change' => 'Change',
            'debug_mode' => 'Debug Mode',
            'registrations' => 'Enable Registrations',
            'forgot_password' => 'Enable Forgot Password',
            'issue_reporting_link' => 'Show Issue Reporting Link'
        ),
        'registration_first_user' => array(
            'register_first_user' => 'Registering your first user account',
            'registration_failed' => 'Registration failed because of an error in these fields: ',
            'continue_without_registering' => 'Continue without registering'
        ),
        'install_complete' => array(
            'installation_completed' => 'Installation Completed',
            'installation_completed_message' => 'Congratulations! You have now finished installing and setting up Paperwork. Click on the link below to login in the account you have just created. ',
            'proceed_to_paperwork_button' => 'Proceed to Paperwork'
        ),
        'button_next' => 'Next',
        'assets_check' => array(
            'assets_not_found' => 'Your installation lacks some files',
            'assets_not_found_description' => 'We have not found all the files required to run Paperwork. Did you run composer install, npm install, bower install and gulp?'
        )
	),
	'required_configuration_setting_register_admin_tooltip' => 'You need to set your registration configuration setting to \'admin\'',
	'non_editable_checkbox_explanation' => 'To check or uncheck this checkbox, edit the note and put X (to check) or leave empty (to uncheck) the space between the [ ] before this line'
);
