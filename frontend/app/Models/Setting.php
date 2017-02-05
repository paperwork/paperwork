<?php

class Setting extends PaperworkModel {
	use Illuminate\Database\Eloquent\SoftDeletes;
	protected $softDelete = true;
	protected $table = 'settings';
	protected $fillable = array('user_id', 'ui_language');

	public function user() {
		return $this->hasOne('User');
	}
}

?>
