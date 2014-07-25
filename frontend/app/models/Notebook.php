<?php

class Notebook extends Eloquent {
	use SoftDeletingTrait;
	protected $table = 'notebooks';

	public function users() {
		return $this->belongsToMany('User');
	}

	public function shortcuts() {
		return $this->hasMany('Shortcut');
	}

	public function notes() {
		return $this->hasMany('Note');
	}
}

?>
