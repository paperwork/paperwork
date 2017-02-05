[[ Form::open(array('id' => 'form-language', 'class' => 'form-horizontal', 'role' => 'form')) ]]
		<div class="form-group [[ $errors->first('ui_language') ? 'has-error' : '' ]]">
			<label for="ui_language" class="col-sm-5 control-label">[[ Lang::get('messages.user.settings.language.ui_language') ]]</label>
			<div class="col-sm-7">
				[[ Form::select("ui_language", PaperworkHelpers::getUiLanguages(), $settings->ui_language, array('id' => 'ui_language', 'class' => 'form-control')) ]]
			</div>
		</div>

		<div class="form-group [[ $errors->first('document_languages') ? 'has-error' : '' ]]">
			<label for="document_languages" class="col-sm-5 control-label">
				[[ Lang::get('messages.user.settings.language.document_languages') ]]
				<p class="label-description">[[ Lang::get('messages.user.settings.language.document_languages_description') ]]</p>
			</label>
			<div class="col-sm-7">
				<div class="container-scrollable">
				<div class="container">
					@foreach(PaperworkHelpers::getDocumentLanguages() as $lang_code => $lang_label)
						<div class="row">
							<div class="col-sm-12">
								<div class="checkbox">
									<label>
										[[ Form::checkbox('document_languages[]', $lang_code, (array_key_exists($lang_code, $languages) ? $languages[$lang_code] : false)) ]] [[ $lang_label ]]
									</label>
								</div>
							</div>
						</div>
					@endforeach
				</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-5 col-sm-7">
				[[ Form::submit(Lang::get('keywords.save'), array('id' => 'submit-language', 'class' => 'btn btn-primary')) ]]
			</div>
		</div>
[[ Form::close() ]]