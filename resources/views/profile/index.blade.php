@extends('adminlte::page')
@section('title', $user->name)
@section('content_header')
<h2>{{$user->name}}</h2>
@stop
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="active">{{$user->name}}'s Profile</li>
</ol>
@stop
@section('content')
<profile-init :user="{{$user}}"></profile-init>
<div class="row">
  <div class="col-md-6">
    <profile-photo></profile-photo>
  </div>
  <div class="col-md-6">
    <profile-info></profile-info>
  </div>
</div>
@stop