$(document).ready(function() {
	var uri = window.location.href;
	var match = uri.match(/#(.*)$/gi);

	if (match !== null) {
		var id = match.shift();
		var offset = $(id).offset().top - 300;

		$("html, body").animate({
							scrollTop: offset 
						}, 
						1000);
	}


});