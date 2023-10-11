<!DOCTYPE html>
<html>
@section('styles')
<link rel="stylesheet" type="text/css" href="/public/css/main.css">
<link rel="stylesheet" type="text/css" href="/public/css/slider/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="/public/css/slider/owl.theme.default.min.css">
@endsection
@include('includes.head', ['title' => $title ?? 'ARTCAVE'])
<body>
	@include('includes.mainnav')
	<div class="row">
		<div class="col-12 bg-light" style="margin-top: 70px;">
			<div class="row">
				<div class="col-12 col-lg-7 p-0" data-aos="fade-in" data-aos-duration="1000">
					<div class="owl-carousel owl-theme">
						<div class="item" data-merge="6">
							<img class="slider-img" src="/assets/about-us/about1-webp.jpg">
						</div>
						<div class="item" data-merge="6">
							<img class="slider-img" src="/assets/about-us/about2-webp.jpg">
						</div>
						<div class="item" data-merge="6">
							<img class="slider-img" src="/assets/about-us/about3-webp.jpg">
						</div>
						<div class="item" data-merge="6">
							<img class="slider-img" src="/assets/about-us/about4-webp.jpg">
						</div>
						<div class="item" data-merge="6">
							<img class="slider-img" src="/assets/about-us/about5-webp.jpg">
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-5 about-text-div" data-aos="fade-in" data-aos-duration="1000">
					<center>
						<span class="text-gold gallery-tagline">ABOUT ARTCAVE</span>
					</center>
					<br>
					<div class="row justify-content-center">
						<div class="col-9 col-lg-12">
							<span class="text-black">
							<b>ArtCave</b> is like my second home, and I want
							to open this to everyone who shares the same
							passion I have for good food and great art.
							<br><br>
							As a chef, a wife, and a mom, I strive to make
							people around me happy which is why I'm
							bringing that same homey vibes here. More
							than just doing business, we at <b>ArtCave</b> are
							serving SMILES. We want to make sure that
							our customers are happy with our service.
							<br><br>
							We're also supporting local artists by
							exhibiting their work and providing additional
							marketing support for them. This helps us
							create an environment which enables
							creativity for our customers and more
							exposure for our artists. We top all that off
							with great food that will surely make anyone
							feel like they're just relaxing at home.
							<br><br>
							We hope to see you here at <b>ArtCave</b>!
							<br><br>
							-Maydy Uy<br>
							&nbsp;Chef and Owner<br>
							&nbsp;<b>ArtCave Gallery & Cafe</b>
						</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- footer -->
		@include('includes.mainfooter')
	</div>
<script type="text/javascript" src="/public/js/slider/owl.carousel.min.js"></script>
<script>
$(document).ready(function() {
	var owl = $('.owl-carousel');
	owl.owlCarousel({
		loop: true,
		navRewind: false,
		autoplay: true,
    autoHeight:true
	});
	var dots = $('.owl-dots').css('position', 'absolute').css('bottom', '5px');
	dots.css('left', 'calc(50% - ' + dots.width()/2+'px)');
});
</script>
</body>
</html>