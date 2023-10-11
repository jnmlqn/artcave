@extends('layouts.app', ['title' => 'Artists'])

@section('content')
<div class="scrollable-div content-div container">

	<h5 class="text-gold">Artists</h5>
	<hr>
	<div class="row">
		<div class="col-12 col-md-8 col-lg-8 d-inline d-lg-none d-md-none">
			<button class="btn bgac-gold right mt-2 add_new_btn" type="button">
				<i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Artist
			</button>
		</div>
		<div class="col-12 col-md-4 col-lg-4">
			<form action="/backend/artists" method="GET" autocomplete="off">
				<table width="100%">
					<tr>
						<td>
							<input type="text" name="keyword" class="form-control border-gold mt-2" placeholder="Search artist" value="{{$keyword}}">
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
				<i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Artist
			</button>
		</div>
	</div>
	<br><br>
	<div id="overlay" hidden></div>
	<form class="sidepanel sidepanel-hidden bg-light art_piece_form pr-5 pl-5 shadow" autocomplete="off">
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
					</center>
					<br>
				</div>
			</div>
			<div class="col-md-8">
				<div class="form-group">
					<label>Artist Name</label>
					<input type="text" name="artist_name" class="form-control" required placeholder="Artist Name" id="artist_name">
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea class="form-control" name="description" required placeholder="Description" id="description"></textarea>
				</div>
			</div>
			<div class="col-md-12">
				<button class="btn bgac-gold right">
					<i class="fa fa-save"></i> Save
				</button>
			</div>
		</div>	
	</form>
	<div id="artists">
		@foreach($artists as $artist)
		<div class="border shadow p-4 row m-0 mb-4 bg-light parent-{{$artist->id}}">
			<div class="col-md-2">
				<center><img loading="lazy" src="/{{$artist->image}}" class="artist-image view-img mb-2 data-image" style="cursor: pointer;"></center>
			</div>
			<div class="col-md-10">
				<span style="float: right !important; font-size: 1.2em !important; cursor: pointer">
					<i class="fa fa-pencil text-gold text-gold-hover edit-btn" value="{{$artist->id}}" title="edit"></i>
					&nbsp;&nbsp;
					<i class="fa fa-trash text-gold text-gold-hover delete-btn" value="{{$artist->id}}" title="delete"></i>
				</span>
				<h5 class="text-gold artist-name">{{$artist->name}}</h5>
				<span class="artist-description">{{$artist->description}}</span><br><br>
				<p class="smaller text-gold">
					Last updated by:<br>
					<span class="artist-updated">
						{{$artist->updatedBy->name}}, {{date('F d, Y, h:i:s A', strtotime($artist->updated_at))}}
					</span>
				</p>
			</div>
		</div>
		@endforeach
	</div>
	<br>
	<center>
		@include('includes.paginate', ['variable' => $artists])
	</center>
	<br>
</div>
<script type="text/javascript" src="/public/js/artists.js"></script>
<script type="text/javascript" src="/public/js/resize_image.js"></script>
@endsection