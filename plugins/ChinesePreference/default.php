<?php if (!defined('APPLICATION')) exit();

$PluginInfo['ChinesePreference'] = array(
	'Name' => 'Chinese Preference 中文增强补丁',
   'Description' => '使vanilla更符合中文用户的使用习惯',
   'Version' => '0.1b',
   'RequiredApplications' => array('Vanilla' => '2.0.18.4'),
   'RequiredTheme' => FALSE,
   'RequiredPlugins' => FALSE,
	'MobileFriendly' => TRUE,
   'SettingsUrl' => '/dashboard/settings/chinesepreference',
   'SettingsPermission' => 'Garden.Settings.Manage',
   'HasLocale' => TRUE,
   'RegisterPermissions' => FALSE,
   'Author' => "chuck911",
   'AuthorEmail' => 'contact@with.cat',
   'AuthorUrl' => 'http://vanillaforums.cn/profile/chuck911'
);

class ChinesePreferencePlugin extends Gdn_Plugin {
	public function Setup() {
		SaveToConfig('Garden.User.ValidationRegex','\d\w_\x{0800}-\x{9fa5}');
		SaveToConfig('Garden.User.ValidationLength','{2,20}');
		SaveToConfig('Garden.Search.Mode','like');      	
	}
	
	public function OnDisable() {
		RemoveFromConfig('Garden.User.ValidationRegex');
		RemoveFromConfig('Garden.User.ValidationLength');
	}
	
	public function Gdn_Dispatcher_BeforeDispatch_Handler($Sender) {
		Gdn::FactoryInstall('MentionsFormatter', 'Chinese_MentionsFormatter', NULL, Gdn::FactoryInstance);
	}
	
	public function DiscussionsController_BeforeDiscussionName_Handler($Sender,$arg) {
		if(!C('Plugins.ChinesePreference.ShortLink')) return;
		$Discussion = $arg['Discussion'];
		$arg['DiscussionUrl']='/discussion/'.$Discussion->DiscussionID.'/'.($Discussion->CountCommentWatch > 0 && C('Vanilla.Comments.AutoOffset') && $Session->UserID > 0 ? '/#Item_'.$Discussion->CountCommentWatch : '');
	}
	
	public function SettingsController_Chinesepreference_Create($Sender) {
		$Sender->Permission('Garden.Settings.Manage');
    $Sender->Title('Chinese Preference 中文增强补丁');
		$Sender->AddSideMenu('settings/chinesepreference');
		$Sender->Render('Setting', '', 'plugins/ChinesePreference');
	}
	
	public function Base_GetAppSettingsMenuItems_Handler(&$Sender) {
		$Menu = $Sender->EventArguments['SideMenu'];
		$Menu->AddLink('Forum', '中文增强补丁', 'settings/chinesepreference', 'Garden.Settings.Manage');
	}
	
	public function SettingsController_Cnpshortlink_Create($Sender) {
		$Sender->Permission('Garden.Settings.Manage');
		if (Gdn::Session()->ValidateTransientKey(GetValue(0, $Sender->RequestArgs)))
       SaveToConfig('Plugins.ChinesePreference.ShortLink', C('Plugins.ChinesePreference.ShortLink') ? FALSE : TRUE);
       
    Redirect('settings/chinesepreference');
	}
	
	public function SettingsController_Cnptogglelike_Create($Sender) {
		$Sender->Permission('Garden.Settings.Manage');
		if (Gdn::Session()->ValidateTransientKey(GetValue(0, $Sender->RequestArgs)))
       SaveToConfig('Garden.Search.Mode', C('Garden.Search.Mode')=='like' ? 'matchboolean' : 'like');
       
    Redirect('settings/chinesepreference');
	}
}

class Chinese_MentionsFormatter {
	public static function GetMentions($String) {
	  preg_match_all(
			'/@([0-9a-zA-Z_\x{0800}-\x{9fa5}]+)/iu',
	     $String,
	     $Matches
	  );
	  if (count($Matches) > 1) {
	     $Result = array_unique($Matches[1]);
	     return $Result;
	  }
	  return array();
	}
	public static function FormatMentions($Mixed) {
			if(C('Garden.Format.Mentions')) {
			    $Mixed = preg_replace(
							'/@([0-9a-zA-Z_\x{0800}-\x{9fa5}]+)/iu',
			        Anchor('@\1', '/profile/\\1'),
			       $Mixed
			    );
			}
			if(C('Garden.Format.Hashtags')) {
				$Mixed = preg_replace(
					// '/(^|[\s,\.>])\#([\w\-]+)(?=[\s,\.!?]|$)/i',
					'/(^|[\s,\.])\#([\S]{1,30}?)#/i',
					'\1'.Anchor('#\2#', '/search?Search=%23\2%23&Mode=like').'\3',
					$Mixed
				);
			}
	    return $Mixed;
	 }
}