$(document).ready(function() {

	var id = null;

	$('.add_new_btn').click(function() {
		openForm('category_add_form', 'Add new category');
	});

	$(document).on('submit', '#category_add_form', function(e) {
		e.preventDefault();
		let data = $(this).serializeArray();
		showLoader('Saving', 'Please wait...');
		ajaxCall(`/backend/categories`, data, 'POST')
		.done((res) => {
			showSuccessAlert('Success', 'Successfully added new category');
			$('#categories').append(`
				<div class="border shadow p-4 m-0 mb-4 bg-light parent-${res.id}">
					<div class="right">
						<h5>
							<i class="fa fa-pencil text-gold text-gold-hover edit-btn" value="${res.id}" title="edit"></i>
							&nbsp;&nbsp;
							<i class="fa fa-trash text-gold text-gold-hover delete-btn" value="${res.id}" title="delete"></i>	
						</h5>
					</div>
					<h5 class="category-name text-gold">${res.name}</h5>
					<span class="category-description">${res.description}</span>
					<br><br>
					<p class="smaller text-gold">
						Last updated by:<br>
						<span class="category-updated">
							${res.updated_by}
						</span>
					</p>
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
		$.get(`/backend/categories/${id}`, function(res) {
			Swal.close();
			$('#name').val(res.name);
			$('#description').val(res.description);
			openForm('category_edit_form', 'Edit category');
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		})
	});

	$(document).on('submit', '#category_edit_form', function(e) {
		e.preventDefault();
		let data = $(this).serializeArray();
		showLoader('Updating', 'Please wait...');
		ajaxCall(`/backend/categories/${id}`, data, 'PUT')
		.done((res) => {
			$(`.parent-${res.id}`).find('.category-name').html(res.name);
			$(`.parent-${res.id}`).find('.category-description').html(res.description);
			$(`.parent-${res.id}`).find('.category-updated').html(res.updated_by);
			$('#close_panel').click();
			showSuccessAlert('Success', 'Category was successfully updated!');
		})
		.fail((err) => {
			showHttpErrorAlert(err);
		})
	});

	$(document).on('click', '.delete-btn', function() {
		id = $(this).attr('value');
		parent = $(`.parent-${id}`);
		showConfirmAlert('Warning', 'Are you sure to delete this category?')
        .then((result) => {
            if (result.value) {
                showLoader('Deleting', 'Please wait...');
				ajaxCall(`/backend/categories/${id}`, {_token: _token}, 'DELETE')
				.done((res) => {					
					showSuccessAlert('Success', 'Category was successfully deleted');
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
			$('.category_form')[0].reset();
		}, 600);
	});
})