<?php

namespace App\Models;

class Shortcut extends PaperworkModel
{
    protected $table = 'shortcuts';
    protected $fillable = array('notebook_id', 'user_id', 'sortkey');

    public function notebooks()
    {
        return $this->hasMany('App\Models\Notebook');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
