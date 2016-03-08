casper.test.begin('Visit the pages of bibleapp', 2, function suite(test) {
	casper.start(siteUrl + '/app.php/browse', function(response) {		
		test.assertEquals(response.status, 200, 'response is 200');

		test.assertEval(function() {
			return $('.book-item').toArray().length === 66;
		}, 'there are 66 books in the chapter page');
	});

//	casper.then(function() {		
//		test.assertExists('#results-wrap', 'the list displays on search');		
//	});	

	casper.run(function() {
		test.done();
	});
});