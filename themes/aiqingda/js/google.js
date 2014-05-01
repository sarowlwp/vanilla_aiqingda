google.load('search', '1', {language : 'zh-CN'});
	google.setOnLoadCallback(function() {
	var customSearchOptions = {};  var customSearchControl = new google.search.CustomSearchControl(
	'000173301128605918380:-x55eztr608', customSearchOptions);
	customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
	var options = new google.search.DrawOptions();
	options.enableSearchboxOnly("http://www.google.com/cse?cx=000173301128605918380:-x55eztr608", null, true);
	customSearchControl.draw('cse-search-form', options);
  }, true);