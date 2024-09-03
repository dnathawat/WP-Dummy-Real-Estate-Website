jQuery(document).ready(function ($) {
  $('#custom-search-button').on('click', function () {
    var searchTerm = $('#custom-search-input').val();
    var searchTaxonomy = $('#custom-search-taxonomy').val();

    $.ajax({
      url: ajax_object.ajax_url,
      type: 'POST',
      data: {
        action: 'custom_search',
        search_term: searchTerm,
        search_taxonomy: searchTaxonomy
      },
      success: function (response) {
        $('#custom-search-results').html(response);
      }
    });
  });
});
