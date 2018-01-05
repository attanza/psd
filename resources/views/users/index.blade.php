@extends('adminlte::page')
@section('title', 'User List')
@section('content_header')
<h1>User List</h1>
@stop
@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	<li class="active">User List </li>
</ol>
@stop
@section('content')
	<user-list></user-list>
@stop
@section('js')
<script src="{{ asset('js/sortable.js') }}"></script>
@stop