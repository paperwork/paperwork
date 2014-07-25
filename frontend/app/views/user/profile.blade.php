@extends("layouts/user-layout")
@section("content")

<div class="container-fluid">
<h2>Hello [[ Auth::user()->firstname ]]!</h2>
<p>Welcome to your sparse profile page.</p>
</div>

@stop