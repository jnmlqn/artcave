$(document).ready(function() {   
    
	var artpiece = {
		id: null,
		art_title: null,
		specification: null,
		description: null,
		artist: null,
		category: null,
		sold: null,
	}

	checkPosition();
	AOS.init();
	$('.count').each(function () {
		$(this).prop('Counter',0).animate({
			Counter: $(this).text()
		}, {
			duration: 10000,
			easing: 'swing',
			step: function (now) {
				$(this).text(Math.ceil(now));
			}
		});
	});
	$(window).scroll(function() {
	    checkPosition();
	});

	$('.ac-nav').on('hide.bs.collapse', function () {
		$('.ac-nav').removeClass('bg-scroll');
    	$('.nav-link, .toggler').removeClass('scroll');
	});

	$('.ac-nav').on('show.bs.collapse', function () {
		$('.ac-nav').addClass('bg-scroll');
    	$('.nav-link, .toggler').addClass('scroll');
	});

	function checkPosition() {
		var pos = $(window).scrollTop();
		if (pos == 0) {
	    	$('.ac-nav').removeClass('bg-scroll');
	    	$('.nav-link, .toggler').removeClass('scroll');
	    } else {
	    	$('.ac-nav').addClass('bg-scroll');
	    	$('.nav-link, .toggler').addClass('scroll');
	    }
	};

	$('#subscribe_form').submit(function(e) {
		e.preventDefault();
		let data = $(this).serializeArray();
		showLoader('Submitting', 'Please wait...');
		ajaxCall('/subscribe', data, 'POST')
		.done((res) => {
			showModal('', `
				<span style="float: right !important; font-size: 1.5em !important; cursor: pointer" onclick="Swal.close()">
					<i class="fa fa-times"></i>
				</span>
				<br>
				<hr>
					<h6 class="text-gold"><b>Thank you for subscribing!</b></h6>
				<hr>
				<img src="/img/logo.png" width="100px">
			`);
			$('#subscribe_form')[0].reset();
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		});
	});

	$(document).on('click', '.view-artpiece', function() {
		artpiece.id = $(this).attr('artpiece_id');
		artpiece.src = $(this).attr('src');
		artpiece.art_title = $(this).attr('art_title');
		artpiece.specification = $(this).attr('specification');
		artpiece.description = $(this).attr('description');
		artpiece.artist = $(this).attr('artist');
		artpiece.category = $(this).attr('category');
		artpiece.sold = $(this).attr('sold');
		showModal(``,`
			<span style="float: right !important; font-size: 1.5em !important; cursor: pointer" onclick="Swal.close()"><i class="fa fa-times"></i></span>
			<br><br>
			<div class="row p-3">
				<div onclick="window.open('${artpiece.src}', '_blank')" class="col-12 col-lg-7 view-artpiece-img pointer" style="background-image: url(${artpiece.src}); background-size: cover;"></div>
				<div class="col-12 col-lg-5 view-artpice-details" style="text-align: left !important;">
					<h4 style="text-transform: uppercase;"><b>${artpiece.art_title}</b></h4>
					<h5 class="text-gold">${artpiece.artist}</h5>
					<h5><b>${artpiece.category}</b></h5>
					<br>
					${artpiece.description}
					<br><br>
					<span style="white-space:pre-wrap">${artpiece.specification}</span>
					<br><br>
					<button type="button" class="btn bgac-black inquire" ${artpiece.sold == 1 ? 'disabled' : ''}>
						INQUIRE
					</button>
					<h5 class="text-danger" style="padding: 3px 0 3px 15px !important;"><b>${artpiece.sold == 1 ? 'RESERVED' : ''}</b></h5>
				</div>
			</div>
		`, '80%');
	});

	$(document).on('click', '.inquire', function() {
		let dateNow = new Date();
		showModal(``,`
			<span style="float: right !important; font-size: 1.5em !important; cursor: pointer" onclick="Swal.close()"><i class="fa fa-times"></i></span>
			<br>
			<h4><b>Inquire</b></h4>
			<hr>
			<form class="container" id="inquire_form" style="text-align: left !important" autocomplete="off">
				<input type="hidden" value="${_token}" name="_token">
				<input type="hidden" value="${artpiece.id}" name="artpiece_id">
				<div class="row">
					<div class="col-6">
						<label>First Name</label>
						<input type="text" class="form-control" required placeholder="First Name" name="first_name" maxlength="200">
						<br>
					</div>
					<div class="col-6">
						<label>Last Name</label>
						<input type="text" class="form-control" required placeholder="Last Name" name="last_name" maxlength="200">
						<br>
					</div>
				</div>
				<label>E-mail Address</label>
				<input type="email" class="form-control" required placeholder="E-mail Address" name="email" maxlength="150">
				<br>
				<label>Contact Number</label>
				<input type="text" class="form-control" required placeholder="Contact Number" name="contact" maxlength="20">
				<br>
				<label>Address</label>
				<textarea class="form-control" required placeholder="Address" name="address"></textarea>
				<br>
				<label>Viewing Date & Time</label>
				<div class="row">
					<div class="col-6">
						<input type="date" class="form-control" required name="date" value="${getDate()}">
						<br>
					</div>
					<div class="col-6">
						<input type="time" class="form-control" required name="time" value="${getTime()}">
						<br>
					</div>
				</div>
				<label>Message</label>
				<textarea class="form-control" required placeholder="Message" rows="3" name="message"></textarea>
				<br>
				<div class="form-check">
					<input type="checkbox" name="keep_updated" class="form-check-input" value="1">
					<label>Keep me updated with the latest promos and events</label>
				</div>
				<br>
				<div class="row">
					<div class="col-12">
						<div class="recaptcha float-none float-lg-right" id="gallery-captcha">
					        Submit
					    </div>
					</div>
					<div class="col-12">
						<button class="btn bgac-black mt-3 right" id="submit-btn" disabled>SEND</button>
					</div>
				</div>
			</form>
		`, '500px');

		grecaptcha.render('gallery-captcha', {
			sitekey: '6LcoscsZAAAAAHSlu8OxBjx6qMJi7nCOofuNerBL',
			'callback': function() {
				onSubmit();
			},
			'expired-callback': function() {
				onExpired();;
			}
		});
	});

	$(document).on('submit', '#inquire_form', function(e) {
		e.preventDefault();
		let data = $(this).serializeArray();
		showLoader('Sending', 'Please wait...');
		ajaxCall('/media/inquire', data, 'POST')
		.done((res) => {
			showModal('', `
				<span style="float: right !important; font-size: 1.5em !important; cursor: pointer" onclick="Swal.close()">
					<i class="fa fa-times"></i>
				</span>
				<br>
				<hr>
					<h6 class="text-gold"><b>Thank you, your inquiry has been sent successfully</b></h6>
				<hr>
				<img src="/img/logo.png" width="100px">
			`);
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		})
	})

	$(document).on('click', '.view-media', function() {
		let src = $(this).attr('src');
		let type = $(this).attr('media_type');
		if (type == 1) {
			showModal(``,`
				<span style="float: right !important; font-size: 1.5em !important; cursor: pointer" onclick="Swal.close()"><i class="fa fa-times"></i></span>
				<br><br>
				<iframe src="${src}" class="iframe"></iframe>
			`, '800px');
		} else if (type == 3) {
			showModal(``,`
				<span style="float: right !important; font-size: 1.5em !important; cursor: pointer" onclick="Swal.close()"><i class="fa fa-times"></i></span>
				<br><br>
				<img src="${src}" width="100%">
			`, '800px');
		}
	});

	$(document).on('click', '.view-promo', function() {
		let src = $(this).attr('src');
		let promo_title = $(this).attr('promo_title');
		let description = $(this).attr('description');
		let expiration_date = $(this).attr('expiration_date');
		showModal(``,`
			<span style="float: right !important; font-size: 1.5em !important; cursor: pointer" onclick="Swal.close()"><i class="fa fa-times"></i></span>
			<br><br>
			<div class="row p-3">
				<div class="col-12 col-lg-6">
					<img src="${src}" style="width: 100%">
				</div>
				<div class="col-12 col-lg-6 view-promo-details" style="text-align: left !important;">
					<center>
						<h4><b>${promo_title}</b></h4>
						<h5 class="text-gold"><b>${expiration_date}</b></h5>
						<br><br>
						<span style="white-space:pre-wrap">${description}</span>
					</center>
				</div>
			</div>
		`, '80%');
	});

	$('#contact_form').submit(function(e) {
		e.preventDefault();
		let data = $(this).serializeArray();
		showLoader('Sending', 'Please wait...');
		ajaxCall(`/contact-us/send`, data, 'POST')
		.done((res) => {
			showModal('', `
				<span style="float: right !important; font-size: 1.5em !important; cursor: pointer" onclick="Swal.close()">
					<i class="fa fa-times"></i>
				</span>
				<br>
				<hr>
					<h6 class="text-gold"><b>Thank you, your message has been sent successfully</b></h6>
				<hr>
				<img src="/img/logo.png" width="100px">
			`);
			$('#contact_form')[0].reset();
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		})
	});
})
function onSubmit() {
	$('#submit-btn').removeAttr('disabled');
}
function onExpired() {
	$('#submit-btn').attr('disabled', '');
}