casper.test.begin('Visit the pages of bibleapp', 1, function suite(test) {
	casper.start(siteUrl, function(response) {		
		test.assertEquals(response.status, 200, 'response is 200');		
	});

//	casper.then(function() {		
//		test.assertExists('#results-wrap', 'the list displays on search');		
//	});	

	casper.run(function() {
		test.done();
	});
});