<?php

class Note extends PaperworkModel {
	use SoftDeletingTrait;
	protected $softDelete = true;
	protected $table = 'notes';
	protected $fillable = array('notebook_id', 'version_id');

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
	  return $this->belongsToMany('User')->withPivot('umask');
	}
}

?>
