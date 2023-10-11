@extends('layouts.app', ['title' => 'Subsribers'])

@section('content')
<div class="scrollable-div content-div container">

	<h5 class="text-gold">Subsribers</h5>
	<hr>
	<div style="overflow-x: scroll">
		<table class="table bg-light border">
			<tr>
				<th width="20%">Name</th>
				<th width="20%">Email/Contact No.</th>
				<th width="15%">Status</th>
				<th width="20%">Subscribed at</th>
				<th width="20%">Last updated at</th>
				<th width="5%">Action</th>
			</tr>
			@foreach($subscribers as $subscriber)
			<tr id="parent-{{$subscriber->id}}">
				<td>{{$subscriber->name}}</td>
				<td>
					{{$subscriber->email}}<br>
					{{$subscriber->contact_number ?? 'Contact number unavailable'}}
				</td>
				<td>{{$subscriber->subscribed ? 'Subscribed' : 'Unsubscribed'}}</td>
				<td>{{date('M d, Y, h:i:s A', strtotime($subscriber->created_at))}}</td>
				<td>{{date('M d, Y, h:i:s A', strtotime($subscriber->updated_at))}}</td>
				<td>
					<center>
						<i class="fa fa-trash text-gold text-gold-hover delete-btn" value="{{$subscriber->id}}" title="delete"></i>
					</center>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
	<br>
	<center>
		@include('includes.paginate', ['variable' => $subscribers])
	</center>
	<br>
</div>
<script type="text/javascript" src="/public/js/subscribers.js"></script>
@endsection