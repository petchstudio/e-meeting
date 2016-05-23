@extends('layouts.basic-template')

@section('link')
    @parent
    <link href="{{ asset('assets/javascripts/plugins/bootstrap-sweetalert/lib/sweet-alert.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/javascripts/plugins/jquery.bootgrid/1.3.1/jquery.bootgrid.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/javascripts/plugins/silviomoreto-bootstrap-select/1.7.2-0/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
@stop

@section('script')
    @parent
    <script src="{{ asset('assets/javascripts/plugins/bootstrap-sweetalert/lib/sweet-alert.min.js') }}"></script>
    <script src="{{ asset('assets/javascripts/plugins/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/javascripts/plugins/jquery.bootgrid/1.3.1/jquery.bootgrid.min.js') }}"></script>
    <script src="{{ asset('assets/javascripts/plugins/silviomoreto-bootstrap-select/1.7.2-0/dist/js/bootstrap-select.min.js') }}"></script>
@stop

@section('container')
    @include('includes.header')
    
    @yield('content')

    @section('footer')
        @include('includes.footer')
    @show
@endsection
