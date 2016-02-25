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
            //console.log(list);
            return $.map(list, function(find) { 
              return { content: find.content, 
                       id: find.id, 
                       chapter: find.chapter, 
                       number: find.number,
                       shortname: find.shortname,
                     }; 
            });
        }
      } 
    });

    bibleSearch.initialize();

    globalBible = bibleSearch;    
});

$(function() {
  $('.search-wrap').one('keydown', function(e) {
      $(this).appendTo('.search-holder')
             .addClass('nav navbar-nav col-xs-12 col-xs-8');

      $(this).find('input').focus();

      $('.body-wrap').html('<div id="results-wrap" class="row"></div>')
                     .attr('style', '');

      populateDOM.populateWithResults($(this).find('input'));
    });

    $('.main-banner').fadeIn(1000).css('top', '150px');

});

var populateDOM = {
  handleArray : function(json) {
    var returnDOM = '';
    var object = this;
    var template = templates.searchTemplate;

    $.each(json, function(index, result) {      
      returnDOM += object.readyTemplate(template, result);
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
  },
  populateWithResults : function(el) {
    var object = this;

    $(el).on('keyup', function() {
      $('#results-wrap').html('');      

      globalBible.search($(el).val(), object.populateSync, object.populateAsync);
    });
  },
  populateSync : function(json) {
    return;
  },
  populateAsync : function(json) {        
    var results = populateDOM.handleArray(json);
    $('#results-wrap').html(results);
  }
};

var templates = {
  searchTemplate: '<div class="col-xs-12 single-result">' + 
                    '<div class="tag col-xs-12">' +
                    '<p>' +
                      '<span class="bookname">{{shortname}}</span>' +
                      '<span class="chaptername">{{chapter}}</span>' +
                      //'<span class="divider">:</span>' +
                      '<span class="verse-number">{{number}}</span>' +
                    '</p>' +
                    '</div>' +
                    '<p class="col-xs-offset-2 col-xs-9">' +
                      '{{content}}' +
                    '</p>' +
                  '</div>'
};