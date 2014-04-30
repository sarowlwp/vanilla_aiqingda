<!DOCTYPE html>
<html>
<head>
  {asset name='Head'}
</head>

<body id="{$BodyID}" class="{$BodyClass}">

<div id="Frame">
 <div id="Head">
   <div class="Row">
     <strong class="SiteTitle"><a href="{link path="/"}">{logo}</a></strong>
     <ul class="SiteMenu">
      {dashboard_link}
      {discussions_link}
      {activity_link}
      <!-- {inbox_link} -->
      {custom_menu}
      <!-- {profile_link} -->
      {signinout_link}
     </ul>
     <div class="SiteSearch">{searchbox}</div>
   </div>
  </div>
  <div id="Body">
    <div class="Row">
      <div class="Column PanelColumn" id="Panel">
         {module name="MeModule"}
         {asset name="Panel"}
      </div>
      <div class="Column ContentColumn" id="Content">{asset name="Content"}</div>
    </div>
  </div>
  <div id="Foot">
    <div class="Row">
      powered by <a href="http://vanillaforums.org/">vanilla forums</a>
			{asset name="Foot"}
    </div>
  </div>
</div>
{event name="AfterBody"}
</body>
</html>