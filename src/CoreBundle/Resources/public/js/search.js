$(function() {
      var bibleSearch = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace("name", "link"),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      limit: 10,
      remote: {
        url: 'http://localhost:9200/_search?q=%QUERY',
        wildcard: '%QUERY',
         filter: function(list) {
            console.log(list);
            return $.map(list, function(drug) { return { name: drug.name, link: drug.link }; });
        }
      } 
    });

    bibleSearch.initialize();

    $('.main-search').typeahead(null, {
      name: 'bibleSearch',
      displayKey: 'name',
      source: bibleSearch.ttAdapter(),
  templates: {
    suggestion: Handlebars.compile('<a href="{{link}}"><p>{{name}}</p></a>')
  }

    }); 


});