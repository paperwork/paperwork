<?php

class Language extends Eloquent {
	use SoftDeletingTrait;
	protected $softDelete = true;
	protected $table = 'languages';
	protected $fillable = array('language_code');

	public function users() {
		return $this->belongsToMany('users');
	}
}

?>
