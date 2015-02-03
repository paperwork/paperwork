@extends("layouts/guest-layout")
@section("content")

@if ($errors->first('password')!=null)
  <div class="alert alert-danger" role="alert">
    [[ $errors->first('password') ]]
  </div>
@endif

[[ Form::open(array('class' => 'form-signin', 'role' => 'form')) ]]
<h1 class="form-signin-heading">[[Lang::get('users.title_login')]]</h1>
<div class="form-group [[ $errors->first('username') ? 'has-error' : '' ]]">
	[[ Form::text('username', '', array('class' => 'form-control', 'placeholder' => Lang::get('keywords.email_address'), 'required', 'autofocus')) ]]
</div>
<div class="form-group [[ $errors->first('password') ? 'has-error' : '' ]]">
	[[ Form::password('password', array('class' => 'form-control', 'placeholder' => Lang::get('keywords.password'), 'required')) ]]
</div>
@if (Config::get('paperwork.forgot_password'))
	<div class="checkbox">
		<a href="[[ URL::route("user/request") ]]"><i class="fa fa-life-saver"></i> [[Lang::get('users.link_forgot_password')]]</a>
	</div>
@endif
<div class="form-group">
	[[ Form::submit(Lang::get('keywords.sign_in'), array('class' => 'btn btn-lg btn-primary btn-block')) ]]
</div>
<div class="[[ Config::get('paperwork.registration') ? '' : 'hide' ]]">
	<div class="form-group">
		<a class="btn btn-lg btn-default btn-block" href="[[ Config::get('paperwork.registration') ? URL::route("user/register") : '#' ]]"><i class="fa fa-sign-up"></i> [[Lang::get('keywords.sign_up')]]</a>
	</div>
</div>

[[ Form::close() ]]

@stop
