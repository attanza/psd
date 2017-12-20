@extends('adminlte::page')
@section('title', 'Role List')
@section('content_header')
<h1>Role List</h1>
@stop
@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	<li class="active">Role List </li>
</ol>
@stop
@section('content')
	<role-list></role-list>
@stop
@section('js')
<script src="{{ asset('js/sortable.js') }}"></script>
@stop