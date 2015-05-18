<?php
class PaperworkModel extends Eloquent {
	public $incrementing = false;

	protected static function boot()
    {
		parent::boot();

		static::creating(function($model) {
			$model->{$model->getKeyName()} = (string)PaperworkHelpers::generateUuid('PaperworkModel');
		});
    }

	// public function newCollection(array $models = array())
	// {
	// 	return new Extensions\PaperworkCollection($models);
	// }
}
?>