<?php if (!defined('APPLICATION')) exit();

// Define the plugin:
$PluginInfo['CtrlEnter'] = array(
	'Name' => 'CtrlEnter',
	'Description' => 'Plugin allows users to post comments by pressing Ctrl + Enter while editing message',
	'Version' => '0.1',
	'RequiredApplications' => array('Vanilla' => '2.0.17'),
	'RequiredPlugins' => FALSE,
	'RequiredTheme' => FALSE,
	'MobileFriendly' => FALSE,
	'HasLocale' => TRUE,
	'RegisterPermissions' => FALSE,
	'Author' => "p00h",
	'AuthorEmail' => 'p00hzone@gmail.com',
	'AuthorUrl' => 'http://github.com/p00h'
);

class CtrlEnterPlugin extends Gdn_Plugin {
	
	public function DiscussionController_AfterFormButtons_Handler() {
		echo '<script type="text/javascript">';
		echo "$('#Form_Body').keypress(function(event){
			if((event.ctrlKey) && ((event.keyCode == 0xA)||(event.keyCode == 0xD)))
				$('#Form_PostComment').click();
			})";
		echo '</script>';
	}
	
	public function ProfileController_BeforeStatusForm_Handler() {
		echo '<script type="text/javascript">';
		echo "$(document).ready(function(){ $('#Form_Comment').keypress(function(event){
			if((event.ctrlKey) && ((event.keyCode == 0xA)||(event.keyCode == 0xD)))
				$('#Form_Share').click();
			})})";
		echo '</script>';
	}
}