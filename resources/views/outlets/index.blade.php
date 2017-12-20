@extends('adminlte::page')
@section('title', 'Outlet List')
@section('content_header')
<h1>Outlet List</h1>
@stop
@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	<li class="active">Outlet List </li>
</ol>
@stop
@section('content')
	<outlet-list></outlet-list>
@stop
@section('js')
<script src="{{ asset('js/sortable.js') }}"></script>
@stop