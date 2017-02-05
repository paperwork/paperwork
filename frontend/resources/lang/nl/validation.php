<?php

$allowed_name_chars = Config::get('paperwork.nameCharactersAllowed');
$name_error_message = "De :attribute mag enkel";
$name_error_message.= $allowed_name_chars['alpha']      ? ' letters,'    : '';
$name_error_message.= $allowed_name_chars['hyphen']     ? ' hyphens,'    : '';
$name_error_message.= $allowed_name_chars['num']        ? ' numbers,'    : '';
$name_error_message.= $allowed_name_chars['underscore'] ? ' underscores,': '';
$name_error_message.= $allowed_name_chars['apostrophe'] ? ' apostrophes,': '';
$name_error_message.= $allowed_name_chars['space']      ? ' spaces,'     : '';
$name_error_message.: "bevatten";
//replace last , with a .
$name_error_message = substr($name_error_message, 0, -1).'.';

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
	"alpha_dash_spaces"    => "De :attribute mag enkel contain letters, nummers, streepjes en spaties bevatten.",
	"alpha_num"            => "De :attribute mag enkel letters en nummers bevatten.",
	"array"                => "De :attribute mag enkel een array bevatten. ",
	"before"               => "De :attribute moet voor :date zijn.",
	"between"              => array(
		"numeric" => "De :attribute moet tussen :min en :max zijn.",
		"file"    => "De :attribute moet tussen :min en :max kilobytes zijn.",
		"string"  => "De :attribute moet tussen :min en :max karakters zijn.",
		"array"   => "De :attribute moet tussen :min en :max items hebben.", /*Not the best translation*/
	),
	"boolean"              => "De :attribute moet \"true\" of \"false\" zijn.",
	"confirmed"            => "De :attribute moet hetzelfde zijn",
	"date"                 => "De :attribute is geen geldige datum",
	"date_format"          => "De :attribute volgd de geldige syntax niet :format.",
	"different"            => ":attribute en :other moeten verschillen.",
	"digits"               => "De :attribute moet :digits getallen lang zijn.",
	"digits_between"       => "De :attribute moet tussen :min en :max getallen langzijn.",
	"email"                => "De :attribute moet een geldig e-mailadres zijn.",
	"exists"               => "De geselecteerde :attribute is ongeldig",
	"image"                => "De :attribute moet een afbeelding zijn.",
	"in"                   => "De geselecteerde :attribute is ongeldig.",
	"integer"              => "De :attribute moet een geheel getal zijn.",
	"ip"                   => "De :attribute moet een geldig IP-adres zijn.",
	"max"                  => array(
		"numeric" => "De :attribute moet kleiner zijn dan :max.",
		"file"    => "De :attribute moet kleiner zijn dan :max kilobytes.",
		"string"  => "De :attribute moet kleiner zijn dan :max karakters.",
		"array"   => "De :attribute moet minder dan :max items hebben.",
	),
	"mimes"                => "De :attribute moet een betstand van de volgende types zijn: :values.",
	"min"                  => array(
		"numeric" => "De :attribute moet minstens :min lang zijn.",
		"file"    => "De :attribute moet minstens :min kilobytes groot zijn.",
		"string"  => "De :attribute moet minstens :min karakters bevatten.",
		"array"   => "De :attribute moet minstens :min items hebben.",
	),
	"name_validator"       => $name_error_message,
	"not_in"               => "De geselecteerde :attribute is ongeldig.",
	"numeric"              => "De :attribute moet een nummer zijn.",
	"regex"                => "Het :attribute formaat is ongeldig.",
	"required"             => "De :attribute veld is verplicht.",
	"required_if"          => "Het :attribute veld is verplicht als :other :value is.", /* Could be wrong */
	"required_with"        => "Het :attribute veld is verplicht :values aanwezig zijn.",
	"required_with_all"    => "Het :attribute veld is verplicht :values aanwezig is.",
	"required_without"     => "Het :attribute veld is verplicht :values niet aanwezig is.",
	"required_without_all" => "Het :attribute veld is verplicht geen van de :values aanwezig zijn.",
	"same"                 => "De :attribute en :other moeten gelijk zijn.",
	"size"                 => array(
		"numeric" => "De :attribute moet :size zijn.",
		"file"    => "De :attribute moet :size kilobytes zijn.",
		"string"  => "De :attribute moet :size karakters zijn.",
		"array"   => "De :attribute moet :size items bevatten.",
	),
	"unique"               => "De :attribute is al in gebruik.",
	"url"                  => "De :attribute formaat is ongeldig.",

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
