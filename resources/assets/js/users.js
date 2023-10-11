$(document).ready(function() {    

	var id = null;

	$('.add_new_btn').click(function() {
		openForm('users_add_form', 'Add new user');
	});

	$(document).on('click', '#upload-btn', function() {
		$('#_image_input').click();
	});

	$(document).on('submit', '#users_add_form', function(e) {
		e.preventDefault();
		let data = $(this).serializeArray();
		showLoader('Saving', 'Please wait...');
		ajaxCall(`/backend/users`, data, 'POST')
		.done((res) => {
			showSuccessAlert('Success', 'Successfully added new user');
			$('#users').append(`
				<div class="border shadow row m-0 mb-4 bg-light parent-${res.id}">
					<div class="col-md-12 p-3">
						<span style="float: right !important; font-size: 1.2em !important; cursor: pointer">
							<i class="fa fa-pencil text-gold text-gold-hover edit-btn" value="${res.id}" title="edit"></i>
							&nbsp;&nbsp;
							<i class="fa fa-trash text-gold text-gold-hover delete-btn" value="${res.id}" title="delete"></i>
						</span>
						<h5 class="text-gold user-name">${res.name}</h5>
							<i class="user-level">${res.access_level}</i><br>
							<span class="user-email">${res.email}</span><br>
							<span class="user-address">${res.address}</span><br>
							<p class="smaller text-gold">
								Last updated by:<br>
								<span class="user-updated">
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
		$.get(`/backend/users/${id}`, function(res) {
			Swal.close();
			$('#first_name').val(res.first_name);
			$('#middle_name').val(res.middle_name);
			$('#last_name').val(res.last_name);
			$('#extension').val(res.extension);
			$('#email').val(res.email);
			$('#address').val(res.address);
			$('#access_level_id').val(res.access_level_id);
			openForm('users_edit_form', 'Edit User');
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		})
	});

	$(document).on('submit', '#users_edit_form', function(e) {
		e.preventDefault();
		let data = $(this).serializeArray();
		showLoader('Updating', 'Please wait...');
		ajaxCall(`/backend/users/${id}`, data, 'PUT')
		.done((res) => {
			$(`.parent-${res.id}`).find('.user-name').html(res.name);
			$(`.parent-${res.id}`).find('.user-email').html(res.email);
			$(`.parent-${res.id}`).find('.user-address').html(res.address);
			$(`.parent-${res.id}`).find('.user-level').html(res.access_level);
			$(`.parent-${res.id}`).find('.user-updated').html(res.updated_by);
			$('#close_panel').click();
			showSuccessAlert('Success', 'User was successfully updated!');
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		})
	});

	$(document).on('click', '.delete-btn', function() {
		id = $(this).attr('value');
		parent = $(`.parent-${id}`);
		showConfirmAlert('Warning', 'Are you sure to delete this user?')
        .then((result) => {
            if (result.value) {
                showLoader('Deleting', 'Please wait...');
				ajaxCall(`/backend/users/${id}`, {_token: _token}, 'DELETE')
				.done((res) => {					
					showSuccessAlert('Success', 'User was successfully deleted');
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
			$('.user_form')[0].reset();
			$('#_image').attr('src', '/img/no-image.png');
		}, 600);
	});
})