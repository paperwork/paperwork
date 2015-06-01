<?php

class Version extends PaperworkModel {
	use SoftDeletingTrait;
	protected $softDelete = true;
	protected $table = 'versions';
	protected $fillable = array('previous_id', 'next_id', 'title', 'content', 'content_preview','user_id');

	public function notes() {
		return $this->hasOne('Note');
	}

	public function previous() {
		return $this->belongsTo('Version', 'previous_id');
	}

	public function next() {
		return $this->belongsTo('Version', 'next_id');
	}

	public function attachments() {
		return $this->belongsToMany('Attachment')->withTimestamps();
	}
	public function user(){
	  return $this->belongsTo('User');
	}
}

?>
