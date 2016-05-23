@extends('layouts.admin')

@section('script')
    @parent
@stop

@section('content-admin')
<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<h2 class="panel-title pull-left">
			<strong>แก้ไขตำแหน่งการประชุม</strong>
		</h2>
		<div class="pull-right">
			<a href="{{ url('/admin/position') }}">ตำแหน่งการประชุมทั้งหมด</a>
		</div>
	</div>
	<div class="panel-body">

		@include('includes.alert-response-session')

		<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/position/'.$meeting->id) }}">
			
			{{ csrf_field() }}
			{{ method_field('PUT') }}
			
			<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
				<label class="col-md-3 control-label">ชื่อตำแหน่งการประชุม</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="name" value="{{ old('name', $meeting->name) }}">

					@if ($errors->has('name'))
						<span class="help-block">
							<strong>{{ $errors->first('name') }}</strong>
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
