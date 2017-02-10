<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends PaperworkModel
{
    use SoftDeletes;

    protected $softDelete = true;
    protected $table = 'languages';
    protected $fillable = array('language_code');

    public function users()
    {
        return $this->belongsToMany('users');
    }
}
