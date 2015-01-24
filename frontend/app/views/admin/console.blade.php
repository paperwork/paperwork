@extends("layouts/user-layout")
@section("content")
<div class="container">
	<h1>[[Lang::get('keywords.users')]]</h1>
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
		    </tr>
	    @endforeach
	</table>
</div>
