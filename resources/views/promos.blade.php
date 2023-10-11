<!DOCTYPE html>
<html>
@section('styles')
<link rel="stylesheet" type="text/css" href="/public/css/main.css">
@endsection
@include('includes.head', ['title' => $title ?? 'ARTCAVE'])
<body>
	@include('includes.mainnav')
	<div class="row">
		<div class="col-12 promo-events-div text-light" data-aos="fade-in" data-aos-duration="1000"></div>
		<div class="col-12 bg-light p-5" data-aos="fade-up" data-aos-duration="1000">
			<div class="row justify-content-center">
				<div class="col-12 col-lg-7">
					<center>
						<h3 class="text-gold">PROMO AND EVENTS</h3>
						<b>
							Discover our special offers and the latest news.
						</b>
					</center>
				</div>
			</div>
		</div>
		<div class="col-12 bg-light pr-3 pl-3 pb-3">
			<div class="row justify-content-center">
				<div class="col-10 col-lg-8 row">
					@foreach($promos as $promo)
					<div class="col-md-4 mb-3" data-aos="fade-up" data-aos-duration="1000">
						<div class="bg-light overlay-hover border-gold">
							<div class="overlay p-3" style="margin-top: auto; margin-bottom: auto;">
								<div class="helper">
									<div class="content">
										<center>
											<h5 class="text-dust">
												{{Str::limit($promo->title, 100, $end = '...')}}
												<br>
												<span class="smaller">
													<span style="font-style: italic;">
														{{$promo->expiration_date ? date('M d, Y', strtotime($promo->expiration_date)) : 'No Expiration Date'}}
													</span>
													<br><br>
													{{Str::limit($promo->description, 100, $end = '...')}}
												</span>
												<br><br>
												<a class="text-light pointer view-promo"
													src="{{$promo->image}}"
													promo_title="{{$promo->title}}"
													description="{{$promo->description}}"
													expiration_date="{{$promo->expiration_date ? date('M d, Y', strtotime($promo->expiration_date)) : 'No Expiration Date'}}">
												MORE</a>
											</h5>
											
										</center>
									</div>
								</div>
							</div>

							<img loading="lazy" src="{{$promo->image}}" class="border-bottom" width="100%">
							<div class="p-2">
								<center>
									<h4 class="text-gold">{{Str::limit($promo->title, 20, $end = '...')}}</h4>
									<p>{{$promo->expiration_date ? date('M d, Y', strtotime($promo->expiration_date)) : 'No Expiration Date'}}</p>
								</center>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
			<br>
			<center>
				@include('includes.paginate', ['variable' => $promos])
			</center>
			<br>
		</div>

		<!-- footer -->
		@include('includes.mainfooter')
	</div>
</body>
<script type="text/javascript">	
	var bgimage = new Image();
    bgimage.src = "/assets/promoevents-header-webp.jpg";
    bgimage.onload = function(){
        $('.promo-events-div').css('background-image', 'url(/assets/promoevents-header-webp.jpg)')
    }
</script>
</html>