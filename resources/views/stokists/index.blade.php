@extends('adminlte::page')
@section('title', 'Stokist List')
@section('content_header')
<h1>Stokist List</h1>
@stop
@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	<li class="active">Stokist List </li>
</ol>
@stop
@section('content')
	<stokist-list></stokist-list>
@stop
@section('js')
<script src="{{ asset('js/sortable.js') }}"></script>
@stop