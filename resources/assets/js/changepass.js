$(function() {   
    
	$('#change_password').click(function() {
		showModal(``,`
			<span style="float: right !important; font-size: 1.5em !important; cursor: pointer" onclick="Swal.close()"><i class="fa fa-times"></i></span>
			<br>
			<h4><b>Change Password</b></h4>
			<hr>
			<form class="container" id="change_pass_form" style="text-align: left !important" autocomplete="off">
				<center>
					<img class="mb-3" src="/img/loader.gif" style="width: 25px; height: 25px; vertical-align: middle !important;" id="change_pass_loader">
					<h6 class="text-danger" id="change_pass_message"></h6>
				</center>
				<input type="hidden" value="${_token}" name="_token">
				<label>Old Password</label>
				<input type="password" id="old_pass" class="form-control" required placeholder="Old Password" name="old" maxlength="100">
				<br>
				<label>New Password</label>
				<input type="password" class="form-control" required placeholder="New Password" name="new" maxlength="100" minlength="8">
				<br>
				<label>Re-enter New Password</label>
				<input type="password" class="form-control" required placeholder="Re-enter New Password" name="confirm" maxlength="100" minlength="8">
				<br>
				<div>
					<button class="btn bgac-gold right" id="change_pass_btn">Save</button>
				</div>
			</form>
		`, '500px');
		$('#change_pass_loader').hide();
	});

	$(document).on('submit', '#change_pass_form', function(e) {
		e.preventDefault();
		let data = $(this).serializeArray();
		$('#change_pass_message').html('');
		$('#change_pass_btn').attr('disabled', '');
		$('#change_pass_loader').show();
		ajaxCall(`/change-password`, data, 'POST')
		.done((res) => {
			showSuccessAlert('Success', 'Your password has been changed successfully');
		})
		.fail((err) => {
			$('#change_pass_btn').removeAttr('disabled');
			if (err.status == 500) {
				$('#old_pass').focus();
				$('#change_pass_loader').hide();
				$('#change_pass_message').html(err.responseJSON.message ? err.responseJSON.message : err.responseJSON);
			} else {
				showHttpErrorAlert(err);
			}
		})
	});
});