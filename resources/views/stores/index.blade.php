@extends('adminlte::page')
@section('title', 'Store List')
@section('content_header')
<h1>Store List</h1>
@stop
@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	<li class="active">Store List </li>
</ol>
@stop
@section('content')
	<store-list></store-list>
@stop
@section('js')
<script src="{{ asset('js/sortable.js') }}"></script>
@stop