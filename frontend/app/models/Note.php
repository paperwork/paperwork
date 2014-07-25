<?php

class Note extends Eloquent {
	use SoftDeletingTrait;
	protected $table = 'notes';

	public function version()
	{
	  return $this->hasOne('Version', 'version_id');
	}

	public function tags()
	{
	  return $this->belongsToMany('Tag', 'tag_note');
	}

	public function users()
	{
	  return $this->belongsToMany('User', 'tag_user');
	}
}

?>
