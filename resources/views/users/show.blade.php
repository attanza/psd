@extends('adminlte::page')
@section('title', $user->name)
@section('content_header')
<h2>{{$user->name}}</h2>
@stop
@section('breadcrumb')
<ol class="breadcrumb">
  <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li><a href="{{url('/users')}}"><i class="fa fa-user"></i> User List</a></li>

  <li class="active">{{$user->name}}'s Profile</li>
</ol>
@stop
@section('content')
<user-init :user="{{$user}}"></user-init>
<div class="row">
  <div class="col-md-6">
    <user-photo></user-photo>
  </div>
  <div class="col-md-6">
    <user-info></user-info>
  </div>
</div>
@stop