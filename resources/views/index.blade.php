<!DOCTYPE html>
<html>
@section('styles')
<link rel="stylesheet" type="text/css" href="/public/css/main.css">
@endsection
@include('includes.head', ['title' => $title ?? 'ARTCAVE'])
<body>
	@include('includes.mainnav')

	<div class="row">
		<div class="col-12 tagline-div text-light" data-aos="fade-in" data-aos-duration="1000">
			<center>
				<span class="tagline">A VISUAL AND GASTRONOMICAL RETREAT</span>
			</center>
		</div>
		<div class="col-12 bg-light p-5" data-aos="fade-up" data-aos-duration="1000">
			<div class="row justify-content-center">
				<div class="col-12 col-lg-5">
					<center>
						<h1 class="text-red">ARTCAVE</h1>
						<br>
						<h5>
							Get away from the daily hustle and bustle of the city and experience a treat that will feed not only your body, but also your soul.
						</h5>
					</center>
				</div>
			</div>
		</div>
		<div class="col-12 bgac-dust gallery-div">
			<div class="row">
				<div class="col-12 col-lg-6" data-aos="fade-up" data-aos-duration="1000" style="padding: 8%">
					<span class="text-black gallery-tagline"><b>THE GALLERY</b></span>
					<br><br>
					<span class="text-black gallery-subtitle">
						Appreciate the wide range of refreshing art pieces as it exhibits the abundance of creativity of our local artists.
					</span>
					<br><br>
					<a href="/the-gallery" class="btn bgac-black">VISIT GALLERY</a>
				</div>
				<div class="col-12 col-lg-6 p-0" data-aos="fade-up" data-aos-duration="1000">
					<img src="/assets/home-thegallery-low.jpg" class="gallery-img gallery">
				</div>
			</div>
		</div>
		<div class="col-12 bgac-dust gallery-div">
			<div class="row">
				<div class="col-12 col-lg-6 p-0 hide-on-small" data-aos="fade-up" data-aos-duration="1000">
					<img src="/assets/home-thecafe-low.jpg" class="gallery-img cafe">
				</div>
				<div class="col-12 col-lg-6" style="padding: 8%" data-aos="fade-up" data-aos-duration="1000">
					<span class="text-black gallery-tagline"><b>THE CAFE</b></span>
					<br><br>
					<span class="text-black gallery-subtitle">
						Complete your adventure by indulging in our delightful offerings, guaranteed fresh and full of flavor.
					</span>
					<br><br>
					<a href="/the-cafe" class="btn bgac-black">VISIT CAFE</a>
				</div>
				<div class="col-12 col-lg-6 p-0 show-on-small" data-aos="fade-up" data-aos-duration="1000">
					<img src="/assets/home-thecafe-low.jpg" class="gallery-img cafe">
				</div>
			</div>
		</div>
		<div class="col-12 bgac-gold counter-div">
			<div class="row">
				<div class="col-6 mb-4" data-aos="fade-up" data-aos-duration="1000">
					<center>
						<img loading="lazy" src="/assets/icons/no-of-artists.png" class="count-icon">
						<br><br>
						<h3 class="count counter-text">{{$artist}}</h3>
						<h5 class="counter-text">TOTAL NO. OF ARTISTS</h5>						
					</center>
				</div>
				<div class="col-6 mb-4" data-aos="fade-up" data-aos-duration="1000">
					<center>
						<img loading="lazy" src="/assets/icons/no-of-artworks.png" class="count-icon">
						<br><br>
						<h3 class="count counter-text">{{$artpiece}}</h3>
						<h5 class="counter-text">TOTAL NO. OF ARTWORKS</h5>							
					</center>
				</div>
			</div>
		</div>
		<div class="col-12 bgac-dust" data-aos="fade-up" data-aos-duration="1000">
			<video width="100%" height="100%" controls style="outline: none !important;" poster="/assets/homevideothumbnail.png">
				<source src="/assets/homevideo.mp4" type="video/mp4">
				Your browser does not support the video tag.
			</video>
		</div>
		<div class="col-12 bg-light p-5" data-aos="fade-up" data-aos-duration="1000">
			<center>
				<h1>PROMOS AND EVENTS</h1>
			</center>
			<div class="row justify-content-center promo-div">
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

		<!-- footer -->
		@include('includes.mainfooter')
	</div>
</body>
<script type="text/javascript">	
	var bgimage = new Image();
    bgimage.src = "/assets/home-header-webp.jpg";
    bgimage.onload = function(){
        $('.tagline-div').css('background-image', 'url(/assets/home-header-webp.jpg)')
    }

	var cafeimage = new Image();
    cafeimage.src = "/assets/home-thecafe-webp.jpg";
    cafeimage.onload = function(){
        $('.gallery-img.cafe').attr('src', '/assets/home-thecafe-webp.jpg')
    }

	var galleryimage = new Image();
    galleryimage.src = "/assets/home-thegallery-webp.jpg";
    galleryimage.onload = function(){
        $('.gallery-img.gallery').attr('src', '/assets/home-thegallery-webp.jpg')
    }
</script>
</html>