@extends("layouts/user-layout")
@section("content")
<div class="container">
	<h1>[[Lang::get('keywords.users')]]</h1>
	[[ Form::open(array('url' => 'admin/users/delete')) ]]
	[[ Form::submit(Lang::get('keywords.delete_users'), array('class' => 'btn btn-primary', 'name' => 'delete')) ]]
	[[ Form::submit(Lang::get('keywords.restore_users'), array('class' => 'btn btn-default', 'name' => 'restore')) ]]
	@if (Config::get('paperwork.registration') === "admin")
	<a class="btn btn-default pull-right" href="/admin/register" title="[[ Lang::get('messages.required_configuration_setting_register_admin_tooltip') ]]">[[ Lang::get('keywords.register_users') ]]</a>
	@else
	<a class="btn btn-default disabled pull-right" style="pointer-events: auto" title="[[ Lang::get('messages.required_configuration_setting_register_admin_tooltip') ]]">[[ Lang::get('keywords.register_users') ]]</a>
	@endif
	<table class="table">
		<tr>
			<th>[[Lang::get('keywords.id')]]</th>
			<th>[[Lang::get('keywords.email_address')]]</th>
			<th>[[Lang::get('keywords.first_name')]]</th>
			<th>[[Lang::get('keywords.last_name')]]</th>
			<th>[[Lang::get('keywords.admin_status')]]</th>
			<th>[[Lang::get('keywords.created_at')]]</th>
			<th>[[Lang::get('keywords.updated_at')]]</th>
			<th>[[Lang::get('keywords.deleted_at')]]</th>
			<th>&nbsp;</th>
		</tr>
	    @foreach($users as $user)
	        <tr>
		        <td>[[$user->id]]</td>
		        <td>[[$user->username]]</td>
		        <td>[[$user->firstname]]</td>
		        <td>[[$user->lastname]]</td>
		        <td>
		        	@if ($user->is_admin)
		        		<i class="fa fa-check"></i>
		        	@endif
		        </td>
		        <td>[[$user->created_at]]</td>
		        <td>[[$user->updated_at]]</td>
		        <td>[[$user->deleted_at]]</td>
		        <td>[[ Form::checkbox('selected_users[]', $user->id) ]]
		    </tr>
	    @endforeach
	</table>
	[[ Form::close() ]]
</div>
