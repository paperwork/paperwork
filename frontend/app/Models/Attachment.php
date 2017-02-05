<?php

class Attachment extends PaperworkModel {
	use Illuminate\Database\Eloquent\SoftDeletes;
	protected $softDelete = true;
	protected $table = 'attachments';
	protected $fillable = array('filename', 'fileextension', 'content', 'mimetype', 'filesize');

	public function versions() {
		return $this->belongsToMany('Version')->withTimestamps();
	}
}

?>
