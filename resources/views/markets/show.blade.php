@extends('adminlte::page')
@section('title', 'PSD ~ Market')
@section('content_header')
<h2>{{$market['name']}}</h2>
@stop
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li><a href="{{url('/markets')}}"><i class="fa fa-balance-scale"></i> Market List</a></li>
  <li class="active">{{$market['name']}}</li>
</ol>
@stop
@section('content')
<market-init :market="{{$market}}"></market-init>
<div class="row">
  <div class="col-md-6">
    <market-photo></market-photo>
  </div>
  <div class="col-md-6">
    <market-info :areas="{{$areas}}"></market-info>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <market-map></market-map>
  </div>
</div>
@stop