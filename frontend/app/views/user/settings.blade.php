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

<ul class="nav nav-tabs nav-tabs-margin" role="tablist">
	<li class="active"><a href="#language" role="tab" data-toggle="tab">Language</a></li>
	<li><a href="#import" role="tab" data-toggle="tab">Import</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane active" id="language">
		@include('user/settings/language', array('settings' => $settings, 'languages' => $languages))
	</div>
	<div class="tab-pane" id="import">
		@include('user/settings/import', array())
	</div>
</div>
</div>
@stop