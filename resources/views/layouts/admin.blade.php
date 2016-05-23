@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">

            <div class="panel panel-default">
                <div class="panel-heading">เมนู{{--ตั้งค่าการประชุม--}}</div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="{{ url('/admin/users') }}">ผู้ใช้งาน</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ url('/admin/position') }}">ตำแหน่งการประชุม</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ url('/admin/meeting') }}">การประชุม</a>
                    </li>
                </ul>
            </div>
{{--
            <div class="panel panel-default">
                <div class="panel-heading">ก่อนการประชุม</div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="{{ url('/admin') }}">จัดการประชุม</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ url('/admin') }}">ระเบียบวาระการประชุม</a>
                    </li>
                </ul>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">ระหว่างการประชุม</div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="{{ url('/admin') }}">บันทึกรายละเอียดการประชุม</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ url('/admin') }}">บันทึกมิติการประชุม</a>
                    </li>
                </ul>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">หลังการประชุม</div>
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="{{ url('/admin') }}">รายงานการประชุม</a>
                    </li>
                </ul>
            </div>
--}}
        </div>
        <div class="col-md-9">
            @yield('content-admin')
        </div>
    </div>
</div>
@endsection
