$(document).ready(function() {    

	var id = null;

	$('.add_new_btn').click(function() {
		openForm('piece_add_form', 'Add new art piece');
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

	$(document).on('submit', '#piece_add_form', function(e) {
		e.preventDefault();
		let data = $(this).serializeArray();
		if (/\S/.test($('#_image_input').val())) {
			data.push({name: 'image', value: $('#_image').attr('src')});
		}
		showLoader('Saving', 'Please wait...');
		ajaxCall(`/backend/art-pieces`, data, 'POST')
		.done((res) => {
			showSuccessAlert('Success', 'Successfully added new art piece');
			$('#art_pieces').append(`
				<div class="border shadow p-4 row m-0 mb-4 bg-light parent-${res.id}">
					<div class="col-md-2 content-img view-img piece-image mb-2" src="/${res.image}" style="background-image: url('/${res.image}');"></div>
					<div class="col-md-10">
						<span style="float: right !important; font-size: 1.2em !important; cursor: pointer">
							<i class="fa fa-pencil text-gold text-gold-hover edit-btn" value="${res.id}" title="edit"></i>
							&nbsp;&nbsp;
							<i class="fa fa-trash text-gold text-gold-hover delete-btn" value="${res.id}" title="delete"></i>
						</span>
						<span style="font-size: 1.3em;" class="text-gold piece-title">${res.title}</span>
						&nbsp;&nbsp;<span class="badge bgac-red">${res.sold == 1 ? 'Reserved' : ''}</span>
						<br>
						<span class="smaller">
							by
							<span class="piece-artist">${res.artist} (${res.category_name})</span>
						</span>
						<br><br>
						<span class="piece-description">${res.description}</span>
						<a href="#" class="text-primary smaller see_more">See More</a>
						<br><br>
						<p class="smaller text-gold">
							Last updated by:<br>
							<span class="piece-updated">
								${res.updated_by}
							</span>
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
		$.get(`/backend/art-pieces/${id}`, function(res) {
			Swal.close();
			$('#_image').attr('src', `/${res.image}`);
			$('#art_piece_title').val(res.title);
			$('#artist_id').val(res.artist ? res.artist.id : '');
			$('#artist_name').val(res.artist ? res.artist.name : '');
			$('#category').val(res.category);
			$('#description').val(res.description);
			$('#specification').val(res.specification);
			$('#sold').prop('checked', (res.sold == 1 ? true : false));
			openForm('piece_edit_form', 'Edit art piece')
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		})
	});

	$(document).on('submit', '#piece_edit_form', function(e) {
		e.preventDefault();
		let data = $(this).serializeArray();
		if (/\S/.test($('#_image_input').val())) {
			data.push({name: 'image', value: $('#_image').attr('src')});
		}
		showLoader('Updating', 'Please wait...');
		ajaxCall(`/backend/art-pieces/${id}`, data, 'PUT')
		.done((res) => {
			showSuccessAlert('Success', 'Art piece detail was successfully updated!');
			$(`.parent-${res.id}`).find('.piece-image').attr('src', `/${res.image}`);
			$(`.parent-${res.id}`).find('.piece-image').css('background-image', `url('/${res.image}')`);
			$(`.parent-${res.id}`).find('.piece-title').html(res.title);
			$(`.parent-${res.id}`).find('.piece-artist').html(`${res.artist}  (${res.category_name})`);
			$(`.parent-${res.id}`).find('.piece-description').html(res.description);
			$(`.parent-${res.id}`).find('.piece-updated').html(res.updated_by);
			$(`.parent-${res.id}`).find('.badge').html(`${res.sold == 1 ? 'Reserved' : ''}`);
			$('#close_panel').click();
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		})
	});

	$(document).on('click', '.delete-btn', function() {
		parent = $(this).parent().parent().parent();
		id = $(this).attr('value');
		showConfirmAlert('Warning', 'Are you sure to delete this art piece?')
        .then((result) => {
            if (result.value) {
                showLoader('Deleting', 'Please wait...');
				ajaxCall(`/backend/art-pieces/${id}`, {_token: _token}, 'DELETE')
				.done((res) => {					
					showSuccessAlert('Success', 'Art piece was successfully deleted');
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

	$(document).on('click', '#upload-btn', function() {
		$('#_image_input').click();
	});

	$('#artist_name').autocomplete({
        minLength:0,
        source: function (request, response) {
            $.get(`/search/artists?keyword=${$('#artist_name').val()}`, function(data) {
                 response($.map(data.data, function (item) {
                    return {
                        value: item.name,
                        id: item.id,
                    }
                }));
            })
        },
        select: function(event, res) {
        	$('#artist_id').val(res.item.id);
			$('#artist_name').blur();
        },
        change: function() {
        	if (!/\S/.test($('#artist_name').val()) || !/\S/.test($('#artist_id').val())) {
        		$('#artist_id').val('');
				$('#artist_name').val('');
        	}
        }
    })
    .focus(function(){      
        $(this).data("uiAutocomplete").search($(this).val());
    })

    $(document).on('click', '.see_more', function() {
    	id = $(this).attr('value');
		showLoader('Loading', 'Please wait...');
		$.get(`/backend/art-pieces/${id}`, function(res) {
			showModal(``, `		
				<span style="float: right !important; font-size: 1.5em !important; cursor: pointer" onclick="Swal.close();"><i class="fa fa-times"></i></span>
				<br><br>
				<h4 class="text-gold">${res.title}</h4>
				by ${res.artist.name}
				<hr>
				${res.description}<br><br>
				<div style="text-align: left !important;">
					<label><b>Specification</b></label>
					<p style="white-space: pre-wrap;">${res.specification}</p>
				</div>
			`, 600)
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		});
    })

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
});