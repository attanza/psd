@extends('adminlte::page')
@section('title', 'Target List')
@section('content_header')
<h1>Target List</h1>
@stop
@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	<li class="active"><i class="fa fa-bulllseye"></i> Target List </li>
</ol>
@stop
@section('content')
	<sell-target-list :products="{{$products}}"></sell-target-list>
@stop
@section('js')
<script src="{{ asset('js/sortable.js') }}"></script>
@stop