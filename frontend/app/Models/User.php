<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatbleContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends PaperworkModel implements AuthenticatbleContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Notifiable, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

    protected $softDelete = true;

    protected $fillable = array('username', 'password', 'firstname', 'lastname', 'is_admin', 'remember_token');

    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = Hash::make($pass);
    }

    public function notebooks()
    {
        return $this->belongsToMany('App\Models\Notebook')->withPivot('umask')->withTimestamps();
    }

    public function notes()
    {
        return $this->belongsToMany('App\Models\Note')->withPivot('umask')->withTimestamps();
    }

    public function shortcuts()
    {
        return $this->hasMany('App\Models\Shortcut');
    }

    /**
     * Scope a query to only include active users.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function languages()
    {
        return $this->belongsToMany('App\Models\Language');
    }
    public function tags()
    {
        return $this->hasMany('Tag');
    }
    public function versions()
    {
        return $this->hasMany('App\Models\Version')->withTimestamps();
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function getReminderEmail()
    {
        return $this->username;
    }
}
