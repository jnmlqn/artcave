@extends('layouts.app', ['title' => 'Menus'])

@section('content')
<div class="scrollable-div content-div container">

	<h5 class="text-gold">Menus</h5>
	<hr>
	<div class="row">
		<div class="col-12 col-md-8 col-lg-8 d-inline d-lg-none d-md-none">
			<button class="btn bgac-gold right mt-2 add_new_btn" type="button">
				<i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Menu
			</button>
		</div>
		<div class="col-12 col-md-4 col-lg-4">
			<form action="/backend/menus" method="GET" autocomplete="off">
				<table width="100%">
					<tr>
						<td>
							<input type="text" name="keyword" class="form-control border-gold mt-2" placeholder="Search menu" value="{{$keyword}}">
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
				<i class="fa fa-plus"></i>&nbsp;&nbsp;Add New Menu
			</button>
		</div>
	</div>
	<br><br>
	<div id="overlay" hidden=""></div>
	<form class="sidepanel sidepanel-hidden bg-light menu_form pr-4 pl-4 shadow" autocomplete="off">
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
					<label>Name</label>
					<input type="text" name="name" class="form-control" required placeholder="Menu Name" id="menu_name">
				</div>
				<div class="form-group">
					<label>Description</label>
					<textarea name="description" class="form-control" required placeholder="Description" id="description" rows="5"></textarea>
				</div>
				<div class="form-group">
					<select name="type" class="form-control" required id="menu_type">
						<option selected disabled value>Please select menu type</option>
						<option value="1">Food</option>
						<option value="2">Beverage</option>
					</select>
				</div>
			</div>
			<div class="col-md-8 mt-3">
				<button class="btn bgac-gold right">
					<i class="fa fa-save"></i> Save
				</button>
			</div>
		</div>	
	</form>
	<div id="menus">
		@foreach($menus as $menu)
		<div class="border shadow row m-0 mb-4 bg-light parent-{{$menu->id}}">
			<div class="col-md-12 p-3">
				<span style="float: right !important; font-size: 1.2em !important; cursor: pointer">
					<i class="fa fa-pencil text-gold text-gold-hover edit-btn" value="{{$menu->id}}" title="edit"></i>
					&nbsp;&nbsp;
					<i class="fa fa-trash text-gold text-gold-hover delete-btn" value="{{$menu->id}}" title="delete"></i>
				</span>
				<h5 class="text-gold menu-name">{{Str::limit($menu->name, 50, $end = '...')}}</h5>
				<i class="menu-type">{{$menu->type == 1 ? 'Food' : 'Beverage'}}</i><br>
				<span class="menu-description">{{Str::limit($menu->description, 200, $end = '...')}}</span>
				<br><br>
				<p class="smaller text-gold">
					Last updated by:<br>
					<span class="menu-updated">
						{{$menu->updatedBy->name}}, {{date('F d, Y, h:i:s A', strtotime($menu->updated_at))}}
					</span>
				</p>
			</div>
		</div>
		@endforeach
	</div>
	<br>
	<center>
		@include('includes.paginate', ['variable' => $menus])
	</center>
	<br>
</div>
<script type="text/javascript" src="/public/js/menus.js"></script>
@endsection