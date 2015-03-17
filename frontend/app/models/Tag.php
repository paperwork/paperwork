<?php

class Tag extends PaperworkModel {
	protected $table = 'tags';
	protected $fillable = array('visibility', 'title');

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
