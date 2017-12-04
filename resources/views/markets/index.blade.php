@extends('adminlte::page')
@section('title', 'Market List')
@section('content_header')
<h1>Market List</h1>
@stop
@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	<li class="active">Market List </li>
</ol>
@stop
@section('content')
	<market-list></market-list>
@stop
@section('js')
<script src="{{ asset('js/sortable.js') }}"></script>
@stop