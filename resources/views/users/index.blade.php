@extends('layouts.app', ['title' => 'Users'])

@section('content')
<div class="scrollable-div content-div container">

	<h5 class="text-gold">Users</h5>
	<hr>
	<div class="row">
		<div class="col-12 col-md-8 col-lg-8 d-inline d-lg-none d-md-none">
			<button class="btn bgac-gold right mt-2 add_new_btn" type="button">
				<i class="fa fa-plus"></i>&nbsp;&nbsp;Add New User
			</button>
		</div>
		<div class="col-12 col-md-4 col-lg-4">
			<form action="/backend/users" method="GET" autocomplete="off">
				<table width="100%">
					<tr>
						<td>
							<input type="text" name="keyword" class="form-control border-gold mt-2" placeholder="Search user" value="{{$keyword}}">
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
				<i class="fa fa-plus"></i>&nbsp;&nbsp;Add New User
			</button>
		</div>
	</div>
	<br><br>
	<div id="overlay" hidden=""></div>
	<form class="sidepanel sidepanel-hidden bg-light user_form pr-4 pl-4 shadow" autocomplete="off">
		<span style="float: right !important; font-size: 1.5em !important; cursor: pointer" id="close_panel">
			<i class="fa fa-times"></i>
		</span>
		<br><br>
		<h4 id="title" class="text-gold"></h4>
		<hr>
		@csrf
		<div class="row justify-content-center">
			<div class="col-md-10 row p-0">
				<div class="form-group col-12 col-lg-6">
					<label>First Name</label>
					<input type="text" name="first_name" class="form-control" required placeholder="First Name" id="first_name">
				</div>
				<div class="form-group col-12 col-lg-6">
					<label>Middle Name</label>
					<input type="text" name="middle_name" class="form-control" placeholder="Middle Name" id="middle_name">
				</div>
				<div class="form-group col-12 col-lg-6">
					<label>Last Name</label>
					<input type="text" name="last_name" class="form-control" required placeholder="Last Name" id="last_name">
				</div>
				<div class="form-group col-12 col-lg-6">
					<label>Extension</label>
					<input type="text" name="extension" class="form-control" placeholder="Extension" id="extension">
				</div>
				<div class="form-group col-12">
					<label>Email</label>
					<input type="email" name="email" class="form-control" required placeholder="Email" id="email">
				</div>
				<div class="form-group col-12">
					<label>Address</label>
					<textarea name="address" class="form-control" placeholder="Address" id="address" rows="3"></textarea>
				</div>
				<div class="form-group col-12">
					<select name="access_level_id" class="form-control" required id="access_level_id">
						<option selected disabled value>Please select access level</option>
						@foreach($levels as $level)
						<option value="{{$level->id}}">{{$level->level}}</option>
						@endforeach
					</select>
				</div>
				<div class="col-12 mt-3">
					<button class="btn bgac-gold right">
						<i class="fa fa-save"></i> Save
					</button>
				</div>
			</div>
		</div>	
	</form>
	<div id="users">
		@foreach($users as $user)
		<div class="border shadow row m-0 mb-4 bg-light parent-{{$user->id}}">
			<div class="col-md-12 p-3">
				<span style="float: right !important; font-size: 1.2em !important; cursor: pointer">
					<i class="fa fa-pencil text-gold text-gold-hover edit-btn" value="{{$user->id}}" title="edit"></i>
					&nbsp;&nbsp;
					<i class="fa fa-trash text-gold text-gold-hover delete-btn" value="{{$user->id}}" title="delete"></i>
				</span>
				<h5 class="text-gold user-name">{{Str::limit($user->name, 50, $end = '...')}}</h5>
				<i class="user-level">{{$user->accessLevelId->level}}</i><br>
				<span class="user-email">{{$user->email}}</span><br>
				<span class="user-address">{{$user->address}}</span><br>
				<p class="smaller text-gold">
					Last updated by:<br>
					<span class="user-updated">
						{{$user->updatedBy->name ?? ''}}, 
						{{date('F d, Y, h:i:s A', strtotime($user->updated_at))}}
					</span>
				</p>
			</div>
		</div>
		@endforeach
	</div>
	<br>
	<center>
		@include('includes.paginate', ['variable' => $users])
	</center>
	<br>
</div>
<script type="text/javascript" src="/public/js/users.js"></script>
@endsection