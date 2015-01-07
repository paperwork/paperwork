<?php

class Attachment extends Eloquent {
	use SoftDeletingTrait;
	protected $softDelete = true;
	protected $table = 'attachments';
	protected $fillable = array('filename', 'fileextension', 'content', 'mimetype', 'filesize');

	public function versions() {
		return $this->belongsToMany('Version')->withTimestamps();
	}
}

?>
