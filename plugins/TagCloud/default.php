<?php if (!defined('APPLICATION')) exit();

$PluginInfo['TagCloud'] = array(
   'Name' => 'Tag Cloud',
   'Description' => 'Restyles tag panel to a compact weighted cloud (plugin Tagging must be enabled)',
   'Version' => '0.1',
   'Author' => "Andy (leafmonster)",
   'AuthorEmail' => 'andy@sunspeck.com',
   'AuthorUrl' => 'http://sunspeck.com',
   //'SettingsUrl' => '/dashboard/plugin/TagCloud',
   //'SettingsPermission' => 'Garden.Settings.Manage'
);


class TagCloudPlugin extends Gdn_Plugin {
	
	public function Base_Render_Before($Sender) {
      $Sender->AddCssFile($this->GetResource('design/TagCloud.css', FALSE, FALSE));
      $Sender->AddJsFile($this->GetResource('design/TagCloud.js', FALSE, FALSE));
      $Sender->AddJsFile($this->GetResource('design/jquery.tinysort.min.js', FALSE, FALSE));
   }

}