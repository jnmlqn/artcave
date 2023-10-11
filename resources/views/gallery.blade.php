<!DOCTYPE html>
<html>
@section('styles')
<link rel="stylesheet" type="text/css" href="/public/css/main.css">
@endsection
@include('includes.head', ['title' => $title ?? 'ARTCAVE'])
<body>
	@include('includes.mainnav')
	<div class="row">
		<div class="col-12 bg-light p-5" style="margin-top: 70px;">
			<center><h2><b>THE GALLERY</b></h2></center>
			<form class="float-none float-lg-right" action="/the-gallery">
				<center>
					<select class="gallery-input mt-2" onchange="this.form.submit()" name="category">
						<option value="" selected disabled>FILTER BY</option>
						<option value="">All</option>
						@foreach($categories as $cat)
						<option value="{{$cat->id}}" {{$category == $cat->id ? 'selected' : ''}}>{{$cat->name}}</option>
						@endforeach
					</select>
					<span class="hide-sm">&nbsp;&nbsp;</span>
					<span class="show-sm"><br></span>
					<input type="text" class="gallery-input mt-2" name="artist" placeholder="Search Artist Name" value="{{$artist ?? ''}}">
					<span class="hide-sm">&nbsp;&nbsp;</span>
					<span class="show-sm"><br></span>
					<input type="radio" class="checkbox-cb" name="filter" value="2" {{$filter == 2 ? 'checked' : ''}} onchange="this.form.submit()">
					&nbsp;&nbsp;
					<span class="checkbox-label">ALL</span>
					<span class="hide-sm">&nbsp;&nbsp;</span>
					<span class="show-sm"><br></span>
					<input type="radio" class="checkbox-cb" name="filter" value="0" {{$filter == 0 ? 'checked' : ''}} onchange="this.form.submit()">
					&nbsp;&nbsp;
					<span class="checkbox-label">AVAILABLE</span>
					<span class="hide-sm">&nbsp;&nbsp;</span>
					<span class="show-sm"><br></span>
					<input type="radio" class="checkbox-cb" name="filter" value="1" {{$filter == 1 ? 'checked' : ''}} onchange="this.form.submit()">
					&nbsp;&nbsp;
					<span class="checkbox-label">RESERVED</span>
				</center>
			</form>
			<span class="hide-sm"><br><br><br></span>
			<div class="row">
				@foreach($artpieces as $artpiece)
				<div class="col-md-3 p-0" data-aos="fade-up" data-aos-duration="1000">
					<div class="bg-light overlay-hover shadow {{$artpiece->sold == 1 ? 'sold' : ''}}" 
						style="height: 250px;
								background-image: url({{$artpiece->image}});
								background-size: cover;
						"
					>
						<div class="overlay" style="margin-top: auto; margin-bottom: auto;">
							<div class="helper">
								<div class="content">
									<center>
										<h4 class="text-dust" style="text-transform: uppercase;">
											{{Str::limit($artpiece->title, 100, $end = '...')}}
										</h4>
										<h6 class="text-dust">
											{{$artpiece->artistId->name ?? 'N/A'}}
										</h6>
										<h6 class="text-light" href="/">{{Str::limit($artpiece->specification, 200, $end = '...')}}</h6>
										<span class="text-gold view-artpiece pointer"
											src="{{$artpiece->image}}"
											artpiece_id="{{$artpiece->id}}"
											art_title="{{$artpiece->title}}"
											specification="{{$artpiece->specification}}"
											description="{{$artpiece->description}}"
											sold="{{$artpiece->sold}}"
											artist="{{$artpiece->artistId->name ?? 'N/A'}}"
											category="{{$artpiece->categoryId->name ?? 'N/A'}}"
										>View full image</span>
									</center>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
			<br>
			<center>
				@include('includes.paginate', ['variable' => $artpieces])
			</center>
		</div>

		<!-- footer -->
		@include('includes.mainfooter')
	</div>
</body>
<script src="https://www.google.com/recaptcha/api.js"></script>
</html>