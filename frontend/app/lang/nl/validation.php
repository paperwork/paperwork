<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| De following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "De :attribute moet aanvaard worden.",
	"active_url"           => "De :attribute moet een werkende URL zijn.",
	"after"                => "De :attribute moet na :date zijn.",
	"alpha"                => "De :attribute mag enkel letters bevatten.",
	"alpha_dash"           => "De :attribute mag enkel contain letters, nummers, en streepjes bevatten.",
	"alpha_num"            => "De :attribute mag enkel letters en nummers bevatten.",
	"array"                => "De :attribute mag enkel een array bevatten. ",
	"before"               => "De :attribute moet voor :date zijn.",
	"between"              => array(
		"numeric" => "De :attribute moet tussen :min en :max zijn.",
		"file"    => "De :attribute moet tussen :min en :max kilobytes zijn.",
		"string"  => "De :attribute moet tussen :min en :max karakters zijn.",
		"array"   => "De :attribute moet tussen :min en :max dingen hebben.", /*Not the best translation*/
	),
	"boolean"              => "De :attribute moet \"true\" of \"false\" zijn.",
	"confirmed"            => "De :attribute va",
	"date"                 => "De :attribute is not a valid date.",
	"date_format"          => "De :attribute does not match the format :format.",
	"different"            => "De :attribute and :other must be different.",
	"digits"               => "De :attribute must be :digits digits.",
	"digits_between"       => "De :attribute moet tussen :min en :max zijn digits.",
	"email"                => "De :attribute must be a valid email address.",
	"exists"               => "De selected :attribute is invalid.",
	"image"                => "De :attribute must be an image.",
	"in"                   => "De selected :attribute is invalid.",
	"integer"              => "De :attribute must be an integer.",
	"ip"                   => "De :attribute must be a valid IP address.",
	"max"                  => array(
		"numeric" => "De :attribute may not be greater than :max.",
		"file"    => "De :attribute may not be greater than :max kilobytes.",
		"string"  => "De :attribute may not be greater than :max characters.",
		"array"   => "De :attribute may not have more than :max items.",
	),
	"mimes"                => "De :attribute must be a file of type: :values.",
	"min"                  => array(
		"numeric" => "De :attribute must be at least :min.",
		"file"    => "De :attribute must be at least :min kilobytes.",
		"string"  => "De :attribute must be at least :min characters.",
		"array"   => "De :attribute must have at least :min items.",
	),
	"not_in"               => "De selected :attribute is invalid.",
	"numeric"              => "De :attribute must be a number.",
	"regex"                => "De :attribute format is invalid.",
	"required"             => "De :attribute field is required.",
	"required_if"          => "De :attribute field is required when :other is :value.",
	"required_with"        => "De :attribute field is required when :values is present.",
	"required_with_all"    => "De :attribute field is required when :values is present.",
	"required_without"     => "De :attribute field is required when :values is not present.",
	"required_without_all" => "De :attribute field is required when none of :values are present.",
	"same"                 => "De :attribute and :other must match.",
	"size"                 => array(
		"numeric" => "De :attribute must be :size.",
		"file"    => "De :attribute must be :size kilobytes.",
		"string"  => "De :attribute must be :size characters.",
		"array"   => "De :attribute must contain :size items.",
	),
	"unique"               => "De :attribute has already been taken.",
	"url"                  => "De :attribute format is invalid.",

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
	| De following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),

);
