/**
 * Bigcommerce admin design dynamic form js
 *
 * @since 1.2
 */
var basSearchBoxSize = document.getElementById("bas_search_box_size");
var basSearchBoxSizeView = document.getElementById("bas_search_box_size_view");
basSearchBoxSizeView.innerHTML = basSearchBoxSize.value+'%';

basSearchBoxSize.oninput = function() {
  basSearchBoxSizeView.innerHTML = this.value+'%';
}