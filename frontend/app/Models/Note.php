<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends PaperworkModel
{
    use SoftDeletes;

    protected $softDelete = true;
    protected $table = 'notes';
    protected $fillable = array('notebook_id', 'version_id');

    public function version()
    {
        return $this->belongsTo('App\Models\Version');
    }

    public function notebook()
    {
        return $this->belongsTo('App\Models\Notebook');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'tag_note');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withPivot('umask');
    }
}
