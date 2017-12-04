@extends('adminlte::page')
@section('title', 'Product List')
@section('content_header')
<h1>Product List</h1>
@stop
@section('breadcrumb')
<ol class="breadcrumb">
	<li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
	<li class="active">Product List </li>
</ol>
@stop
@section('content')
	<product-list></product-list>
@stop