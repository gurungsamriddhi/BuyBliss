@extends('adminlte::page')

@section('title', 'Admin Dashboard')

{{--@section('content_header')
    <h1>{{'Admin Dashboard '}}</h1>
@stop--}}

@section('content')
    @yield('admin_content')
@stop

@section('css')
    <!-- Add custom AdminLTE CSS tweaks if needed -->
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

@stop

@section('js')
    <!-- Add AdminLTE-specific JavaScript if needed -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('js/admin-custom.js') }}"></script>
@stop