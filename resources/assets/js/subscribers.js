$(document).ready(function() {
    
	$(document).on('click', '.delete-btn', function() {
		id = $(this).attr('value');
		parent = $(`#parent-${id}`);
		showConfirmAlert('Warning', 'Are you sure to delete this subsciber?')
        .then((result) => {
            if (result.value) {
                showLoader('Deleting', 'Please wait...');
				ajaxCall(`/backend/subscribers/${id}`, {_token: _token}, 'DELETE')
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
})