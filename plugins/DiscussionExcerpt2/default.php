<?php
// Define the plugin:
$PluginInfo['DiscussionExcerpt2'] = array(
   'Description' => 'Shows configurable amount of words from discussion in discussion list',
   'Version' => '2.0',
   'Author' => "Robert Ivanov",
   'AuthorEmail' => 'rb@robi-bobi.net',
   'AuthorUrl' => 'http://www.robi-bobi.net'
);


class DiscussionExcerpt2 implements Gdn_IPlugin {
   public function PluginController_DiscussionExcerpt2_Create(&$Sender) {
      $Sender->AddSideMenu('plugin/discussionexcerpt2');
      $Sender->Form = new Gdn_Form();
      $Validation = new Gdn_Validation();
      $ConfigurationModel = new Gdn_ConfigurationModel($Validation);
      $ConfigurationModel->SetField(array('DiscussionExcerpt2.Number_of_words'));
      $ConfigurationModel->SetField(array('DiscussionExcerpt2.Show_announcements'));
      $ConfigurationModel->SetField(array('DiscussionExcerpt2.Show_images'));
      $Sender->Form->SetModel($ConfigurationModel);
            
      if ($Sender->Form->AuthenticatedPostBack() === FALSE) {    
         $Sender->Form->SetData($ConfigurationModel->Data);    
      } else {
         $Data = $Sender->Form->FormValues();
         $ConfigurationModel->Validation->ApplyRule('DiscussionExcerpt2.Number_of_words', array('Required', 'Integer'));
         if ($Sender->Form->Save() !== FALSE)
            $Sender->StatusMessage = T("Your settings have been saved.");
      }
      
      // creates the page for the plugin options such as display options
      $Sender->View = dirname(__FILE__).DS.'views'.DS.'discussionexcerpt2.php';
      $Sender->Render();
   }

   public function Base_GetAppSettingsMenuItems_Handler(&$Sender) {
      $Menu = $Sender->EventArguments['SideMenu'];
      $Menu->AddLink('Add-ons', 'DiscussionExcerpt2', 'plugin/discussionexcerpt2', 'Garden.Themes.Manage');
   }

   public function DiscussionsController_AfterDiscussionTitle_Handler(&$Sender) {
	   $Number_of_words = Gdn::Config('DiscussionExcerpt2.Number_of_words', 15);
	   $Show_announcements = Gdn::Config('DiscussionExcerpt2.Show_announcements', false);
	   $Show_images = Gdn::Config('DiscussionExcerpt2.Show_images', false);
	   
	   $Discussion = $Sender->EventArguments['Discussion'];
	   if($Show_images) {
		   $FirstComment = strip_tags($Discussion->Body, '<img>');
	   } else {
		   $FirstComment = strip_tags($Discussion->Body);
	   }
           $Announce = $Discussion->Announce;

	   $words = explode(' ', $FirstComment);
           if ( ($Announce != 1 ) || ( $Announce && $Show_announcements )) {
             if (count($words) > $Number_of_words) {
	         echo '<div class="DiscussionExcerpt2">' . implode(' ', array_slice($words, 0, $Number_of_words)) . ' ...</div>';
	     } else {
                 echo $FirstComment;
	     }
	   }
	   return;
   }
  
    /**
    * This method is called when discussion list is shown for some category
    * Method provided by @NickE
    **/ 
    public function CategoriesController_AfterDiscussionTitle_Handler(&$Sender) {
        $this->DiscussionsController_AfterDiscussionTitle_Handler($Sender);
    }

   public function Setup() {
      //no setup needed
   }
} 
