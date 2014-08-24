@extends("layouts/user-layout")
@section("content")

<div class="container-narrow">
<h1>[[ Lang::get('keywords.profile') ]]: [[ $user->username ]]</h1>
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
@foreach(['password', 'password_confirmation', 'firstname', 'lastname'] as $err)
	@if ($errors->first($err)!=null)
	  <div class="alert alert-danger" role="alert">
	    [[ $errors->first($err) ]]
	  </div>
	@endif
@endforeach

[[ Form::open(array('class' => 'form-horizontal', 'role' => 'form')) ]]
	<div class="form-group [[ $errors->first('firstname') ? 'has-error' : '' ]]">
		<label for="firstname" class="col-sm-3 control-label">[[ Lang::get('keywords.first_name') ]]</label>
		<div class="col-sm-9">
			[[ Form::text("firstname", $user->firstname, array('id' => 'firstname', 'class' => 'form-control', 'placeholder' => Lang::get('keywords.first_name'), 'required')) ]]
		</div>
	</div>
	<div class="form-group [[ $errors->first('lastname') ? 'has-error' : '' ]]">
		<label for="lastname" class="col-sm-3 control-label">[[ Lang::get('keywords.last_name') ]]</label>
		<div class="col-sm-9">
		  [[ Form::text("lastname", $user->lastname, array('id' => 'lastname', 'class' => 'form-control', 'placeholder' => Lang::get('keywords.last_name'), 'required')) ]]
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
		  <div>
		  	[[ Lang::get('users.profile_change_password_info') ]]
		  </div>
		</div>
	</div>

	<div class="form-group [[ $errors->first('password') ? 'has-error' : '' ]]">
		<label for="password" class="col-sm-3 control-label">[[ Lang::get('keywords.password') ]]</label>
		<div class="col-sm-9">
		  [[ Form::password("password", array('id' => 'password', 'class' => 'form-control', 'placeholder' => Lang::get('keywords.password'))) ]]
		</div>
	</div>
	<div class="form-group [[ $errors->first('password_confirmation') ? 'has-error' : '' ]]">
		<label for="password_confirmation" class="col-sm-3 control-label">[[ Lang::get('keywords.confirm') ]]</label>
		<div class="col-sm-9">
		  [[ Form::password("password_confirmation", array('id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => Lang::get('keywords.confirm'))) ]]
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			[[ Form::submit(Lang::get('keywords.save'), array('class' => 'btn btn-primary')) ]]
		</div>
	</div>

[[ Form::close() ]]
</div>

@stop