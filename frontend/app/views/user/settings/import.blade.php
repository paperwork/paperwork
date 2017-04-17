[[ Form::open(array('id' => 'form-import', 'class' => 'form', 'role' => 'form', 'files' => true, 'action' => 'UserController@import')) ]]
	<div class="form-group">
		<label for="exampleInputFile">[[ Lang::get('messages.user.settings.import.evernotexml') ]] ([[ Lang::get('keywords.experimental') ]])</label>
		[[ Form::file('enex'); ]]
		<p class="help-block">[[ Lang::get('messages.user.settings.import.upload_evernotexml') ]]</p>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-5 col-sm-7">
			[[ Form::submit(Lang::get('keywords.import'), array('id' => 'submit-import', 'class' => 'btn btn-primary')) ]]
		</div>
	</div>
[[ Form::close() ]]
<br/><br/><br/>
[[ Form::open(array('id' => 'form-export', 'class' => 'form', 'role' => 'form', 'action' => 'UserController@export'))]]
    <div class="form-group">
        <label class="control-label">
            [[ Lang::get('messages.user.settings.export.evernotexml') ]] ([[ Lang::get('keywords.not_implemented') ]])
        </label>
        <p class="help-block">[[ Lang::get('messages.user.settings.export.download_evernotexml') ]]</p>
        <div class="col-sm-offset-5 col-sm-7">
            [[ Form::submit(Lang::get('keywords.export'), array('id' => 'submit-export', 'class' => 'btn btn-primary')) ]]
        </div>
    </div>
[[ Form::close() ]]
