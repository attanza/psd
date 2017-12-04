@extends('adminlte::page')
@section('title', 'Product')
@section('content_header')
<h2>{{$product['name']}}</h2>
@stop
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li><a href="{{url('/products')}}"><i class="fa fa-dropbox"></i> Product List</a></li>
  <li class="active">{{$product['name']}}</li>
</ol>
@stop
@section('content')
<product-init :product="{{$product}}"></product-init>
<div class="row">
  <div class="col-md-6">
    <product-photo></product-photo>
  </div>
  <div class="col-md-6">
    <product-info></product-info>
  </div>
</div>
@stop