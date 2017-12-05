@extends('adminlte::page')
@section('title', 'PSD ~ Store')
@section('content_header')
<h2>{{$store['name']}}</h2>
@stop
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li><a href="{{url('/stores')}}"><i class="fa fa-building-o"></i> Store List</a></li>
  <li class="active">{{$store['name']}}</li>
</ol>
@stop
@section('content')
<store-init :store="{{$store}}"></store-init>
<div class="row">
  <div class="col-md-6">
    <store-photo></store-photo>
  </div>
  <div class="col-md-6">
    <store-info></store-info>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <store-map></store-map>
  </div>
</div>
@stop