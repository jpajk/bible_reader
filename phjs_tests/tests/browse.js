casper.test.begin('Visit browse route', 2, function suite(test) {
	casper.start(siteUrl + '/app.php/browse', function(response) {		
		test.assertEquals(response.status, 200, 'response is 200');

		test.assertEval(function() {
			return $('.book-item').toArray().length === 66;
		}, 'there are 66 books in the chapter page');
	});

	casper.run(function() {
		test.done();
	});
});