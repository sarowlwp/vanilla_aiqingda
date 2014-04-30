<?php if (!defined('APPLICATION')) exit();
// Define the plugin:
$PluginInfo['PictureGallery'] = array(
   'Name' => 'Picture Gallery',
   'Description' => 'Adds a picture gallery to you website for you to add new pictures to your website with seperate folders for everyone to browse.<br />For some reason in my testing phase I wasn\'t able to disable this, so if you want to disable this addon, you\'ll have to edit your config file and take the following line out -- <b>$Configuration[\'EnabledPlugins\'][\'PictureGallery\'] = TRUE;</b>',
   'Version' => '0.2.1',
   'Author' => 'Yohn',
   'AuthorEmail' => 'john@skem9.com',
   'AuthorUrl' => 'http://www.skem9.com'
);

class PictureGallery extends Gdn_Plugin {

	public function Base_Render_Before(&$Sender) {
		$Sender->Menu->AddLink('PictureGallery', T('Gallery'), '/gallery', FALSE);
	}
	 
	public function PluginController_Pictures_Create(&$Sender) {
			$Sender->AddSideMenu('plugin/pictures');
			$Sender->Render($this->GetView('manager.php'));
	}
	
	public function PluginController_Gallery_Create(&$Sender) {
			$Sender->ClearCssFiles();
			$Sender->AddCssFile('style.css');
			$Sender->MasterView = 'default';
			$Sender->Render($this->GetView('gallery.php'));
	}

	public function Base_GetAppSettingsMenuItems_Handler($Sender) {
		$Menu = $Sender->EventArguments['SideMenu'];
		$Menu->AddLink('Appearance', T('Picture Gallery'), 'plugin/pictures', 'Garden.Settings.Manage');
	}
	
	public function Setup() { 
		Gdn::Router()->SetRoute('gallery','plugin/gallery','Internal');
		if(!is_dir('uploads/picgal/')) $go = mkdir('uploads/picgal', 0777);
	}
	
	 public function OnDisable() {
		SaveToConfig('EnabledPlugins.PictureGallery', FALSE);
   }
	
}