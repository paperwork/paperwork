<?php

class Version extends Eloquent {
	use SoftDeletingTrait;

	protected $table = 'versions';
	protected $fillable = array('previous_id', 'next_id', 'title', 'content_preview', 'content');

	public function note() {
		return $this->belongsTo('Note', 'version_id');
	}

	public function previous() {
		return $this->hasMany('Version', 'previous_id');
	}

	public function next() {
		return $this->hasMany('Version', 'next_id');
	}
}

?>
