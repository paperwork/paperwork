<?php

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatbleContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends PaperworkModel implements AuthenticatbleContract, CanResetPasswordContract {
	use Authenticatable, CanResetPassword, SoftDeletes;

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

	public function setPasswordAttribute($pass) {
		$this->attributes['password'] = Hash::make($pass);
	}

	public function notebooks() {
		return $this->belongsToMany('Notebook')->withPivot('umask')->withTimestamps();
	}

	public function notes() {
		return $this->belongsToMany('Note')->withPivot('umask')->withTimestamps();
	}

	public function shortcuts() {
		return $this->hasMany('Shortcut');
	}

	public function languages() {
		return $this->belongsToMany('Language');
	}
	public function tags(){
		return $this->hasMany('Tag');
	}
	public function versions(){
	  return $this->hasMany('Version')->withTimestamps();
	}

    public function isAdmin() {
    	return $this->is_admin;
    }

    public function getReminderEmail() {
        return $this->username;
    }
}
