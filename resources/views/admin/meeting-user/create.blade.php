@extends('layouts.admin')

@section('script')
    @parent
@stop

@section('content-admin')
<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<h2 class="panel-title pull-left">
			<strong>เพิ่มผู้เข้าร่วมประชุม</strong>
		</h2>
		<div class="pull-right">
			<a href="{{ url('/admin/meeting/'. $meeting->id .'/user') }}">รายชื่อผู้เข้าร่วมประชุมทั้งหมด</a>
		</div>
	</div>
	<div class="panel-body">

		@include('includes.alert-response-session')

		<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/meeting/'. $meeting->id .'/user') }}">
			
			{{ csrf_field() }}

			<div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">ตำแหน่งที่ประชุม</label>
				<div class="col-md-6">
					<select class="selectpicker" name="position" data-live-search="true">
						@foreach(App\Position::where('created_by', Auth::user()->getKey())->get() as $value)
							<option value="{{ $value->id }}"{{ old('position') == $value->id ? ' selected="selected"':''}}>{{ $value->name }}</option>
						@endforeach
					</select>

					@if ($errors->has('position'))
						<span class="help-block">
							<strong>{{ $errors->first('position') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('user') ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">ผู้ใช้</label>
				<div class="col-md-6">
					<select class="selectpicker" name="user" data-live-search="true">
						@foreach(App\User::all() as $value)
							<option value="{{ $value->id }}"{{ old('user') == $value->id ? ' selected="selected"':''}}>{{ $value->prefix.$value->firstname }} {{ $value->lastname }}</option>
						@endforeach
					</select>

					@if ($errors->has('user'))
						<span class="help-block">
							<strong>{{ $errors->first('user') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" class="btn btn-primary">เพิ่มผู้ใช้</button>
				</div>
			</div>

		</form>
	</div>
</div>
@endsection
