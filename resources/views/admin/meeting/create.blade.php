@extends('layouts.admin')

@section('script')
    @parent
@stop

@section('content-admin')
<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<h2 class="panel-title pull-left">
			<strong>เพิ่มการประชุม</strong>
		</h2>
		<div class="pull-right">
			<a href="{{ url('/admin/meeting') }}">การประชุมทั้งหมด</a>
		</div>
	</div>
	<div class="panel-body">

		@include('includes.alert-response-session')

		<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/meeting') }}" enctype="multipart/form-data">
			
			{{ csrf_field() }}

			<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">ชื่อการประชุม</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="name" value="{{ old('name') }}">

					@if ($errors->has('name'))
						<span class="help-block">
							<strong>{{ $errors->first('name') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">ประจำปี</label>
				<div class="col-md-6">
					<select class="selectpicker" name="year">
						@for($i=date('Y')+1; $i>=date('Y')-10; $i--)
							<option value="{{ $i }}"{{ old('year', date('Y')) == $i ? ' selected="selected"':''}}>{{ $i+543 }}</option>
						@endfor
					</select>

					@if ($errors->has('year'))
						<span class="help-block">
							<strong>{{ $errors->first('year') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('start-day') || $errors->has('start-month') || $errors->has('start-year') ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">วันเริ่มต้น</label>
				<div class="col-md-2">
					<select class="selectpicker" name="start-day" data-width="100%">
						<option disabled="disabled">วัน</option>
						@for($i=1; $i<=31; $i++)
							<option value="{{ $i }}"{{ old('start-day', date('j')) == $i ? ' selected="selected"':''}}>{{ $i }}</option>
						@endfor
					</select>
				</div>
				<div class="col-md-2">
					<select class="selectpicker" name="start-month" data-width="100%">
						@for($i=1; $i<=12; $i++)
							<option value="{{ $i }}"{{ old('start-month', date('n')) == $i ? ' selected="selected"':''}}>{{ $i }}</option>
						@endfor
					</select>
				</div>
				<div class="col-md-2">
					<select class="selectpicker" name="start-year" data-width="100%">
						@for($i=date('Y')+1; $i>=date('Y')-10; $i--)
							<option value="{{ $i }}"{{ old('start-year', date('Y')) == $i ? ' selected="selected"':''}}>{{ $i+543 }}</option>
						@endfor
					</select>

					@if ($errors->has('start-day') || $errors->has('start-month') || $errors->has('start-year'))
						<span class="help-block">
							<strong>{{ $errors->first('start-day') }} {{ $errors->first('start-month') }} {{ $errors->first('start-year') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">ไฟล์สำหรับการประชุม</label>
				<div class="col-md-6">
					<input type="file" name="file" >

					@if ($errors->has('file'))
						<span class="help-block">
							<strong>{{ $errors->first('file') }}</strong>
						</span>
					@endif
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" class="btn btn-primary">เพิ่มการประชุม</button>
				</div>
			</div>

		</form>
	</div>
</div>
@endsection
