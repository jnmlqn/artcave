@extends('layouts.app', ['title' => 'Categories'])

@section('content')
<div class="scrollable-div content-div container">

	<h5 class="text-gold">Categories</h5>
	<hr>
	<div class="row">
		<div class="col-12 col-md-8 col-lg-8 d-inline d-lg-none d-md-none">
			<a href="/backend/art-pieces" class="btn bgac-gold mt-2 right"><i class="fa fa-list"></i>&nbsp;&nbsp;Browse Art Pieces</a><br><br>
			<button class="btn bgac-gold mt-2 right add_new_btn" type="button"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Category</button>
		</div>
		<div class="col-12 col-md-4 col-lg-4">
			<form action="/backend/art-pieces" method="GET" autocomplete="off">
				<table width="100%">
					<tr>
						<td>
							<input type="text" name="keyword" class="form-control border-gold mt-2" placeholder="Search category" value="{{$keyword}}">
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
				<a href="/backend/art-pieces" class="btn bgac-gold mt-2"><i class="fa fa-list"></i>&nbsp;&nbsp;Browse Art Pieces</a>
				<button class="btn bgac-gold mt-2 add_new_btn" type="button"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Category</button>
			</div>
		</div>
	</div>
	<br><br>
	<div id="overlay" hidden=""></div>
	<form class="sidepanel sidepanel-hidden bg-light category_form pr-4 pl-4 shadow" autocomplete="off">
		<span style="float: right !important; font-size: 1.5em !important; cursor: pointer" id="close_panel">
			<i class="fa fa-times"></i>
		</span>
		<br><br>
		<h4 id="title" class="text-gold"></h4>
		<hr>
		@csrf
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="form-group">
					<label>Category Name</label>
					<input type="text" name="name" class="form-control" required placeholder="Category Name" id="name">
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea name="description" class="form-control" required placeholder="Description" id="description" rows="5"></textarea>
				</div>
			</div>
			<div class="col-md-12">
				<center>
					<button class="btn bgac-gold" style="width: 150px;">
						<i class="fa fa-save"></i>&nbsp;&nbsp;&nbsp;Save
					</button>
				</center>
			</div>
		</div>	
	</form>
	<div id="categories">
		@foreach($categories as $category)
		<div class="border shadow p-4 m-0 mb-4 bg-light parent-{{$category->id}}">
			<div class="right">
				<h5>
					<i class="fa fa-pencil text-gold text-gold-hover edit-btn" value="{{$category->id}}" title="edit"></i>
					&nbsp;&nbsp;
					<i class="fa fa-trash text-gold text-gold-hover delete-btn" value="{{$category->id}}" title="delete"></i>	
				</h5>
			</div>
			<h5 class="category-name text-gold">{{$category->name}}</h5>
			<span class="category-description">{{$category->description}}</span>
			<br><br>
			<p class="smaller text-gold">
				Last updated by:<br>
				<span class="category-updated">
					{{$category->updatedBy->name}}, {{date('F d, Y, h:i:s A', strtotime($category->updated_at))}}
				</span>
			</p>
		</div>
		@endforeach
	</div>
	<br>
	<center>
		@include('includes.paginate', ['variable' => $categories])
	</center>
	<br>
</div>
<script type="text/javascript" src="/public/js/categories.js"></script>
@endsection