@extends("layouts/guest-layout")
@section("content")

@include("partials/registration-form", array('back' => true, 'frominstaller' => false))

@stop