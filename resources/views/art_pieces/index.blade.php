@extends('layouts.app', ['title' => 'Art Pieces'])

@section('content')
<div class="scrollable-div content-div container">
	<h5 class="text-gold">Art Pieces</h5>
	<hr>
	<div class="row">
		<div class="col-12 col-md-8 col-lg-8 d-inline d-lg-none d-md-none">
			<a href="/backend/categories" class="btn bgac-gold mt-2 right"><i class="fa fa-list"></i>&nbsp;&nbsp;Browse Categories</a><br><br>
			<button class="btn bgac-gold mt-2 right add_new_btn" type="button"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Art Piece</button>
		</div>
		<div class="col-12 col-md-4 col-lg-4">
			<form action="/backend/art-pieces" method="GET" autocomplete="off">
				<table width="100%">
					<tr>
						<td>
							<input type="text" name="keyword" class="form-control border-gold mt-2" placeholder="Search art piece" value="{{$keyword}}">
						</td>
						<td width="1%" class="pl-3">
							<button class="btn bgac-gold mt-2"><i class="fa fa-search"></i></button>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div class="col-12 col-md-8 col-lg-8 d-none d-lg-inline d-md-inline">
			<div class="right">
				<a href="/backend/categories" class="btn bgac-gold mt-2"><i class="fa fa-list"></i>&nbsp;&nbsp;Browse Categories</a>
				<button class="btn bgac-gold mt-2 add_new_btn" type="button"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Art Piece</button>
			</div>
		</div>
	</div>
	<br><br>
	<div id="overlay" hidden=""></div>
	<form class="sidepanel sidepanel-hidden bg-light art_piece_form pr-4 pl-4 shadow" autocomplete="off">
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
						<span class="smaller text-gold">(must be in a landscape orientation)</span>
					</center>
					<br>
				</div>
			</div>
			<div class="col-md-8 row pr-0">
				<div class="col-md-12">
					<input type="checkbox" name="sold" value="1" id="sold">
					<label>Mark as Reserved</label>
				</div>

				<div class="form-group col-md-12">
					<label>Art Piece Title</label>
					<input type="text" name="title" class="form-control" required placeholder="Art Piece Title" id="art_piece_title">
				</div>

				<div class="form-group col-md-6">
					<label>Search Artist</label>
					<input type="hidden" id="artist_id" name="artist_id">
					<input type="text" id="artist_name" class="form-control" required placeholder="Search Artist">
				</div>	

				<div class="form-group col-md-6">
					<label>Select Category</label>
					<select class="form-control" name="category_id" id="category">
						<option value="" disabled selected>Select Category</option>
						@foreach($categories as $category)
						<option value="{{$category->id}}">{{$category->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-md-12">
					<label>Description</label>
					<textarea class="form-control" name="description" required placeholder="Description" id="description"></textarea>
				</div>
				
				<div class="form-group col-md-12">
					<label>Specification <span class="smaller text-gold">(medium and size)</span></label>
					<textarea class="form-control" name="specification" required placeholder="Specification" rows="3" id="specification"></textarea>
				</div>						
				<div class="form-group col-md-12">
					<button class="btn bgac-gold right">
						<i class="fa fa-save"></i> Save
					</button>
				</div>
			</div>
		</div>	
	</form>

	<div id="art_pieces">
		@foreach($art_pieces as $piece)
		<div class="border shadow p-4 row m-0 mb-4 bg-light parent-{{$piece->id}}">
			<div class="col-md-2 content-img view-img piece-image mb-2" 
					src="/{{$piece->image}}" 
					style="background-image: url('/{{$piece->image}}');"
			></div>
			<div class="col-md-10">
				<span style="float: right !important; font-size: 1.2em !important; cursor: pointer">
					<i class="fa fa-pencil text-gold text-gold-hover edit-btn" value="{{$piece->id}}" title="edit"></i>
					&nbsp;&nbsp;
					<i class="fa fa-trash text-gold text-gold-hover delete-btn" value="{{$piece->id}}" title="delete"></i>
				</span>
				<span style="font-size: 1.3em;" class="text-gold piece-title">{{$piece->title}}</span>
				&nbsp;&nbsp;<span class="badge bgac-red">{{$piece->sold == 1 ? 'Reserved' : ''}}</span>
				<br>
				<span class="smaller">
					by
					<span class="piece-artist">{{$piece->artistId->name ?? 'Deleted Artist Information'}} ({{$piece->categoryId->name ?? 'N/A'}})</span>
				</span>
				<br><br>
				<span class="piece-description">{{Str::limit($piece->description, 200, $end = '...')}}</span>
				<a href="#" class="text-primary smaller see_more" value="{{$piece->id}}">See More</a>
				<br><br>
				<p class="smaller text-gold">
					Last updated by:<br>
					<span class="piece-updated">
						{{$piece->updatedBy->name}}, {{date('F d, Y, h:i:s A', strtotime($piece->updated_at))}}
					</span>
				</p>
			</div>
		</div>
		@endforeach
	</div>
	<br>
	<center>
		@include('includes.paginate', ['variable' => $art_pieces])
	</center>
	<br>
</div>
<script type="text/javascript" src="/public/js/resize_image.js"></script>
<script type="text/javascript" src="/public/js/art_pieces.js"></script>
@endsection