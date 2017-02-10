<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PaperworkModel;

class Setting extends PaperworkModel
{
    use SoftDeletes;

    protected $softDelete = true;
    protected $table = 'settings';
    protected $fillable = array('user_id', 'ui_language');

    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}
