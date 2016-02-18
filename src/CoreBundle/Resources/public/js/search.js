$(function() {
      var bibleSearch = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace("name", "link"),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      limit: 10,
      remote: {
        url: 'http://bibleapp.jesus/app_dev.php/search/query?q=%QUERY',
        wildcard: '%QUERY',
         filter: function(list) {
            console.log(list);
            return $.map(list, function(find) { 
              return { content: find.content, id: find.id }; 
            });
        }
      } 
    });

    bibleSearch.initialize();

    $('.main-search').typeahead(null, {
      name: 'bibleSearch',
      displayKey: 'name',
      source: bibleSearch.ttAdapter(),
  templates: {
    suggestion: Handlebars.compile('<span>{{content}}</span>')
  }

    }); 


});