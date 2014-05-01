/* Copyright 2013 Zachary Doll */
jQuery(document).ready(function($) {
  // Fade in.out on scroll
  $(window).scroll($.debounce(function() {
    if ($(this).scrollTop() > 100) {
      $('#JumpToTop').fadeIn();
    } else {
      $('#JumpToTop').fadeOut();
    }
  }, 100, null, true, true));

  // scroll body to 0px on click
  $('#JumpToTop').click(function(event) {
    event.preventDefault();
    $('body, html').animate({scrollTop: 0}, 800);
  });
});
