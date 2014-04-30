/**
 * YoukuTudou - A plugin for Garden & Vanilla Forums.
 * Copyright (C) 2013  Livid Tech
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

jQuery(document).ready(function($) {
   // Define variables for links and regex matching.
   var YoukuLink = 'v.youku.com/v_show/';
   var YoukuRegex1 = '/id_(.*).html';
   
   var TudouLink = 'tudou.com/';
   var TudouRegex1 = '/listplay/(.*)/';
   var TudouRegex2 = '/albumplay/(.*).html';
   var TudouRegex3 = '/albumplay/(.*)/';
   var TudouRegex4 = '/view/(.*)/';
   
   // Interval for timer in milliseconds.
   // This is important for the binds.
   // It is used on document load because it gives the page time to load up.
   var EmbedInterval = 1100;
   
   // Youku Embed
   // Replace link to video with embed.
   function YoukuEmbed() {
      setInterval(function() {
         $('.Message, .Excerpt, #PageBody').find('a[href*="' + YoukuLink + '"]').each(function() {
            var YoukuVideoID = $(this).attr('href').match(YoukuRegex1);
            if(YoukuVideoID != null)
               $(this).replaceWith('<div class="YoukuVideoWrap"><iframe class="YoukuVideoEmbed" width="640" height="400" src="http://player.youku.com/embed/' + YoukuVideoID[1] + '" allowfullscreen></iframe></div>');
         });
      }, EmbedInterval);
   }
   
   // Tudou Embed
   // Replace link to video with embed.
   function TudouEmbed() {
      setInterval(function() {
         $('.Message, .Excerpt, #PageBody').find('a[href*="' + TudouLink + '"]').each(function() {
            var TudouVideoID = $(this).attr('href').match(TudouRegex1);
            if(TudouVideoID == null)
               var TudouVideoID = $(this).attr('href').match(TudouRegex2);
            if(TudouVideoID == null)
               var TudouVideoID = $(this).attr('href').match(TudouRegex3);
            if(TudouVideoID == null)
               var TudouVideoID = $(this).attr('href').match(TudouRegex4);

            if(TudouVideoID != null)
               $(this).replaceWith('<div class="TudouVideoWrap"><iframe class="TudouVideoEmbed" width="640" height="368" src="http://www.tudou.com/programs/view/html5embed.action?code=' + TudouVideoID[1] + '" allowfullscreen></iframe></div>');
         });
      }, EmbedInterval);
   }
   
   // Responsive video frames. Adjusts height to aspect ratio accordingly.
   // Aspect ratio scales:
   // 16:9 => 9 / 16
   // 4:3 => 3 / 4
   var AspectRatio = (9 / 16);
   
   // Additional height to adjust for button bars in the video embed.
   var YoukuAddHeight = 40;
   var TudouAddHeight = 8;
   
   function setAspectRatio() {
      // Set interval to give page time to load up the video embed, so that
      // things like the preview and bind events get scaled by aspect ratio.
      setInterval(function() {
         $('.YoukuVideoEmbed').each(function() {
            $(this).css('height', $(this).width() * AspectRatio + YoukuAddHeight);
         });

         $('.TudouVideoEmbed').each(function() {
            $(this).css('height', $(this).width() * AspectRatio + TudouAddHeight);
         });
      }, EmbedInterval);
   }
   
   // Run functions on document load.
   YoukuEmbed();
   TudouEmbed();
   
   setAspectRatio();
   $(window).resize(setAspectRatio);
   
   // Bind functions to AJAX form submits for comments, activties, and previews.
   $(document).livequery('CommentEditingComplete CommentAdded PreviewLoaded', function() {
      YoukuEmbed();
      TudouEmbed();
      setAspectRatio();
   });
   
   // Bind to click event of these buttons.
   $('body.Vanilla.Post #Form_Preview, input#Form_Share').click(function() {
      YoukuEmbed();
      TudouEmbed();
      setAspectRatio();
   });
});
