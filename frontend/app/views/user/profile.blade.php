@extends("layouts/user-layout")
@section("content")

<div class="container-narrow">
<h2>Profile [[ Auth::user()->firstname ]]!</h2>
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
@foreach(['username', 'password', 'password_confirmation', 'firstname', 'lastname'] as $err)
	@if ($errors->first($err)!=null)
	  <div class="alert alert-danger" role="alert">
	    [[ $errors->first($err) ]]
	  </div>
	@endif
@endforeach

[[ Form::open(array('class' => 'form-horizontal', 'role' => 'form')) ]]
	<div class="form-group [[ $errors->first('firstname') ? 'has-error' : '' ]]">
		<label for="firstname" class="col-sm-2 control-label">[[ Lang::get('keywords.first_name') ]]</label>
		<div class="col-sm-10">
			[[ Form::text("firstname", Input::old("firstname"), array('id' => 'firstname', 'class' => 'form-control', 'placeholder' => Lang::get('keywords.first_name'), 'required')) ]]
		</div>
	</div>
	<div class="form-group [[ $errors->first('lastname') ? 'has-error' : '' ]]">
		<label for="lastname">[[ Lang::get('keywords.last_name') ]]</label>
	  [[ Form::text("lastname", Input::old("lastname"), array('id' => 'lastname', 'class' => 'form-control', 'placeholder' => Lang::get('keywords.last_name'), 'required')) ]]
	</div>
	<div class="form-group [[ $errors->first('password') ? 'has-error' : '' ]]">
		<label for="password">[[ Lang::get('keywords.password') ]]</label>
	  [[ Form::password("password", array('id' => 'password', 'class' => 'form-control', 'placeholder' => Lang::get('keywords.password'), 'required')) ]]
	</div>
	<div class="form-group [[ $errors->first('password_confirmation') ? 'has-error' : '' ]]">
		<label for="password_confirmation">[[ Lang::get('keywords.confirm') ]]</label>
	  [[ Form::password("password_confirmation", array('id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => Lang::get('keywords.confirm'), 'required')) ]]
	</div>
[[ Form::close() ]]
</div>

@stop