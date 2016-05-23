@extends('layouts.admin')

@section('script')
    @parent
@stop

@section('content-admin')
<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<h2 class="panel-title pull-left">
			<strong>แก้ไขผู้ใช้งาน</strong>
		</h2>
		<div class="pull-right">
			<a href="{{ url('/admin/users') }}">ผู้ใช้งานทั้งหมด</a>
		</div>
	</div>
	<div class="panel-body">

		@include('includes.alert-response-session')

		<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/users/'.$user->id) }}">
			
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			
			<div class="form-group{{ $errors->has('prefix') ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">คำนำหน้า</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="prefix" value="{{ old('prefix', $user->prefix) }}">

					@if ($errors->has('prefix'))
						<span class="help-block">
							<strong>{{ $errors->first('prefix') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">ชื่อ</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="firstname" value="{{ old('firstname', $user->firstname) }}">

					@if ($errors->has('firstname'))
						<span class="help-block">
							<strong>{{ $errors->first('firstname') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">นามสกุล</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="lastname" value="{{ old('lastname', $user->lastname) }}">

					@if ($errors->has('lastname'))
						<span class="help-block">
							<strong>{{ $errors->first('lastname') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">ตำแหน่ง</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="position" value="{{ old('position', $user->position) }}">

					@if ($errors->has('position'))
						<span class="help-block">
							<strong>{{ $errors->first('position') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('belong-to') ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">หน่วยงานที่สังกัด</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="belong-to" value="{{ old('belong-to', $user->belong_to) }}">

					@if ($errors->has('belong-to'))
						<span class="help-block">
							<strong>{{ $errors->first('belong-to') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">อีเมล</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}">

					@if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">เบอร์โทรศัพท์มือถือ</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="mobile" value="{{ old('mobile', $user->mobile) }}">

					@if ($errors->has('mobile'))
						<span class="help-block">
							<strong>{{ $errors->first('mobile') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">เบอร์โทรศัพท์</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="telephone" value="{{ old('telephone', $user->telephone) }}">

					@if ($errors->has('telephone'))
						<span class="help-block">
							<strong>{{ $errors->first('telephone') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">ชื่อผู้ใช้</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="username" value="{{ old('username', $user->username) }}">

					@if ($errors->has('username'))
						<span class="help-block">
							<strong>{{ $errors->first('username') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" class="btn btn-primary">บันทึก</button>
				</div>
			</div>

		</form>
	</div>
</div>
@endsection
