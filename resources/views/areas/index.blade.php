@extends('adminlte::page')
@section('title', 'Area List')
@section('content_header')
<h1>Area List</h1>
@stop
@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	<li class="active">Area List </li>
</ol>
@stop
@section('content')
	<area-list></area-list>
@stop
@section('js')
<script src="{{ asset('js/sortable.js') }}"></script>
@stop