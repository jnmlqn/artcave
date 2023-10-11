<!DOCTYPE html>
<html>
@section('styles')
<link rel="stylesheet" type="text/css" href="/public/css/main.css">
@endsection
@include('includes.head', ['title' => $title ?? 'ARTCAVE'])
<body>
	@include('includes.mainnav')
	<div class="row">
		<div class="col-12 cafe-div text-light" data-aos="fade-in" data-aos-duration="1000">
			<center>
				<span class="tagline">THE CAFE</span><br>
				<h3 class="contact-subtitle">
					Complete your adventure by indulging in our delightful offerings, guaranteed fresh and full of flavor.  
				</h3>
				<br>
			</center>
		</div>
		<div class="col-12 bg-light p-5" data-aos="fade-up" data-aos-duration="1000">
			<div class="row justify-content-center">
				<center>
					<img loading="lazy" src="/assets/cafe/our-menu.png" class="menu-icon">
					<BR><BR>
					<h3 class="text-gold">OUR MENU</h3>
					<b>A variety of daily specials that perfectly matches with our heavenly coffee.</b>
				</center>
			</div>
		</div>
		<div class="col-12 bg-light" data-aos="fade-up" data-aos-duration="1000">
			<div class="row">
				<div class="col-md-4 p-0">
					<img src="/assets/cafe/cafe1-low.jpg" class="cafe1" width="100%">
				</div>
				<div class="col-md-4 p-0">
					<img src="/assets/cafe/cafe2-low.jpg" class="cafe2" width="100%">
				</div>
				<div class="col-md-4 p-0">
					<img src="/assets/cafe/cafe3-low.jpg" class="cafe3" width="100%">
				</div>
			</div>
		</div>
		<div class="col-12 bg-light p-5">
			<div class="row justify-content-center">
				<div class="col-lg-8 col-12">
					<center>
						<h3 class="text-gold">FOOD</h3>
					</center>
					<br><br>
					<div class="row">
						@foreach($foods as $food)
						<div class="col-md-6 pl-5 pr-6 mb-5" data-aos="fade-up" data-aos-duration="1000">
							<h5><b>{{$food->name}}</b></h5>
							{{$food->description}}
						</div>	
						@endforeach					
					</div>
				</div>
				<div class="col-lg-8 col-12" data-aos="fade-up" data-aos-duration="1000">
					<center>
						<h3 class="text-gold">BEVERAGES</h3>
					</center>
					<br><br>
					<div class="row">
						@foreach($beverages as $beverage)
						<div class="col-md-6 pl-5 pr-6 mb-5" data-aos="fade-up" data-aos-duration="1000">
							<h5><b>{{$beverage->name}}</b></h5>
							{{$beverage->description}}
						</div>	
						@endforeach	
					</div>
				</div>
			</div>
		</div>

		<!-- footer -->
		@include('includes.mainfooter')
	</div>
</body>
<script type="text/javascript">	
	var bgimage = new Image();
    bgimage.src = "/assets/cafe/thecafe-header-webp.jpg";
    bgimage.onload = function(){
        $('.cafe-div').css('background-image', 'url(/assets/cafe/thecafe-header-webp.jpg)')
    }

	var cafe1 = new Image();
    cafe1.src = "/assets/cafe/cafe1-webp.jpg";
    cafe1.onload = function(){
        $('.cafe1').attr('src', '/assets/cafe/cafe1-webp.jpg')
    }

	var cafe2 = new Image();
    cafe2.src = "/assets/cafe/cafe2-webp.jpg";
    cafe2.onload = function(){
        $('.cafe2').attr('src', '/assets/cafe/cafe2-webp.jpg')
    }

	var cafe3 = new Image();
    cafe3.src = "/assets/cafe/cafe3-webp.jpg";
    cafe3.onload = function(){
        $('.cafe3').attr('src', '/assets/cafe/cafe3-webp.jpg')
    }
</script>
</html>