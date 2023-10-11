$(document).ready(function() {    

	var id = null;

	$('.add_new_btn').click(function() {
		openForm('promos_add_form', 'Add new promo/event');
	});

	$(document).on('click', '#upload-btn', function() {
		$('#_image_input').click();
	});

	$(document).on('change', '#_image_input', function(evt) {
		const compress = new Compress()
		const preview = document.getElementById('_image')
		const files = [...evt.target.files]
		compress.compress(files, {
			size: 4, // the max size in MB, defaults to 2MB
			quality: 0.75, // the quality of the image, max is 1,
			maxWidth: 1920, // the max width of the output image, defaults to 1920px
			maxHeight: 1920, // the max height of the output image, defaults to 1920px
			resize: true // defaults to true, set false if you do not want to resize the image width and height
		}).then((images) => {
			const img = images[0]
			preview.src = `${img.prefix}${img.data}`
			const { endSizeInMb, initialSizeInMb, iterations, sizeReducedInPercent, elapsedTimeInSeconds, alt } = img
		})
	});

	$(document).on('submit', '#promos_add_form', function(e) {
		e.preventDefault();
		let data = $(this).serializeArray();
		if (/\S/.test($('#_image_input').val())) {
			data.push({name: 'image', value: $('#_image').attr('src')});
		}
		showLoader('Saving', 'Please wait...');
		ajaxCall(`/backend/promos-and-events`, data, 'POST')
		.done((res) => {
			showSuccessAlert('Success', 'Successfully added new promo/event');
			$('#promos').append(`
				<div class="col-md-3 p-3">
					<div class="border shadow">
						<div class="col-md-12 content-img view-img promo-image mb-2" 
								src="/${res.image}" 
								style="background-image: url('/${res.image}');"
						></div>
						<div class="col-md-12">
							<span style="float: right !important; font-size: 1.2em !important; cursor: pointer">
								<i class="fa fa-pencil text-gold text-gold-hover edit-btn" value="${res.id}" title="edit"></i>
								&nbsp;&nbsp;
								<i class="fa fa-trash text-gold text-gold-hover delete-btn" value="${res.id}" title="delete"></i>
							</span>
							<h5 class="text-gold promo-title">${res.title}</h5>
							<span class="promo-description">${res.description}</span><br>
							<span class="promo-expiration smaller text-muted">
								Expiration Date: ${res.expiration_date}
							</span><br><br>
							<p class="smaller text-gold">
								Last updated by:<br>
								<span class="promo-updated">
									${res.updated_by}
								</span>
							</p>
						</div>
					</div>
				</div>
			`);
			$('#close_panel').click();
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		})
	});

	$(document).on('click', '.view-img', function() {
		let src = $(this).attr('src');
		showModal(``,`		
			<span style="float: right !important; font-size: 1.5em !important; cursor: pointer" onclick="Swal.close();"><i class="fa fa-times"></i></span>
			<br><br>
			<img src="${src}" width="100%">
		`, 500);
	});

	$(document).on('click', '.edit-btn', function() {
		id = $(this).attr('value');
		showLoader('Loading', 'Please wait...');
		$.get(`/backend/promos-and-events/${id}`, function(res) {
			Swal.close();
			$('#_image').attr('src', `/${res.image}`);
			$('#promo_title').val(res.title);
			$('#description').val(res.description);
			$('#expiration_date').val(res.expiration_date);
			openForm('promos_edit_form', 'Edit promo/event');
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		})
	});

	$(document).on('submit', '#promos_edit_form', function(e) {
		e.preventDefault();
		let data = $(this).serializeArray();
		if (/\S/.test($('#_image_input').val())) {
			data.push({name: 'image', value: $('#_image').attr('src')});
		}
		showLoader('Updating', 'Please wait...');
		ajaxCall(`/backend/promos-and-events/${id}`, data, 'PUT')
		.done((res) => {
			$(`.parent-${res.id}`).find('.promo-image').css('background-image', `url('/${res.image}')`);
			$(`.parent-${res.id}`).find('.promo-title').html(res.title);
			$(`.parent-${res.id}`).find('.promo-expiration').html(res.expiration);
			$(`.parent-${res.id}`).find('.promo-description').html(res.description);
			$(`.parent-${res.id}`).find('.promo-updated').html(res.updated_by);
			$('#close_panel').click();
			showSuccessAlert('Success', 'Promo/Event was successfully updated!');
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		})
	});

	$(document).on('click', '.delete-btn', function() {
		id = $(this).attr('value');
		parent = $(`.parent-${id}`);
		showConfirmAlert('Warning', 'Are you sure to delete this promo?')
        .then((result) => {
            if (result.value) {
                showLoader('Deleting', 'Please wait...');
				ajaxCall(`/backend/promos-and-events/${id}`, {_token: _token}, 'DELETE')
				.done((res) => {					
					showSuccessAlert('Success', 'Promo/Event was successfully deleted');
					parent.fadeOut('fast', function() {
						$(this).remove();
					})
				})
				.fail((err) => {
					showHttpErrorAlert(err);
				})
            }
        });
	});

    function openForm(id, title) {
    	$('#description').css('height', $('#description')[0].scrollHeight+"px");
    	$('.sidepanel').removeClass('sidepanel-hidden').addClass('sidepanel-shown').attr('id', id);
    	$('#title').html(title)
		$('#overlay').removeAttr('hidden');
		$('html').css('overflow', 'hidden');
    }

	$('#close_panel').click(function() {
		$('.sidepanel').removeClass('sidepanel-shown').addClass('sidepanel-hidden');
		$('#overlay').attr('hidden', '');
		$('html').css('overflow', 'auto');
		setTimeout(() => {
			$('.promo_form')[0].reset();
			$('#_image').attr('src', '/img/no-image.png');
		}, 600);
	});
})