@if( count($errors) > 0 )
	<div class="alert alert-danger" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<i class="ion-android-warning" aria-hidden="true"></i>
		{{ $errors->first() }}
	</div>
@endif