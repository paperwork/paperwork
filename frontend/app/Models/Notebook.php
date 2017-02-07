<?php

use Illuminate\Database\Eloquent\SoftDeletes;


class Notebook extends PaperworkModel {
    use SoftDeletes;

	protected $softDelete = true;
	protected $table = 'notebooks';
	protected $fillable = array('parent_id', 'type', 'title');

	public function users() {
		return $this->belongsToMany('User')->withTimestamps();
	}

	public function shortcuts() {
		return $this->hasMany('Shortcut');
	}

	public function notes() {
		return $this->hasMany('Note')->withTimestamps();
	}

	public function parents() {
		return $this->belongsTo('Notebook', 'parent_id', 'id');
	}

	public function children() {
		return $this->hasMany('Notebook', 'parent_id', 'id');
	}
}

?>
