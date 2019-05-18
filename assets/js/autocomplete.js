/**
 * Bigcommerce autocomplete js
 *
 * since 1.0.0
 */

/* Autocomplete global js */
jQuery(function($){
	var searchRequest;
	$('.bas-search-autocomplete').autoComplete({
		minChars: 2,
		source: function(term, suggest){
			try { searchRequest.abort(); } catch(e){}
			searchRequest = $.post(autocomplete.ajax, { search: term, action: 'bas_search_product' }, function(res) {
				suggest(res.data);
			});
		}
	});
});