$(document).ready(function() {   

	var id = null;

	$('.add_new_btn').click(function() {
		openForm('artist_add_form', 'Add new artist');
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

	$(document).on('submit', '#artist_add_form', function(e) {
		e.preventDefault();
		let data = $(this).serializeArray();
		if (/\S/.test($('#_image_input').val())) {
			data.push({name: 'image', value: $('#_image').attr('src')});
		}
		showLoader('Saving', 'Please wait...');
		ajaxCall(`/backend/artists`, data, 'POST')
		.done((res) => {
			showSuccessAlert('Success', 'Successfully added new artist');
			$('#artists').append(`
				<div class="border shadow p-4 row m-0 mb-4 bg-light parent-${res.id}">
					<div class="col-md-2">
						<center><img src="/${res.image}" class="artist-image view-img mb-2 data-image" style="cursor: pointer;"></center>
					</div>
					<div class="col-md-10">
						<span style="float: right !important; font-size: 1.2em !important; cursor: pointer">
							<i class="fa fa-pencil text-gold text-gold-hover edit-btn" value="${res.id}" title="edit"></i>
							&nbsp;&nbsp;
							<i class="fa fa-trash text-gold text-gold-hover delete-btn" value="${res.id}" title="delete"></i>
						</span>
						<h5 class="text-gold artist-name">${res.name}</h5>
						<span class="artist-description">${res.description}</span><br><br>
						<p class="smaller text-gold">
							Last updated by:<br>
							<span class="artist-updated">${res.updated_by}</span>
						</p>
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
		$.get(`/backend/artists/${id}`, function(res) {
			Swal.close();
			$('#_image').attr('src', `/${res.image}`);
			$('#artist_name').val(res.name);
			$('#description').val(res.description);
			openForm('artist_edit_form', 'Edit artist');
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		})
	});

	$(document).on('submit', '#artist_edit_form', function(e) {
		e.preventDefault();
		let data = $(this).serializeArray();
		if (/\S/.test($('#_image_input').val())) {
			data.push({name: 'image', value: $('#_image').attr('src')});
		}
		showLoader('Updating', 'Please wait...');
		ajaxCall(`/backend/artists/${id}`, data, 'PUT')
		.done((res) => {
			$(`.parent-${res.id}`).find('.artist-image').attr('src', `/${res.image}`);
			$(`.parent-${res.id}`).find('.artist-name').html(res.name);
			$(`.parent-${res.id}`).find('.artist-description').html(res.description);
			$(`.parent-${res.id}`).find('.artist-updated').html(res.updated_by);
			$('#close_panel').click();
			showSuccessAlert('Success', 'Artist detail was successfully updated!');
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		})
	});

	$(document).on('click', '.delete-btn', function() {
		parent = $(this).parent().parent().parent();
		id = $(this).attr('value');
		showConfirmAlert('Warning', 'Are you sure to delete this artist?')
        .then((result) => {
            if (result.value) {
                showLoader('Deleting', 'Please wait...');
				ajaxCall(`/backend/artists/${id}`, {_token: _token}, 'DELETE')
				.done((res) => {					
					showSuccessAlert('Success', 'Artist was successfully deleted');
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
			$('.art_piece_form')[0].reset();
			$('#_image').attr('src', '/img/no-image.png');
		}, 600);
	});
})