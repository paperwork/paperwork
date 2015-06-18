<?php

class Tag extends PaperworkModel {
	protected $table = 'tags';
	protected $fillable = array('visibility', 'title', 'user_id');

	public function notes()
	{
	  return $this->belongsToMany('Note', 'tag_note')->withTimestamps();
	}

	public function users()
	{
	  return $this->belongsTo('User');
	}
}

?>
