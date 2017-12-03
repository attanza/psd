@extends('adminlte::master')
@section('adminlte_css')
<link rel="stylesheet"
  href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
  @stack('css')
  @yield('css')
  @stop
  @section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
  'boxed' => 'layout-boxed',
  'fixed' => 'fixed',
  'top-nav' => 'layout-top-nav'
  ][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))
  @section('body')
  <div id="app">
    <div class="wrapper">
      <header class="main-header">
        @if(config('adminlte.layout') == 'top-nav')
        <nav class="navbar navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
              </a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
              <i class="fa fa-bars"></i>
              </button>
            </div>
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
              <ul class="nav navbar-nav">
                @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
              </ul>
            </div>
            @else
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
              <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
              <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
              <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
              </a>
              @endif
              <div class="navbar-custom-menu">
                {{-- <profile-init :user="{{Auth::user()}}"></profile-init> --}}
                <ul class="nav navbar-nav">
                  <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <img src="{{Auth::user()->avatar}}" class="user-image" alt="{{Auth::user()->name}}">
                      <span class="hidden-xs">{{Auth::user()->name}}</span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- User image -->
                      <li class="user-header">
                        <img src="{{Auth::user()->avatar}}" class="img-circle" alt="User Image">

                        <p>
                          {{Auth::user()->name}}
                          {{-- <small>{{Auth::user()->getRole()}}</small> --}}
                        </p>
                      </li>
                      <!-- Menu Footer-->
                      <li class="user-footer">
                        <div class="pull-left">
                          <a href="{{ url('/profile') }}" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                          <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
              @if(config('adminlte.layout') == 'top-nav')
            </div>
            @endif
          </nav>
        </header>
        @if(config('adminlte.layout') != 'top-nav')
        <aside class="main-sidebar">
          <section class="sidebar">
            <ul class="sidebar-menu" data-widget="tree">
              @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
            </ul>
          </section>
        </aside>
        @endif
        <div class="content-wrapper">
          @if(config('adminlte.layout') == 'top-nav')
          <div class="container">
            @endif
            <section class="content-header">
              @yield('content_header')
              @yield('breadcrumb')
            </section>
            <section class="content">
              @yield('content')
            </section>
            @if(config('adminlte.layout') == 'top-nav')
          </div>
          @endif
        </div>
      </div>
      {{-- @include('slots.session_messages') --}}
    </div>
    @stop
    @section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
    @stop