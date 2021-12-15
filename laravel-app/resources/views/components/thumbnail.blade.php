<div>
	@if(empty($employee->filename))
		<img src="{{ asset('images/noimage.png') }}">
	@else
		<img src="{{ asset('storage/images/' . $employee->filename) }}">
	@endif
</div>
