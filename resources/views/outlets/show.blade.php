@extends('adminlte::page')
@section('title', 'PSD ~ Outlet')
@section('content_header')
<h2>{{$outlet['name']}}</h2>
@stop
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li><a href="{{url('/outlets')}}"><i class="fa fa-shopping-cart"></i> Outlet List</a></li>
  <li class="active">{{$outlet['name']}}</li>
</ol>
@stop
@section('content')
<outlet-init :outlet="{{$outlet}}"></outlet-init>
<div class="row">
  <div class="col-md-6">
    <outlet-photo></outlet-photo>
  </div>
  <div class="col-md-6">
    <outlet-info></outlet-info>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <outlet-map></outlet-map>
  </div>
</div>
@stop