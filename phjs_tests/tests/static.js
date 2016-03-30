casper.test.begin('Visit the about route', 1, function suite(test) {
	casper.start(siteUrl + '/app.php/about', function(response) {
		test.assertEquals(response.status, 200, 'response is 200');
	});

	casper.run(function() {
		test.done();
	});
});