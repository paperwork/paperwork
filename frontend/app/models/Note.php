<?php

class Note extends Eloquent {
	use SoftDeletingTrait;
	protected $softDelete = true;
	protected $table = 'notes';

	public function version()
	{
	  return $this->belongsTo('Version');
	}

	public function notebook()
	{
	  return $this->belongsTo('Notebook');
	}

	public function tags()
	{
	  return $this->belongsToMany('Tag', 'tag_note');
	}

	public function users()
	{
	  return $this->belongsToMany('User');
	}
}

?>
