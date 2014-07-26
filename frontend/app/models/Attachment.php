<?php

class Attachment extends Eloquent {
	use SoftDeletingTrait;

	protected $table = 'attachments';
	protected $fillable = array('content');

	public function versions() {
		return $this->belongsToMany('Version');
	}
}

?>
