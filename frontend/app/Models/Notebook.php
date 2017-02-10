<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Notebook extends PaperworkModel
{
    use SoftDeletes;

    protected $softDelete = true;
    protected $table = 'notebooks';
    protected $fillable = array('parent_id', 'type', 'title');

    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withTimestamps();
    }

    public function shortcuts()
    {
        return $this->hasMany('App\Models\Shortcut');
    }

    public function notes()
    {
        return $this->hasMany('App\Models\Note')->withTimestamps();
    }

    public function parents()
    {
        return $this->belongsTo('App\Models\Notebook', 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Notebook', 'parent_id', 'id');
    }
}
