function toggleVis(id) {
	var inv = document.getElementById(id);
	var style = document.defaultView.getComputedStyle(inv, null);
	if (style['display'] != "none") {
		inv.style.display = "none";
	}
	else {
		inv.style.display = "block";
	}
}

function warp(where) {
	window.location = where + ".php"
}

function validateInputField(field) {
	if (field.value == null || field.value == '') {
		field.style.backgroundColor = '#FFCCCC';
		return false;
	}

	field.style.backgroundColor = '';
	return true;
}

function confirmRePassword(passwordField, repassField) {
	if (passwordField.value != repassField.value) {
		alert('Passwords do not match');
		passwordField.style.backgroundColor = '#FFCCCC';
		repassField.style.backgroundColor = '#FFCCCC';
		return false;
	}

	return true;
}

function validateNewUser(form) {
	var form = document.getElementById('new_user');
	
	var success = validateInputField(form['fname']);
	success = validateInputField(form['lname']) && success;
	success = validateInputField(form['email']) && success;
	success = validateInputField(form['password']) && success;
	success = validateInputField(form['repass']) && success;
	success = confirmRePassword(form['password'], form['repass']) && success;
	
	return success;
}
