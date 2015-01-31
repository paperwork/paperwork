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

	"accepted"             => ":attribute musi zostać zaakceptowany.",
	"active_url"           => ":attribute nie jest poprawnym adresem.",
	"after"                => ":attribute musi być po :date.",
	"alpha"                => ":attribute może składać się wyłącznie z liter.",
	"alpha_dash"           => ":attribute może zawierać tylko litery, cyfry i myślniki.",
	"alpha_num"            => ":attribute może zawierać tylko litery i cyfry.",
	"array"                => ":attribute musi być tablicą.",
	"before"               => ":attribute musi być po :date.",
	"between"              => array(
		"numeric" => ":attribute musi zawierać się między :min a :max.",
		"file"    => ":attribute musi zawierać się między :min a :max kilobajtów.",
		"string"  => ":attribute musi zawierać się między :min a :max znaków.",
		"array"   => ":attribute musi zawierać między :min a :max pozycji.",
	),
	"boolean"              => ":attribute musi być prawdziwe albo fałszywe",
	"confirmed"            => ":attribute potwierdzenie nie pasuje.",
	"date"                 => ":attribute nie jest poprawną datą.",
	"date_format"          => ":attribute nie pasuje do formatu :format.",
	"different"            => ":attribute i :other muszą być różne.",
	"digits"               => ":attribute musi mieć :digits cyfr.",
	"digits_between"       => ":attribute musi musi mieć od :min do :max cyfr.",
	"email"                => ":attribute musi być poprawnym adresem email.",
	"exists"               => "Wybrany :attribute jest nie poprawny.",
	"image"                => ":attribute musi musi być obrazkiem.",
	"in"                   => "Wybrany :attribute jest nie poprawny.",
	"integer"              => ":attribute musi liczbą całkowitą.",
	"ip"                   => ":attribute musi być poprawnym adresem IP.",
	"max"                  => array(
		"numeric" => ":attribute nie może być większy niż :max.",
		"file"    => ":attribute nie może być większy niż :max kilobajtów.",
		"string"  => ":attribute nie może być większy niż :max znaków.",
		"array"   => ":attribute nie może mieć powyżej :max pozycji.",
	),
	"mimes"                => ":attribute musi być: :values.",
	"min"                  => array(
		"numeric" => ":attribute musi co najmniej :min.",
		"file"    => ":attribute musi co najmniej :min kilobajtów.",
		"string"  => ":attribute musi co najmniej :min znaków.",
		"array"   => ":attribute musi mieć co najmniej :min pozycji.",
	),
	"not_in"               => "Wybrany :attribute jest nie poprawny.",
	"numeric"              => ":attribute musi liczbą.",
	"regex"                => ":attribute ma niepoprawny format.",
	"required"             => ":attribute jest wymagany .",
	"required_if"          => ":attribute jest wymagany  gdy :other jest równy :value.",
	"required_with"        => ":attribute jest wymagany  gdy :values istnieje.",
	"required_with_all"    => ":attribute jest wymagany  gdy :values istnieje.",
	"required_without"     => ":attribute jest wymagany  gdy :values nie istnieje.",
	"required_without_all" => ":attribute jest wymagany  gdy none of :values are present.",
	"same"                 => ":attribute i :other musi pasować.",
	"size"                 => array(
		"numeric" => ":attribute musi mieć :size.",
		"file"    => ":attribute musi mieć :size kilobajtów.",
		"string"  => ":attribute musi mieć :size znaków.",
		"array"   => ":attribute musi zawirać :size pozycji.",
	),
	"unique"               => ":attribute jest już wykorzystany.",
	"url"                  => ":attribute ma niepoprawny format.",

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
