@extends("layouts/user-layout")
@section("content")

<div class="container-fluid">
<h2>Do you need help, [[ Auth::user()->firstname ]]?</h2>
<p>No problem!</p>
</div>

@stop