@extends("layouts/user-layout")
@section("content")
<div class="container">
	<h1>Users</h1>
	<table class="table">
		<tr>
			<th>ID</th>
			<th>Username</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Admin Status</th>
			<th>Created At</th>
			<th>Updated At</th>
			<th>Deleted At</th>
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