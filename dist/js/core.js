$(document).bind('keydown', 'esc', function (evt) {
	var keyArray = Array(81=>45, 87=>0, 69=>315, 65=>90, 68=>270, 90=>135, 88=>180, 67=>225);
	console.log(evt.keyCode);
	return false;
});