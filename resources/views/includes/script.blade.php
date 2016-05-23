<?php
$scripts = [
	'assets/javascripts/jquery-1.11.3.min.js',
	'assets/javascripts/app.min.js',
];
?>
@section('script')
	@foreach ($scripts as $key => $value)
		<script src="{{ asset($value) }}"></script>
	@endforeach
@show

<script src="{{ asset('assets/javascripts/init.js') }}"></script>