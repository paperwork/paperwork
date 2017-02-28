<?php

namespace App\Models;

class Tag extends PaperworkModel
{
    protected $table = 'tags';
    protected $fillable = array('visibility', 'title', 'user_id');

    public function notes()
    {
        return $this->belongsToMany('App\Models\Note', 'tag_note')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function children()
    {
        return $this->hasMany('App\Models\Tag', 'parent_id', 'id');
    }
    public function parents()
    {
        return $this->belongsTo('App\Models\Tag', 'parent_id', 'id');
    }
}
