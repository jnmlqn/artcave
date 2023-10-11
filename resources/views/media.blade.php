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
			<center><h2><b>MEDIA</b></h2></center>
			<br>
			<form class="row justify-content-center" action="/media">
				<div class="col-12 col-md-8 col-lg-7">
					<div class="row">
						<div class="col-md-3">
							<center>
								<h4>
									<a href="/media" class="{{$filter == 0 ? 'text-gold' : 'text-black'}}">
										ALL
									</a>
								</h4>
							</center>
						</div>
						<div class="col-md-3">
							<center>
								<h4>
									<a href="/media?filter=3" class="{{$filter == 3 ? 'text-gold' : 'text-black'}}">
										PHOTOS
									</a>
								</h4>
							</center>
						</div>
						<div class="col-md-3">
							<center>
								<h4>
									<a href="/media?filter=1" class="{{$filter == 1 ? 'text-gold' : 'text-black'}}">
										VIDEOS
									</a>
								</h4>
							</center>
						</div>
						<div class="col-md-3">
							<center>
								<h4>
									<a href="/media?filter=2" class="{{$filter == 2 ? 'text-gold' : 'text-black'}}">
										ARTICLES
									</a>
								</h4>
							</center>
						</div>
					</div>
				</div>
			</form>
			<br><br>
			<div class="row">
				@foreach($media as $medium)
				<div class="col-md-3 p-0" data-aos="fade-up" data-aos-duration="1000">
					<div class="bg-light overlay-hover shadow" 
						style="height: 250px;
								background-image: url({{$medium->thumbnail}});
								background-size: cover;
								position: relative
						"
					>
						<div class="overlay-hover-hide">
							<span class="text-dust">{{Str::limit($medium->title, 50, $end = '...')}}</span><br>
							<span class="smaller text-dust">{{date('M d, Y', strtotime($medium->created_at))}}</span>
						</div>
						<div class="overlay">
							<div class="helper">
								<div class="pr-3 pl-3">
									<h4 class="text-dust" style="text-transform: uppercase;">
										{{Str::limit($medium->title, 100, $end = '...')}}
									</h4>
									<h6 class="text-dust">
										{{date('M d, Y', strtotime($medium->created_at))}}
									</h6>
									<h6 class="text-light" href="/">{{Str::limit($medium->description, 200, $end = '...')}}</h6>
									@if($medium->media_type == 1)
										<span class="text-gold pointer view-media" src="{{$medium->link}}" media_type="{{$medium->media_type}}">
											Watch Video
										</span>
									@elseif($medium->media_type == 3)
										<span class="text-gold pointer view-media" src="{{$medium->thumbnail}}" media_type="{{$medium->media_type}}">
											View Full Image
										</span>
									@else
										<a class="text-gold pointer" href="{{$medium->link}}" target="_blank">
											Read Article
										</a>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
			<br>
			<center>
				@include('includes.paginate', ['variable' => $media])
			</center>
		</div>

		<!-- footer -->
		@include('includes.mainfooter')
	</div>
</body>
</html>