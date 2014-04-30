(function($) {

  $('.Like a').live('click', function(evt) {
    evt.preventDefault();

    var LikeSpan = $(this).parent().parent();

    LikeSpan.html('<span class="TinyProgress">&nbsp;</span>');

    $.get(this.href, {
      DeliveryType : 'BOOL',
      DeliveryMethod : 'JSON'
    }, function(Data) {
      if (Data.StatusMessage) {
        gdn.inform(Data.StatusMessage);

      }

      if (Data.LikeNewLink) {
        LikeSpan.html(Data.LikeNewLink);

      }

    }, 'json');

  });

})(jQuery);