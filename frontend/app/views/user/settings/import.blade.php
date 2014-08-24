[[ Form::open(array('id' => 'form-import', 'class' => 'form', 'role' => 'form', 'files' => true)) ]]
	<div class="form-group">
		<label for="exampleInputFile">Evernote XML:</label>
		[[ Form::file('enex'); ]]
		<p class="help-block">Upload your Evernote XML export here, to import your Evernote notes into Paperwork.</p>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-5 col-sm-7">
			[[ Form::submit(Lang::get('keywords.save'), array('id' => 'submit-import', 'class' => 'btn btn-primary')) ]]
		</div>
	</div>
[[ Form::close() ]]