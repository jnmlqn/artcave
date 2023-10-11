function showConfirmAlert(title, subtitle) {
	return Swal.fire({
		confirmButtonText: 'Yes',
		cancelButtonText: 'No',
		showCancelButton: true,
		allowOutsideClick: false,
		allowEscapeKey: false,
		allowEnterKey: false,
		title: title,
		text: subtitle,
		icon: 'warning',
		width: '300px',
		customClass: {
			confirmButton: 'btn bg-success swal-okay-button',
			cancelButton: 'btn bg-danger swal-okay-button',
			title: 'swal-title',
			content: 'swal-subtitle'
		}
	});
}

function showSuccessAlert(title, subtitle) {
	Swal.fire({
		confirmButtonText: 'Okay',
		allowOutsideClick: false,
		allowEscapeKey: false,
		allowEnterKey: false,
		title: title,
		html: subtitle,
		icon: 'success',
		width: '300px',
		customClass: {
			confirmButton: 'btn bg-success swal-okay-button',
			title: 'swal-title',
			content: 'swal-subtitle'
		}
	});
}

function showErrorAlert(title, subtitle) {
	Swal.fire({
		confirmButtonText: 'Okay',
		allowOutsideClick: false,
		allowEscapeKey: false,
		allowEnterKey: false,
		title: title,
		html: subtitle,
		icon: 'error',
		width: '300px',
		customClass: {
			confirmButton: 'btn bg-danger swal-okay-button',
			title: 'swal-title',
			content: 'swal-subtitle'
		}
	});
}

function showInfoAlert(title, subtitle) {
	Swal.fire({
		confirmButtonText: 'Okay',
		allowOutsideClick: false,
		allowEscapeKey: false,
		allowEnterKey: false,
		title: title,
		html: subtitle,
		icon: 'info',
		width: '300px',
		customClass: {
			confirmButton: 'btn swal-okay-button',
			title: 'swal-title',
			content: 'swal-subtitle'
		}
	});
}

function showWarningAlert(title, subtitle) {
	Swal.fire({
		confirmButtonText: 'Okay',
		allowOutsideClick: false,
		allowEscapeKey: false,
		allowEnterKey: false,
		title: title,
		html: subtitle,
		icon: 'warning',
		width: '300px',
		customClass: {
			confirmButton: 'btn btn-warn swal-okay-button',
			title: 'swal-title',
			content: 'swal-subtitle-validation'
		}
	});
}

function showLoader(title, subtitle) {
	Swal.fire({
		// confirmButtonText: 'Okay',
		allowOutsideClick: false,
		allowEscapeKey: false,
		allowEnterKey: false,
		title: title,
		html: subtitle,
		width: '300px',
		onBeforeOpen: () => {
			Swal.showLoading ()
		}
	});
}

function showHttpErrorAlert(err) {
	if (err.status == 0) {
		showErrorAlert('Error', 'Check your internet connection and try again');
	} else if (err.status == 500) {
		showErrorAlert('Internal server error', err.responseJSON.message ? err.responseJSON.message : err.responseJSON);
	} else if (err.status == 404) {
		showErrorAlert('Error 404', 'The data you requested was not found');
	} else {
		showErrorAlert('Unknown Error', 'Oopps... Something went wrong');
	}
}

function showValidationErrorAlert(keys, err) {
	err = err.responseJSON;
	let subtitle = '<ul>';
	for (const key of keys) {
		if (err[key] !== undefined) {
			for (const e of err[key]) {
				subtitle += `<li>${e}</li>`;
			}
		}
	}
	subtitle += `</ul>`
	showWarningAlert('Warning', subtitle);
}

function showModal(title, subtitle, width = '350px') {
	Swal.fire({
		showConfirmButton: false,
		allowOutsideClick: false,
		allowEscapeKey: false,
		allowEnterKey: false,
		title: title,
		html: subtitle,
		width: width,
		customClass: {
			title: 'swal-title',
			content: 'swal-subtitle'
		}
	});
}