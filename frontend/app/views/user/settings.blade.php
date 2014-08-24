@extends("layouts/user-layout")
@section("content")

<div class="container-narrow">
<h1>[[ Lang::get('keywords.settings') ]]</h1>
@if (Session::get("error"))
  <div class="alert alert-danger" role="alert">
    [[ Session::get("error") ]]
  </div>
@endif
@if (Session::get("status"))
  <div class="alert alert-info" role="alert">
    [[ Session::get("status") ]]
  </div>
@endif

[[ Form::open(array('class' => 'form-horizontal', 'role' => 'form')) ]]
<ul class="nav nav-tabs" role="tablist">
	<li class="active"><a href="#language" role="tab" data-toggle="tab">Language</a></li>
	<li><a href="#import" role="tab" data-toggle="tab">Import</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="language">
			<div class="form-group [[ $errors->first('ui_language') ? 'has-error' : '' ]]">
				<label for="ui_language" class="col-sm-5 control-label">[[ Lang::get('keywords.ui_language') ]]</label>
				<div class="col-sm-7">
					[[ Form::select("ui_language", PaperworkHelpers::getUiLanguages(), null, array('id' => 'ui_language', 'class' => 'form-control')) ]]
				</div>
			</div>

			<div class="form-group [[ $errors->first('document_languages') ? 'has-error' : '' ]]">
				<label for="document_languages" class="col-sm-5 control-label">
					[[ Lang::get('keywords.document_languages') ]]
					<p class="label-description">[[ Lang::get('messages.document_languages_description') ]]</p>
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
					[[ Form::submit(Lang::get('keywords.save'), array('class' => 'btn btn-primary')) ]]
				</div>
			</div>
	</div>
	<div class="tab-pane active" id="import">

	</div>
</div>
[[ Form::close() ]]
</div>
@stop