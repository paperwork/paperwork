@extends("layouts/guest-layout")
@section("content")

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
@foreach(['email', 'password', 'password_confirmation'] as $err)
	@if ($errors->first($err)!=null)
	  <div class="alert alert-danger" role="alert">
	    [[ $errors->first($err) ]]
	  </div>
	@endif
@endforeach

[[ Form::open(array('class' => 'form-signin', 'role' => 'form')) ]]
<h1 class="form-signin-heading">[[Lang::get('users.title_reset')]]</h1>
<div class="form-group [[ $errors->first('username') ? 'has-error' : '' ]]">
	[[ Form::text("username", Input::old("username"), array('class' => 'form-control', 'placeholder' => Lang::get('keywords.email_address'), 'required', 'autofocus')) ]]
</div>
<div class="form-group [[ $errors->first('password') ? 'has-error' : '' ]]">
	[[ Form::password("password", array('class' => 'form-control', 'placeholder' => Lang::get('keywords.password'), 'required')) ]]
</div>
<div class="form-group [[ $errors->first('password_confirmation') ? 'has-error' : '' ]]">
	[[ Form::password("password_confirmation", array('class' => 'form-control', 'placeholder' => Lang::get('keywords.confirm'), 'required')) ]]
</div>
<div class="checkbox">
</div>
<div class="form-group">
	[[ Form::submit(Lang::get('keywords.reset_password'), array('class' => 'btn btn-lg btn-primary btn-block')) ]]
</div>
[[ Form::close() ]]
@stop