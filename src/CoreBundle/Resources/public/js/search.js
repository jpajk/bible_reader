var globalBible;
var isAppended = false;

$(function () {
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
                       link: find.link
                     };
            });
        }
      }
    });

    bibleSearch.initialize();

    globalBible = bibleSearch;
});

$(function() {
  $('.search-wrap').on('keydown', function(e) {      

      if (isAppended === false && $(this).find('input').val() !== "") {
        $(this).appendTo('.search-holder')
               .addClass('nav navbar-nav col-xs-8');
  
        $(this).find('input').focus();
  
        $('.body-wrap').html('<div id="results-wrap" class="row"></div>')
                       .attr('style', '');

        isAppended = true;

        //$('#bottom-container').fadeIn();
      }

      if ($(this).find('input').val() !== "") {
        populateDOM.populateWithResults($(this).find('input'));        
      }

    });

    $('.main-banner').fadeIn(1000).css('top', '150px');  

});

var populateDOM = {
  handleArray : function(json) {
    var returnDOM = '';
    var object = this;
    var template = Handlebars.templates.search;

    $.each(json, function(index, result) {
      returnDOM += template(result);
    });

    return returnDOM;
  },
  appendByJQuery : function(readyElement, nodeName) {
    $(nodeName).append(readyElement);
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
