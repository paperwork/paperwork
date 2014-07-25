@extends("layouts/user-layout")
@section("content")

<div class="container-fluid">
<h2>[[ Auth::user()->username ]]</h2>
<p>Welcome to your sparse settings page.</p>
</div>

@stop