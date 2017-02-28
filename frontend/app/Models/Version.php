<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Version extends PaperworkModel
{
    use SoftDeletes;

    protected $softDelete = true;
    protected $table = 'versions';
    protected $fillable = array('previous_id', 'next_id', 'title', 'content', 'content_preview','user_id');

    public function notes()
    {
        return $this->hasOne('App\Models\Note');
    }

    public function previous()
    {
        return $this->belongsTo('App\Models\Version', 'previous_id');
    }

    public function next()
    {
        return $this->belongsTo('App\Models\Version', 'next_id');
    }

    public function attachments()
    {
        return $this->belongsToMany('App\Models\Attachment')->withTimestamps();
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
