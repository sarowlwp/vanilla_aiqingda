// TagCloud plugin for Vanilla Forums
// by Andy (http://sunspeck.com)

jQuery(document).ready(function($) {
	
	//Determine count of most popular tag
	var max_tag_count = $('.Tags li span').eq(0).text();
	
	//Adjust tag's font-size relative to top tag at 1.8em
	var $liTags = $('.Tags li');
	$liTags.each(function(i) {
		var tag_count = $(this).find('span').text();
		var tag_ratio = tag_count/max_tag_count;
		$(this).find('a')
			.css('font-size', 1.5*tag_ratio+0.6+'em');
			//.css('line-height', 0.5);
	});
	
	//Sort tags random order
//	$('div.Tags ul.PanelInfo').randomize('li');

	//Sort tags alpha order
	$('div.Tags ul.PanelInfo li').tsort();
	
});


//Randomize plugin by Russ Cam, see:
// http://stackoverflow.com/questions/1533910/randomize-a-sequence-of-div-elements-with-jquery

/*
(function($) {

$.fn.randomize = function(childElem) {
  return this.each(function() {
      var $this = $(this);
      var elems = $this.children(childElem);

      elems.sort(function() { return (Math.round(Math.random())-0.5); });  

      $this.remove(childElem);  

      for(var i=0; i < elems.length; i++)
        $this.append(elems[i]);      

  });    
}
})(jQuery);
*/

