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
	"confirmed"            => "De :attribute moet hetzelfde zijn",
	"date"                 => "De :attribute is geen geldige datum",
	"date_format"          => "De :attribute volgd de geldige syntax niet :format.",
	"different"            => ":attribute en :other moeten verschillen.",
	"digits"               => "De :attribute moet :digits getallen lang zijn.",
	"digits_between"       => "De :attribute moet tussen :min en :max getallen langzijn.",
	"email"                => "De :attribute moet een geldig e-mailadres zijn.",
	"exists"               => "De geselcteerde :attribute is ongeldig",
	"image"                => "De :attribute moet een afbeelding zijn.",
	"in"                   => "De geselcteerde :attribute is ongeldig.",
	"integer"              => "De :attribute moet een geheel getal zijn.",
	"ip"                   => "De :attribute moet een geldig IP-adres zijn.",
	"max"                  => array(
		"numeric" => "De :attribute moet kleiner zijn dan :max.",
		"file"    => "De :attribute moet kleiner zijn dan :max kilobytes.",
		"string"  => "De :attribute moet kleiner zijn dan :max karakters.",
		"array"   => "De :attribute moet minder dan :max dingen hebben.",
	),
	"mimes"                => "De :attribute moet be a file of type: :values.",
	"min"                  => array(
		"numeric" => "De :attribute moet minstens :min lang zijn.",
		"file"    => "De :attribute moet minstens :min kilobytes groot zijn.",
		"string"  => "De :attribute moet minstens :min karakters bevatten.",
		"array"   => "De :attribute moet have at least :min items.",
	),
	"not_in"               => "De geselcteerde :attribute is ongeldig.",
	"numeric"              => "De :attribute moet be a number.",
	"regex"                => "De :attribute format is ongeldig.",
	"required"             => "De :attribute field is required.",
	"required_if"          => "De :attribute field is required when :other is :value.",
	"required_with"        => "De :attribute field is required when :values is present.",
	"required_with_all"    => "De :attribute field is required when :values is present.",
	"required_without"     => "De :attribute field is required when :values is not present.",
	"required_without_all" => "De :attribute field is required when none of :values are present.",
	"same"                 => "De :attribute and :other moet match.",
	"size"                 => array(
		"numeric" => "De :attribute moet be :size.",
		"file"    => "De :attribute moet be :size kilobytes.",
		"string"  => "De :attribute moet be :size characters.",
		"array"   => "De :attribute moet contain :size items.",
	),
	"unique"               => "De :attribute has already been taken.",
	"url"                  => "De :attribute format is ongeldig.",

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
