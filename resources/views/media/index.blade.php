@extends('layouts.app', ['title' => 'Media'])

@section('content')
<div class="scrollable-div content-div container">

	<h5 class="text-gold">Media</h5>
	<hr>
	<div class="row">
		<div class="col-12 col-md-8 col-lg-8 d-inline d-lg-none d-md-none">
			<button class="btn bgac-gold right mt-2 add_new_btn" type="button">
				<i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Media
			</button>
		</div>
		<div class="col-12 col-md-4 col-lg-4">
			<form action="/backend/media" method="GET" autocomplete="off">
				<table width="100%">
					<tr>
						<td>
							<input type="text" name="keyword" class="form-control border-gold mt-2" placeholder="Search media" value="{{$keyword}}">
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
				<i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Media
			</button>
		</div>
	</div>
	<br><br>
	<div id="overlay" hidden=""></div>
	<form class="sidepanel sidepanel-hidden bg-light media_form pr-4 pl-4 shadow" autocomplete="off">
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
							<i class="fa fa-image"></i> Select Thumbnail
						</button>
					</center>
					<br>
				</div>
			</div>
			<div class="col-md-8">
				<div class="form-group">
					<label>Title</label>
					<input type="text" name="title" class="form-control" required placeholder="Media Title" id="media_title">
				</div>
				<div class="form-group">
					<label>Short Description (<span id="total_characters"></span>/<span id="characters_left"></span>)</label>
					<textarea name="description" class="form-control" required placeholder="Description" id="description" maxlength="100"></textarea>
				</div>
				<div class="form-group">
					<label>Link</label>
					<textarea name="link" class="form-control" placeholder="Link" id="link" rows="3"></textarea>
				</div>
				<div class="form-group">
					<label>Media Type</label>
					<select name="media_type" class="form-control" required id="media_type">
						<option value="" selected disabled>Select Media Type</option>
						<option value="1">Video</option>
						<option value="2">Article</option>
						<option value="3">Photo</option>
					</select>
				</div>
			</div>
			<div class="col-md-12">
				<button class="btn bgac-gold right">
					<i class="fa fa-save"></i> Save
				</button>
			</div>
		</div>	
	</form>
	<div id="media" class="row">
		@foreach($media as $medium)
		<div class="col-md-4 p-3 parent-{{$medium->id}}">
			<div class="border shadow">
				<div class="col-md-12 content-img view-img media-image mb-2" 
						src="/{{$medium->thumbnail}}" 
						style="background-image: url('/{{$medium->thumbnail}}');"
				></div>
				<div class="col-md-12">
					<span style="float: right !important; font-size: 1.2em !important; cursor: pointer">
						<i class="fa fa-pencil text-gold text-gold-hover edit-btn" value="{{$medium->id}}" title="edit"></i>
						&nbsp;&nbsp;
						<i class="fa fa-trash text-gold text-gold-hover delete-btn" value="{{$medium->id}}" title="delete"></i>
					</span>
					<h5 class="text-gold media-title">{{$medium->title}}</h5>
					<span class="media-description">{{$medium->description}}</span><br>
					<span class="media-type smaller text-muted">
						Media Type: {{$medium->media_type == 1 ? 'Video' : ($medium->media_type == 2 ? 'Article' : 'Photo')}}
					</span><br><br>
					<p class="smaller text-gold">
						Last updated by:<br>
						<span class="media-updated">
							{{$medium->updatedBy->name}}
							<br>
							{{date('F d, Y, h:i:s A', strtotime($medium->updated_at))}}
						</span>
					</p>
				</div>
			</div>
		</div>
		@endforeach
	</div>

	<br>
	<center>
		@include('includes.paginate', ['variable' => $media])
	</center>
	<br>
</div>
<script type="text/javascript" src="/public/js/media.js"></script>
<script type="text/javascript" src="/public/js/resize_image.js"></script>
@endsection