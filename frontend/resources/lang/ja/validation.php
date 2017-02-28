<?php

$allowed_name_chars = Config::get('paperwork.nameCharactersAllowed');
$name_error_message = "The :attribute may only contain";
$name_error_message.= $allowed_name_chars['alpha']      ? ' letters,'    : '';
$name_error_message.= $allowed_name_chars['hyphen']     ? ' hyphens,'    : '';
$name_error_message.= $allowed_name_chars['num']        ? ' numbers,'    : '';
$name_error_message.= $allowed_name_chars['underscore'] ? ' underscores,': '';
$name_error_message.= $allowed_name_chars['apostrophe'] ? ' apostrophes,': '';
$name_error_message.= $allowed_name_chars['space']      ? ' spaces,'     : '';
//replace last , with a .
$name_error_message = substr($name_error_message, 0, -1).'.';


return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "The :attribute must be accepted.",
	"active_url"           => "The :attribute is not a valid URL.",
	"after"                => "The :attribute must be a date after :date.",
	"alpha"                => "The :attribute may only contain letters.",
	"alpha_dash"           => "The :attribute may only contain letters, numbers, and dashes.",
	"alpha_dash_spaces"    => "The :attribute may only contain letters, numbers, dashes, apostrophes, and spaces.",
	"alpha_num"            => "The :attribute may only contain letters and numbers.",
	"array"                => "The :attribute must be an array.",
	"before"               => "The :attribute must be a date before :date.",
	"between"              => array(
		"numeric" => ":attribute は、:min と :max の間の値でなくてはなりません。",
		"file"    => ":attribute は、:min 〜 :max キロバイトの値でなくてはなりません。.",
		"string"  => ":attribute は、:min 文字から :max 文字まででなくてはなりません。",
		"array"   => ":attribute は、:min 項目から :max 項目の間でなくてはなりません。",
	),
	"boolean"              => "The :attribute field must be true or false",
	"confirmed"            => "The :attribute confirmation does not match.",
	"date"                 => "The :attribute is not a valid date.",
	"date_format"          => "The :attribute does not match the format :format.",
	"different"            => "The :attribute and :other must be different.",
	"digits"               => "The :attribute must be :digits digits.",
	"digits_between"       => "The :attribute must be between :min and :max digits.",
	"email"                => "The :attribute must be a valid email address.",
	"exists"               => "The selected :attribute is invalid.",
	"image"                => "The :attribute must be an image.",
	"in"                   => "The selected :attribute is invalid.",
	"integer"              => "The :attribute must be an integer.",
	"ip"                   => "The :attribute must be a valid IP address.",
	"max"                  => array(
		"numeric" => ":attribute は、:min と :max の間の値でなくてはなりません。",
		"file"    => ":attribute は、:min 〜 :max キロバイトの値でなくてはなりません。.",
		"string"  => ":attribute は、:min 文字から :max 文字まででなくてはなりません。",
		"array"   => ":attribute は、:min 項目から :max 項目の間でなくてはなりません。",
	),
	"mimes"                => "The :attribute must be a file of type: :values.",
	"min"                  => array(
		"numeric" => ":attribute は、:min と :max の間の値でなくてはなりません。",
		"file"    => ":attribute は、:min 〜 :max キロバイトの値でなくてはなりません。.",
		"string"  => ":attribute は、:min 文字から :max 文字まででなくてはなりません。",
		"array"   => ":attribute は、:min 項目から :max 項目の間でなくてはなりません。",
	),
	"name_validator"       => $name_error_message,
	"not_in"               => "The selected :attribute is invalid.",
	"numeric"              => "The :attribute must be a number.",
	"regex"                => "The :attribute format is invalid.",
	"required"             => "The :attribute field is required.",
	"required_if"          => "The :attribute field is required when :other is :value.",
	"required_with"        => "The :attribute field is required when :values is present.",
	"required_with_all"    => "The :attribute field is required when :values is present.",
	"required_without"     => "The :attribute field is required when :values is not present.",
	"required_without_all" => "The :attribute field is required when none of :values are present.",
	"same"                 => "The :attribute and :other must match.",
	"size"                 => array(
		"numeric" => ":attribute は、:min と :max の間の値でなくてはなりません。",
		"file"    => ":attribute は、:min 〜 :max キロバイトの値でなくてはなりません。.",
		"string"  => ":attribute は、:min 文字から :max 文字まででなくてはなりません。",
		"array"   => ":attribute は、:min 項目から :max 項目の間でなくてはなりません。",
	),
	"unique"               => "The :attribute has already been taken.",
	"url"                  => "The :attribute format is invalid.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),

);
