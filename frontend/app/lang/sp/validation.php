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

	"accepted"             => "El :attribute debe ser aceptado.",
	"active_url"           => "El :attribute no es una URL válida.",
	"after"                => "El :attribute debe ser una fecha posterior a :date.",
	"alpha"                => "El :attribute solo puede contener letras.",
	"alpha_dash"           => "El :attribute solo puede contener letras, números y guiones.",
	"alpha_num"            => "El :attribute solo puede contener letras y números.",
	"array"                => "El :attribute debe ser un array.",
	"before"               => "El :attribute debe ser una fecha anterior a :date.",
	"between"              => array(
		"numeric" => "El :attribute debe encontrarse entre :min y :max.",
		"file"    => "El :attribute debe encontrarse entre :min y :max kilobytes.",
		"string"  => "El :attribute debe contener entre :min y :max caracteres.",
		"array"   => "El :attribute debe contener entre :min y :max elementos.",
	),
	"boolean"              => "El campo :attribute debe ser true or false",
	"confirmed"            => "La confirmación de :attribute no coincide.",
	"date"                 => ":attribute no es una fecha válida.",
	"date_format"          => ":attribute no cumple el formato :format.",
	"different"            => ":attribute y :other deben ser distintos.",
	"digits"               => ":attribute debe contener :digits dígitos.",
	"digits_between"       => ":attribute debe contener entre :min y :max dígitos.",
	"email"                => ":attribute debe ser una dirección de correo válida.",
	"exists"               => ":attribute seleccionado no es válido.",
	"image"                => ":attribute debe ser una imágen.",
	"in"                   => ":attribute seleccionado no es válido.",
	"integer"              => ":attribute debe ser un entero.",
	"ip"                   => ":attribute debe ser una dirección IP válida.",
	"max"                  => array(
		"numeric" => ":attribute no debe ser mayor a :max.",
		"file"    => ":attribute no debe tener un tamaño mayor a :max kilobytes.",
		"string"  => ":attribute no debe contener más de :max caracteres.",
		"array"   => ":attribute no debe contener más de :max elementos.",
	),
	"mimes"                => ":attribute debe ser un archivo de tipo: :values.",
	"min"                  => array(
		"numeric" => ":attribute debe ser como mínimo :min.",
		"file"    => ":attribute debe ocupar como mínimo :min kilobytes.",
		"string"  => ":attribute debe contener como mínimo :min caracteres.",
		"array"   => ":attribute debe contener como mínimo :min elemento/s.",
	),
	"not_in"               => "El :attribute seleccionado no es válido.",
	"numeric"              => ":attribute debe ser un número.",
	"regex"                => "El formato de :attribute no es válido.",
	"required"             => "El campo :attribute es necesario.",
	"required_if"          => "El campo :attribute es necesario cuando :other es :value.",
	"required_with"        => "El campo :attribute es necesario cuando :values está presente.",
	"required_with_all"    => "El campo :attribute es necesario cuando :values está presente.",
	"required_without"     => "El campo :attribute es necesario cuando :values no está presente.",
	"required_without_all" => "El campo :attribute es necesario cuando no está presente ninguno de los siguientes :values .",
	"same"                 => "El campo :attribute y :other deben coincidir.",
	"size"                 => array(
		"numeric" => ":attribute debe ocupar :size.",
		"file"    => ":attribute debe ocupar :size kilobytes.",
		"string"  => ":attribute debe contener :size caracteres.",
		"array"   => ":attribute debe contener :size elementos.",
	),
	"unique"               => ":attribute ya ha sido utilizado.",
	"url"                  => "El formato de :attribute no es válido.",

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
