<?php
$links = [
	//'assets/stylesheets/....css',
];
?>
@section('link')
	@foreach ($links as $key => $value)
		<link href="{{ asset($value) }}" rel="stylesheet">
	@endforeach
	<link href="{{ asset('assets/stylesheets/app.css') }}" rel="stylesheet">
@show