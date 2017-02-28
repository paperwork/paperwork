<?php

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

	"accepted"             => ":attribute måste accepteras.",
	"active_url"           => ":attribute är inte en giltig URL.",
	"after"                => ":attribute måste vara ett datum efter :date.",
	"alpha"                => ":attribute får endast innehålla bokstäver.",
	"alpha_dash"           => ":attribute får endast innehålla bokstäver, siffror och bindestreck.",
	"alpha_num"            => ":attribute får endast innehålla bokstäver och siffror.",
	"array"                => ":attribute måste vara en array.",
	"before"               => ":attribute måste vara ett datum innan :date.",
	"between"              => array(
		"numeric" => ":attribute måste vara mellan :min och :max.",
		"file"    => ":attribute måste vara mellan :min och :max kilobyte.",
		"string"  => ":attribute måste vara mellan :min och :max tecken.",
		"array"   => ":attribute måste ha mellan :min och :max element.",
	),
	"boolean"              => ":attribute måste vara antingen true eller false",
	"confirmed"            => ":attribute bekräftelsen matchar inte.",
	"date"                 => ":attribute är inte ett giltigt datum.",
	"date_format"          => ":attribute matchar inte formatet :format.",
	"different"            => ":attribute och :other måste vara olika.",
	"digits"               => ":attribute måste vara :digits siffror.",
	"digits_between"       => ":attribute måste vara mellan :min och :max siffror.",
	"email"                => ":attribute måste vara en giltig e-postadress.",
	"exists"               => "Det valda :attribute är ogiltigt.",
	"image"                => ":attribute måste vara en bild.",
	"in"                   => "Det valda :attribute är ogiltigt.",
	"integer"              => ":attribute måste vara ett heltal.",
	"ip"                   => ":attribute måste vara en giltig IP-adress.",
	"max"                  => array(
		"numeric" => ":attribute får inte vara större än :max.",
		"file"    => ":attribute får inte vara större än :max kilobyte.",
		"string"  => ":attribute får inte vara större än :max tecken.",
		"array"   => ":attribute får inte ha fler än :max element.",
	),
	"mimes"                => ":attribute måste vara en fil av typ :values.",
	"min"                  => array(
		"numeric" => ":attribute måste vara minst :min.",
		"file"    => ":attribute måste vara minst :min kilobyte.",
		"string"  => ":attribute måste vara minst :min tecken.",
		"array"   => ":attribute måste ha minst :min element.",
	),
	"not_in"               => "Det valda :attribute är ogiltigt.",
	"numeric"              => ":attribute måste vara ett tal.",
	"regex"                => ":attribute - formatet är ogiltigt.",
	"required"             => ":attribute - fältet är ogiltigt.",
	"required_if"          => ":attribute - fältet krävs när :other är :value.",
	"required_with"        => ":attribute - fältet krävs när :values finns.",
	"required_with_all"    => ":attribute - fältet krävs när :values finns.",
	"required_without"     => ":attribute - fältet krävs när :values inte finns.",
	"required_without_all" => ":attribute - fältet krävs när ingen av :values finns.",
	"same"                 => ":attribute och :other måste matcha.",
	"size"                 => array(
		"numeric" => ":attribute måste vara :size.",
		"file"    => ":attribute måste vara :size kilobyte.",
		"string"  => ":attribute måste vara :size tecken.",
		"array"   => ":attribute måste innehålla :size element.",
	),
	"unique"               => ":attribute är redan tagit.",
	"url"                  => ":attribute - formatet är ogiltigt.",

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
