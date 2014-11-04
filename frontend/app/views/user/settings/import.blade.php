[[ Form::open(array('id' => 'form-import', 'class' => 'form', 'role' => 'form', 'files' => true)) ]]
	<div class="form-group">
		<label for="exampleInputFile">[[ Lang::get('messages.user.settings.import.evernotexml') ]]</label>
		[[ Form::file('enex'); ]]
		<p class="help-block">[[ Lang::get('messages.user.settings.import.upload_evernotexml') ]]</p>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-5 col-sm-7">
			[[ Form::submit(Lang::get('keywords.save'), array('id' => 'submit-import', 'class' => 'btn btn-primary')) ]]
		</div>
	</div>
[[ Form::close() ]]