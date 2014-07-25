<?php

class Note extends Eloquent {
	protected $table = 'notes';

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
