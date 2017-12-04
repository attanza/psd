@extends('adminlte::page')
@section('title', 'PSD ~ Stokist')
@section('content_header')
<h2>{{$stokist['name']}}</h2>
@stop
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li><a href="{{url('/stokists')}}"><i class="fa fa-building"></i> Stokist List</a></li>
  <li class="active">{{$stokist['name']}}</li>
</ol>
@stop
@section('content')
<stokist-init :stokist="{{$stokist}}"></stokist-init>
<div class="row">
  <div class="col-md-6">
    <stokist-photo></stokist-photo>
  </div>
  <div class="col-md-6">
    <stokist-info :areas="{{$areas}}"></stokist-info>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <stokist-map></stokist-map>
  </div>
</div>
@stop