<!DOCTYPE html>
<html>
@section('styles')
<link rel="stylesheet" type="text/css" href="/public/css/main.css">
@endsection
@include('includes.head', ['title' => $title ?? 'ARTCAVE'])
<body>
	@include('includes.mainnav')
	<div class="row">
		<div class="col-12 contact-div text-light" data-aos="fade-in" data-aos-duration="1000">
			<center>
				<span class="tagline">CONTACT US</span><br>
				<h3 class="contact-subtitle">We'd love to hear from you. Here's how you can reach us</h3>
				<br>
				<a href="#contact-us-form" class="btn contact-btn">
					SEND A MESSAGE
				</a>
			</center>
		</div>
		<div class="col-12 bg-light counter-div">
			<div class="row">
				<div class="col-12 col-lg-4 mb-5" data-aos="fade-up" data-aos-duration="1000">
					<center>
						<img loading="lazy" src="/assets/icons/address.png" class="icons">
						<br><br>
						<a href="https://www.google.com/maps/place/54+Katipunan+Ave,+Quezon+City,+Metro+Manila/@14.6070682,121.0683371,17z/data=!4m5!3m4!1s0x3397b7fa89249e01:0x21d1aad0cbd47d13!8m2!3d14.607063!4d121.0705258" class="text-black" target="_blank">
							No. 54 Katipunan Ave.<br>
							White Plains, Quezon City,<br>
							Philippines, 1103
						</a>					
					</center>
				</div>
				<div class="col-12 col-lg-4 mb-5" data-aos="fade-up" data-aos-duration="1000">
					<center>
						<img loading="lazy" src="/assets/icons/contact-no.png" class="icons">
						<br><br>
						<p>
							0917 572 7775<br>
							0917 526 5572<br>
							(02) 7904 8485
						</p>							
					</center>
				</div>
				<div class="col-12 col-lg-4 mb-5" data-aos="fade-up" data-aos-duration="1000">
					<center>
						<img loading="lazy" src="/assets/icons/email.png" class="icons">
						<br><br>
						<p>
							info@artcavegallery.com
						</p>					
					</center>
				</div>
			</div>
		</div>
		<div class="col-12 bg-light" data-aos="fade-up" data-aos-duration="1000" id="contact-us-form">
			<div class="mapouter">
				<div class="gmap_canvas">
					<iframe style="height: 300px; width: 100%" id="gmap_canvas" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3860.859680227294!2d121.06833711420676!3d14.607068180835707!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b7fa89249e01%3A0x21d1aad0cbd47d13!2s54%20Katipunan%20Ave%2C%20Quezon%20City%2C%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1601210507013!5m2!1sen!2sph" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
				</div>
			</div>
		</div>
		<div class="col-12 bg-light p-5" data-aos="fade-up" data-aos-duration="1000">
			<div class="row justify-content-center">
				<div class="col-12 col-lg-8">
					<center><h3 class="contact-subtitle text-gold">SEND A MESSAGE</h3></center>
					<br>
					<form class="row" id="contact_form">
						@csrf
						<div class="col-md-6">
							<input type="text" class="form-control" name="name" placeholder="Name*" required maxlength="200">
							<br>
						</div>
						<div class="col-md-6">
							<input type="email" class="form-control" name="email" placeholder="Email*" required maxlength="200">
							<br>
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control" name="contact" placeholder="Contact No.*" required maxlength="20">
							<br>
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control" name="address" placeholder="Address*" required>
							<br>
						</div>
						<div class="col-md-12">
							<textarea class="form-control" name="message" placeholder="Message*" rows="5"></textarea>
							<br>
						</div>
						<div class="col-md-10">
							<center>
								<div class="g-recaptcha float-none float-lg-right" 
							        data-sitekey="6LcoscsZAAAAAHSlu8OxBjx6qMJi7nCOofuNerBL" 
							        data-callback='onSubmit' 
							        data-expired-callback='onExpired'>
							        Submit
							    </div>
							</center>
						</div>
						<div class="col-md-2">
							<button class="btn bgac-black right mt-3" id="submit-btn" disabled>SEND</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- footer -->
		@include('includes.mainfooter')
	</div>
</body>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script type="text/javascript">	
	var bgimage = new Image();
    bgimage.src = "/assets/contactheader-webp.jpg";
    bgimage.onload = function(){
        $('.contact-div').css('background-image', 'url(/assets/contactheader-webp.jpg)')
    }
</script>
</html>