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

	"accepted"             => ":attribute は妥当なものでなくてはなりません。",
	"active_url"           => ":attribute が適切な URL ではありません。",
	"after"                => ":attribute は、:date より後の日付でなくてはなりません。",
	"alpha"                => ":attribute に含めてよいのは英字だけです。",
	"alpha_dash"           => ":attribute に含めてよいのは英数字とダッシュだけです。",
	"alpha_num"            => ":attribute に含めてよいのは英数字だけです。",
	"array"                => ":attribute は配列でなくてはなりません。",
	"before"               => ":attribute は、:date より前の日付でなくてはなりません。",
	"between"              => array(
		"numeric" => ":attribute は、:min と :max の間の値でなくてはなりません。",
		"file"    => ":attribute は、:min 〜 :max キロバイトの値でなくてはなりません。.",
		"string"  => ":attribute は、:min 文字から :max 文字まででなくてはなりません。",
		"array"   => ":attribute は、:min 項目から :max 項目の間でなくてはなりません。",
	),
	"boolean"              => ":attribute 欄は、true もしくは false でなくてはなりません",
	"confirmed"            => ":attribute の確認で不一致があります。",
	"date"                 => ":attribute は適切な日付ではありません。",
	"date_format"          => ":attribute は、:format 形式に沿っていません。",
	"different"            => ":attribute と :other は異なるものでなくてはなりません。",
	"digits"               => ":attribute は、:digits 桁の数字でなくてはなりません。.",
	"digits_between"       => ":attribute は、:min と :max の間でなくてはなりません。",
	"email"                => ":attribute は正しいメールアドレスでなくてはなりません。",
	"exists"               => "選択した :attribute は不適切です。",
	"image"                => ":attribute は画像でなくてはなりません。",
	"in"                   => "選択した :attribute は不適切です。",
	"integer"              => ":attribute は、整数でなくてはなりません。",
	"ip"                   => ":attribute は、正規の IP アドレスでなくてはなりません。",
	"max"                  => array(
		"numeric" => ":attribute は、:max が最大値です。",
		"file"    => ":attribute は、:max キロバイトが最大サイズです。",
		"string"  => ":attribute は、最大 :max 文字までです。",
		"array"   => ":attribute は、最大 :max 項目までです。",
	),
	"mimes"                => ":attribute にはファイルタイプを設定しなくてはなりません: :values.",
	"min"                  => array(
		"numeric" => ":attribute は、:min が最小値です。",
		"file"    => ":attribute は少なくとも :min キロバイト以上でなくてはなりません。",
		"string"  => ":attribute は、:min 文字異常でなくてはなりません。",
		"array"   => ":attribute は、少なくとも、:min 項目以上なくてはなりません。.",
	),
	"not_in"               => "選択した :attribute が不適切です。",
	"numeric"              => ":attribute は数字でなくてはなりません。",
	"regex"                => ":attribute の形式が不適切です。",
	"required"             => ":attribute 欄は必須です。",
	"required_if"          => ":attribute 欄は、:other が :value の場合、必須です。",
	"required_with"        => ":attribute 欄は、:values がある場合は、必須です。",
	"required_with_all"    => ":attribute 欄は、:values がある場合は、必須です。",
	"required_without"     => ":attribute 欄は、:values がない場合、必須です。",
	"required_without_all" => ":attribute 欄は、:values がひとつもない場合には必須です。.",
	"same"                 => ":attribute と :other は一致していなくてはなりません。.",
	"size"                 => array(
		"numeric" => ":attribute のサイズは、:size でなくてはなりません。",
		"file"    => ":attribute のサイズは、:size キロバイトでなくてはなりません。.",
		"string"  => ":attribute は、:size 文字でなくてはなりません。",
		"array"   => ":attribute は、:size もう濃くなければなりません。",
	),
	"unique"               => ":attribute は既に別の人が取得済みです。",
	"url"                  => ":attribute の形式が不適切です",

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
