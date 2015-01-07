<?php

class Tag extends Eloquent {
	protected $table = 'tags';

	public function notes()
	{
	  return $this->belongsToMany('Note', 'tag_note')->withTimestamps();
	}

	public function users()
	{
	  return $this->belongsToMany('User', 'tag_user')->withTimestamps();
	}
}

?>
