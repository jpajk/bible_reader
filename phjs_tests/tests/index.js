casper.test.begin('Visit search route (main route)', 10, function suite(test) {
	casper.start(siteUrl, function(response) {
		test.assertEquals(response.status, 200, 'response is 200');
		test.assertTitle('Bible Reader', 'the page title is as expected');
		test.assertExists('.menu-right', 'menu on the right appears');
		test.assertEval(function() {
			return $('.navbar-right li').toArray().length === 3;
		}, 'there are three elements in the menu on the right');
		test.assertExists('.fa-twitter', 'twitter icon displays');
		test.assertSelectorHasText('.main-banner h2', 'King James Bible');
		test.assertExists('.fa-facebook', 'facebook icon displays');
		test.assertExists('input#main-search', 'the main input displays correctly');
	});

	casper.then(function() {
		this.sendKeys('#main-search', 'aaron');
		test.assertExists('#results-wrap', 'the list displays on search');
		

		casper.waitForSelector('.col-xs-12.single-result > a', function() {				
				
				this.click('a[href="/app_dev.php/browse/Josh#verse-no-21-4"]');
				
				casper.waitForSelector('.book-name-wrap', function() {
					test.assertExists('.book-name-wrap', 'redirected properly');					
				});
		});
	});


	casper.run(function() {
		test.done();
	});
});

var helperFunctions = {
	getLinks : function() {
		return document.querySelectorAll(".col-xs-12.single-result > a");
	}
};

