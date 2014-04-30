<?php if (!defined('APPLICATION')) die();


//
// Here's the info about my meager plugin
//
$PluginInfo['BaiduShare'] = array
(
  'Name' => 'BaiduShare',
  'Description' => 'Inserts baidushare code on your site!',
  'Version' => '1.0',
  'Author' => 'sarowlwp',
  'AuthorEmail' => 'sarowlwp@live.cn',
  'AuthorUrl' => '',
);

//
// Did I mention this was a plugin?  That would explain our desire to
// extend Gdn_Plugin. How else would we be an uber-plugin of hawtness?
//
class BaiduSharePlugin extends Gdn_Plugin
{

    public static $ButtonCode = '<!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
        <span class="bds_more">分享到：</span>
        <a class="bds_renren"></a>
		<a class="bds_qzone"></a>
        <a class="bds_tsina"></a>
        <a class="bds_tqq"></a>
        <a class="bds_tieba"></a>
		<a class="bds_tqf"></a>
        <a class="bds_hi"></a>
		<a class="bds_fx"></a>
        
        
		<a class="shareCount"></a>
    </div>
<!-- Baidu Button END -->';

//<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=672069" ></script>
   public static $JSCode='
   <script type="text/javascript" id="bdshare_js" data="type=slide&mini=1&amp;uid=672069&amp;img=2&amp;pos=left" ></script> 
   
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
</script>';

  //
  // We want to get our hot selves into the page before it renders and
  // what-not so that we can get our groove on and start tracking our
  // forum users... in a cool way; not in a creepy stalker way.
  //
  public function Base_Render_Before(&$Sender){
  
  }
  
   public function DiscussionController_BeforeDiscussionRender_Handler(&$Sender) {
		
  }
  
  public function DiscussionController_BeforeCommentBody_Handler(&$Sender)
  {

	if($Sender->EventArguments['Type'] =='Discussion'){
	   echo '喜欢就分享吧，让更多的人看到，感谢支持 ~ <br>'.self::$ButtonCode.'<br><br>';
	}

  }
  
  public function DiscussionController_AfterCommentBody_Handler(&$Sender)
  {
	  if($Sender->EventArguments['Type'] =='Discussion'){
	   echo self::$ButtonCode.'<br><br>';
	   echo self::$JSCode;
	  
	}
  }
  
  //
  // Here's where we tell Garden what to do to set us up the bomb.  But
  // we're just simpletons so we have no setup.  Oh to be smart...
  //
  public function Setup()
  {
    // Nothing to do here!
  }
}
