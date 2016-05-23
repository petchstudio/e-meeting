@if( session('status') )
	<div class="alert alert-{{ session('class') ?:'info' }}" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<i class="ion-android-{{ session('icon') ?:'alert' }}" aria-hidden="true"></i>
		{{ session('message') }}
	</div>
@endif