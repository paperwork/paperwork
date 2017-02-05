<?php

class Shortcut extends PaperworkModel {
	protected $table = 'shortcuts';
	protected $fillable = array('notebook_id', 'user_id', 'sortkey');

	public function notebooks() {
		return $this->hasMany('Notebook');
	}

	public function users() {
		return $this->hasMany('User');
	}
}

?>
