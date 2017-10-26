<?php

class Version extends PaperworkModel {
	use SoftDeletingTrait;
	protected $softDelete = true;
	protected $table = 'versions';
	protected $fillable = array('previous_id', 'next_id', 'title', 'content', 'content_preview','user_id');

	public function notes() {
		return $this->hasOne('Note');
	}

	public function previous() {
		return $this->belongsTo('Version', 'previous_id');
	}

	public function next() {
		return $this->belongsTo('Version', 'next_id');
	}

	public function attachments() {
		return $this->belongsToMany('Attachment')->withTimestamps();
	}

	public function user() {
		return $this->belongsTo('User');
	}
	
	/**
	 * This could be implemented as an extension. Since Paperwork at the
	 * moment does not support extensions, I am adding as a core feature. 
	 */
	public function getContentAttribute($rawValue) {
		if(Config::get('paperwork.extra_feature_checkboxes')) {
			$nonEditableMessage = Lang::get('messages.non_editable_checkbox_explanation');
			$newValue = preg_replace('/<(p|br)>\[( |)\](.*?)<(\/p|br)>/', '<$1><input type="checkbox" disabled title="' . $nonEditableMessage . '"> $3 <$4>', $rawValue);
			$newValue = preg_replace('/<(p|br)>\[(X|x)\](.*?)<(\/p|br)>/', '<$1><input type="checkbox" checked disabled title="' . $nonEditableMessage . '"> $3 <$4>', $newValue);
			return $newValue;
		}else{
			return $rawValue;
		}
	}
}

?>
