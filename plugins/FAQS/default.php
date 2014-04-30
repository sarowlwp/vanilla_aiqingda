<?php if (!defined('APPLICATION')) exit();

// Define the plugin:
$PluginInfo['FAQS'] = array(
	'Name' => 'FAQS',
	'Description' => 'Adds Dynamic FAQS to your vanilla.',
	'Version' 	=>	 '1.0',
	'RequiredTheme' => FALSE, 
	'RequiredPlugins' => FALSE,
	'HasLocale' => FALSE,
	'Author' 	=>	 "422",
	'AuthorEmail' => 'sales@vanillaskins.com',
	'AuthorUrl' =>	 'http://vanillaskins.com',
	'License' => 'GPL v2',
	'RequiredApplications' => array('Vanilla' => '2.0.18')
);
/**
    * FAQS
    *
    * This is a very slick FAQS script, please DO NOT ADD it as a plugin. Follow the tutorial
	* at http://vanillaskins.com/support-forum/discussion/6/how-to-create-your-own-faq-section
**/
class FAQSPlugin implements Gdn_IPlugin {
	
	public function PostController_Render_Before($Sender) {
		$this->_FAQS($Sender);
	}
	
	public function DiscussionController_Render_Before($Sender) {
		$this->_FAQS($Sender);
	}
	
	private function _FAQS($Sender) {
		$Sender->AddJsFile('');
		$Sender->AddCssFile('');
	}
	
	public function Setup() { }
	
}