@extends('layouts.app', ['title' => 'Promos and Events'])

@section('content')
<div class="scrollable-div content-div container">

	<h5 class="text-gold">Promos and Events</h5>
	<hr>
	<div class="row">
		<div class="col-12 col-md-8 col-lg-8 d-inline d-lg-none d-md-none">
			<button class="btn bgac-gold right mt-2 add_new_btn" type="button">
				<i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Promo/Event
			</button>
		</div>
		<div class="col-12 col-md-4 col-lg-4">
			<form action="/backend/promos-and-events" method="GET" autocomplete="off">
				<table width="100%">
					<tr>
						<td>
							<input type="text" name="keyword" class="form-control border-gold mt-2" placeholder="Search promos and events" value="{{$keyword}}">
						</td>
						<td width="1%" class="pl-3">
							<button class="btn bgac-gold mt-2"><i class="fa fa-search"></i></button>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div class="col-12 col-md-8 col-lg-8 d-none d-lg-inline d-md-inline">
			<button class="btn bgac-gold right mt-2 add_new_btn" type="button">
				<i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Promo/Event
			</button>
		</div>
	</div>
	<br><br>
	<div id="overlay" hidden=""></div>
	<form class="sidepanel sidepanel-hidden bg-light promo_form pr-4 pl-4 shadow" autocomplete="off">
		<span style="float: right !important; font-size: 1.5em !important; cursor: pointer" id="close_panel">
			<i class="fa fa-times"></i>
		</span>
		<br><br>
		<h4 id="title" class="text-gold"></h4>
		<hr>
		@csrf
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<input type="file" accept="image/*" id="_image_input" hidden>
					<center>
						<img loading="lazy" src="/img/no-image.png" class="data-image" id="_image">
						<button type="button" class="btn bgac-gold data-image mt-1" id="upload-btn">
							<i class="fa fa-image"></i> Select Image
						</button>
						<br>
						<span class="smaller text-gold">(must be 800x800 pixels in size)</span>
					</center>
					<br>
				</div>
			</div>
			<div class="col-md-8">
				<div class="form-group">
					<label>Title</label>
					<input type="text" name="title" class="form-control" required placeholder="Promo/Event Title" id="promo_title">
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea name="description" class="form-control" required placeholder="Description" id="description"></textarea>
				</div>
				<div class="form-group">
					<label>Expiration Date</label>
					<input type="date" name="expiration_date" class="form-control" required placeholder="Expiration Date" id="expiration_date">
				</div>
				<div class="form-check">
					<input type="checkbox" name="send_subscribers" class="form-check-input" value="1">
					<label>Send to subscribers</label>
				</div>
			</div>
			<div class="col-md-12">
				<button class="btn bgac-gold right">
					<i class="fa fa-save"></i> Save
				</button>
			</div>
		</div>	
	</form>
	<div id="promos" class="row">
		@foreach($promos as $promo)
		<div class="col-md-3 p-3 parent-{{$promo->id}}">
			<div class="border shadow">
				<div class="col-md-12 content-img view-img promo-image mb-2" 
						src="/{{$promo->image}}" 
						style="background-image: url('/{{$promo->image}}');"
				></div>
				<div class="col-md-12">
					<span style="float: right !important; font-size: 1.2em !important; cursor: pointer">
						<i class="fa fa-pencil text-gold text-gold-hover edit-btn" value="{{$promo->id}}" title="edit"></i>
						&nbsp;&nbsp;
						<i class="fa fa-trash text-gold text-gold-hover delete-btn" value="{{$promo->id}}" title="delete"></i>
					</span>
					<h5 class="text-gold promo-title">{{$promo->title}}</h5>
					<span class="promo-description">{{Str::limit($promo->description, 100, $end = '...')}}</span><br>
					<span class="promo-expiration smaller text-muted">
						Expiration Date: {{$promo->expiration_date ? date('M d, Y', strtotime($promo->expiration_date)) : 'N/A'}}
					</span><br><br>
					<p class="smaller text-gold">
						Last updated by:<br>
						<span class="promo-updated">
							{{$promo->updatedBy->name}}
							<br>
							{{date('F d, Y, h:i:s A', strtotime($promo->updated_at))}}
						</span>
					</p>
				</div>
			</div>
		</div>
		@endforeach
	</div>
	<br>
	<center>
		@include('includes.paginate', ['variable' => $promos])
	</center>
	<br>
</div>
<script type="text/javascript" src="/public/js/promos.js"></script>
<script type="text/javascript" src="/public/js/resize_image.js"></script>
@endsection