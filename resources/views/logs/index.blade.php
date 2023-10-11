@extends('layouts.app', ['title' => 'Home'])

@section('content')
<div class="scrollable-div content-div container">

	<h5 class="text-gold">Logs</h5>

	<hr>

	<div id="logs" class="border">
		@foreach($logs as $log)
		<div class="border-bottom p-4 m-0 bg-light">
			<b><span class="text-gold">{{$log->userId->name}}</span></b><br>
			{{$log->action}}<br>
			<span class="text-gold smaller">{{date('F d, Y h:i:s A', strtotime($log->created_at))}}</span>
		</div>
		@endforeach
	</div>
	<br>
	<center>
		@include('includes.paginate', ['variable' => $logs])
	</center>
	<br>
</div>
@endsection