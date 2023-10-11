$(document).ready(function() {    

	var id = null;

	$('.add_new_btn').click(function() {
		openForm('menus_add_form', 'Add new menu');
	});

	$(document).on('click', '#upload-btn', function() {
		$('#_image_input').click();
	});

	$(document).on('submit', '#menus_add_form', function(e) {
		e.preventDefault();
		let data = $(this).serializeArray();
		showLoader('Saving', 'Please wait...');
		ajaxCall(`/backend/menus`, data, 'POST')
		.done((res) => {
			showSuccessAlert('Success', 'Successfully added new menu');
			$('#menus').append(`
				<div class="border shadow row m-0 mb-4 bg-light parent-${res.id}">
					<div class="col-md-12 p-3">
						<span style="float: right !important; font-size: 1.2em !important; cursor: pointer">
							<i class="fa fa-pencil text-gold text-gold-hover edit-btn" value="${res.id}" title="edit"></i>
							&nbsp;&nbsp;
							<i class="fa fa-trash text-gold text-gold-hover delete-btn" value="${res.id}" title="delete"></i>
						</span>
						<h5 class="text-gold menu-name">${res.name}</h5>
						<i class="menu-type">${res.type}</i><br>
						<span class="menu-description">${res.description}</span>
						<br><br>
						<p class="smaller text-gold">
							Last updated by:<br>
							<span class="menu-updated">
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

	$(document).on('click', '.edit-btn', function() {
		id = $(this).attr('value');
		showLoader('Loading', 'Please wait...');
		$.get(`/backend/menus/${id}`, function(res) {
			Swal.close();
			$('#menu_name').val(res.name);
			$('#description').val(res.description);
			$('#menu_type').val(res.type);
			openForm('menus_edit_form', 'Edit menu');
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		})
	});

	$(document).on('submit', '#menus_edit_form', function(e) {
		e.preventDefault();
		let data = $(this).serializeArray();
		showLoader('Updating', 'Please wait...');
		ajaxCall(`/backend/menus/${id}`, data, 'PUT')
		.done((res) => {
			$(`.parent-${res.id}`).find('.menu-name').html(res.name);
			$(`.parent-${res.id}`).find('.menu-description').html(res.description);
			$(`.parent-${res.id}`).find('.menu-type').html(res.type);
			$(`.parent-${res.id}`).find('.menu-updated').html(res.updated_by);
			$('#close_panel').click();
			showSuccessAlert('Success', 'Menu was successfully updated!');
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		})
	});

	$(document).on('click', '.delete-btn', function() {
		id = $(this).attr('value');
		parent = $(`.parent-${id}`);
		showConfirmAlert('Warning', 'Are you sure to delete this menu?')
        .then((result) => {
            if (result.value) {
                showLoader('Deleting', 'Please wait...');
				ajaxCall(`/backend/menus/${id}`, {_token: _token}, 'DELETE')
				.done((res) => {					
					showSuccessAlert('Success', 'Menu was successfully deleted');
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
			$('.menu_form')[0].reset();
			$('#_image').attr('src', '/img/no-image.png');
		}, 600);
	});
})