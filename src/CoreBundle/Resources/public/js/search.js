var globalBible;

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

    globalBible = bibleSearch;

    //$('.main-search').typeahead(null, {
    //      name: 'bibleSearch',
    //      displayKey: 'name',
    //      source: bibleSearch.ttAdapter(),
    //  templates: {
    //    suggestion: Handlebars.compile('<p><a href="#">{{content}}</a></p>')
    //  }
    //});
});

$(function() {
  $('.search-wrap').on('click focus', function(e) {
      $(this).insertBefore('.navbar-nav')
             .addClass('nav navbar-nav col-xs-12 col-xs-6')
             .trigger('focus')
             .unbind(e);
    });
});

function sync(datums) {
  console.log('datums from `local`, `prefetch`, and `#add`');
  console.log(datums);
}

function async(datums) {
  console.log('datums from `remote`');
  console.log(datums);
}

var populateDOM = {
  handleArray : function(json) {
    returnDOM = '';
    var object = this;
    $.each(json, function(index, result) {
      returnDOM += object.readyTemplate(templates.searchTemplate, result);
    });

    return returnDOM;
  },
  readyTemplate : function(templateString, json) {    
    template = this.compileFromHandleBars(templateString);    
    return this.hydrateTemplate(template, json);
  },
  appendByJQuery : function(readyElement, nodeName) {
    $(nodeName).append(readyElement);
  },
  compileFromHandleBars : function(template) {
    return Handlebars.compile(template);
  },
  hydrateTemplate : function(template, json) {
    return template(json);
  }
};

var templates = {
  searchTemplate: '<div><p>{{name}}</p></div>'
};