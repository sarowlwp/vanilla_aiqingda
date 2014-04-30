<?php if (!defined('APPLICATION')) exit();
// Copyright Trademark Productions 2010

// Define the plugin:
$PluginInfo['DiscussionMark'] = array(
   'Name' => 'DiscussionMark',
   'Description' => 'Allows you to mark certain discussions with a Mark.',
   'Version' => '1.0',
   'RequiredApplications' => array('Vanilla' => '2.0.14'),
   'RegisterPermissions' => array(
      'Vanilla.DiscussionMark.Use',
      'Vanilla.DiscussionMark.Manage'),
   'SettingsUrl' => '/plugin/discussionmark',
   'SettingsPermission' => 'Vanilla.DiscussionMark.Manage',
   'Author' => "sarowlwp ,thx for Matt Lincoln Russell",
   'AuthorEmail' => 'sarowlwp@live.cn',
   'AuthorUrl' => '',
   'License' => 'GNU GPLv2'
);

/**
Vanilla.DiscussionMark.Use      define who can use it 
Vanilla.DiscussionMark.Manage   define who can manage it
*/

class DiscussionMarkPlugin extends Gdn_Plugin {
   
   /**
    * Adds "Mark" menu option to the Forum menu on the dashboard.
    */
   public function Base_GetAppSettingsMenuItems_Handler(&$Sender) {
      $Menu = &$Sender->EventArguments['SideMenu'];
      $Menu->AddLink('Forum', 'Discussion Mark', 'plugin/discussionmark', 'Vanilla.DiscussionMark.Manage');
   }
   
   /**
    * Creates a virtual DiscussionMark controller
    */
   public function PluginController_DiscussionMark_Create(&$Sender) {
      $Sender->Permission('Vanilla.DiscussionMark.Manage');
      $Sender->Title('Discussion Mark');
      $Sender->Form = new Gdn_Form();
      $this->Dispatch($Sender, $Sender->RequestArgs);
   }
    
	/**
    * @param DiscussionsController $Sender
    * @param array $Args
    */
	
   public function DiscussionsController_Elite_Create($Sender, $Args = array()) {
      $Sender->View = 'Index';
      $Sender->SetData('_PagerUrl', 'discussions/elite/{Page}');
      $Sender->Index(GetValue(0, $Args, 'p1'));
   }
   
    /**
    * @param DiscussionsController $Sender
    * @param array $Args
    */
   public function DiscussionsController_EliteCount_Create($Sender, $Args = array()) {
      //Gdn::SQL()->WhereIn('QnA', array('Unanswered', 'Rejected'));
      $Count = Gdn::SQL()->GetCount('Discussion', array('Elite' => '1'));
      Gdn::Cache()->Store('EliteCount', $Count, array(Gdn_Cache::FEATURE_EXPIRY => 15 * 60));

      $Sender->SetData('EliteCount', $Count);
      $Sender->SetData('_Value', $Count);
      $Sender->Render('Value', 'Utility', 'Dashboard');
   }
   
   
   
   /**
    * Insert checkbox on Discussion Post page (vanilla/views/post/discussion.php)
    */
   public function PostController_DiscussionFormOptions_Handler(&$Sender) {
      $Session = Gdn::Session();
      if ($Session->CheckPermission('Vanilla.DiscussionMark.Use')){
	  
		  if(C('Plugins.DiscussionMark.EnableEliteTag')){
				$Sender->EventArguments['Options'] .= '<li>'.$Sender->Form->CheckBox('Elite', '加精', array('value' => '1')).'</li>';
			}
		  if(C('Plugins.DiscussionMark.EnableRecommendTag')){
			$Sender->EventArguments['Options'] .= '<li>'.$Sender->Form->CheckBox('Recommend', '推荐', array('value' => '1')).'</li>';
			}
		 
		}
   }
   
   /**
    * Add Mark to discussion name in single discussion view (vanilla/controllers/class.discussioncontroller.php)
    */
   public function DiscussionController_BeforeDiscussionRender_Handler(&$Sender) {
	    /*
		if(C('Plugins.DiscussionMark.EnableEliteTag')){
			if($Sender->Discussion->Elite == 1){
				$Sender->Discussion->Name ='[精华帖] '.$Sender->Discussion->Name;
			}
		}
		if(C('Plugins.DiscussionMark.EnableRecommendTag')){
			if($Sender->Discussion->Recommend == 1){
				$Sender->Discussion->Name = '[版主推荐] '.$Sender->Discussion->Name;
			}
		}*/
   }
   
   public function DiscussionController_BeforeDiscussionTitle_Handler(&$Sender) {
	 if($Sender->Discussion->Elite == 1){
		echo '<div class="EliteDiscussion"></div>';
	 }
   }
   public function DiscussionModel_BeforeGet_Handler($Sender, $Args) {
	  $Elite = Gdn::Controller()->ClassName == 'DiscussionsController' && Gdn::Controller()->RequestMethod == 'elite';

	  if ($Elite) {
		 $Args['Wheres']['Elite'] = '1';
		 //$Args['Wheres']['Announce'] = '0';
	  } 
   }
   
   public function DiscussionsController_AfterDiscussionTabs_Handler($Sender, $Args) {
      if(C('Plugins.DiscussionMark.EnableEliteTab')){
		  if (StringEndsWith(Gdn::Request()->Path(), '/elite', TRUE))
			 $CssClass = ' class="Active"';
		  else
			 $CssClass = '';

		  echo '<li'.$CssClass.' style="padding-right:3px;"><a style="background: #FFED27; padding: 5px 13px; color: red; border: red solid 1px;" class="TabLink TabMark" href="'.Url('/discussions/elite').'">精华帖</span></a></li>';
	  }
   }
   
   /**
    * Add Mark to each discussion name in list view
    */
	
	
   public function CategoriesController_Render_Before(&$Sender) {
	$Sender->AddCssFile($this->GetResource('css/mark.css', FALSE, FALSE));
	}
	
	public function DiscussionController_Render_Before(&$Sender) {
	  $Sender->AddCssFile($this->GetResource('css/mark.css', FALSE, FALSE));;
	}
	
   public function DiscussionsController_Render_Before(&$Sender) {
	 if (strcasecmp($Sender->RequestMethod, 'elite') == 0) {
		$Sender->SetData('CountDiscussions', FALSE);
	 }
	 
	$Sender->AddCssFile($this->GetResource('css/mark.css', FALSE, FALSE));
	}
	
   public function Base_BeforeDiscussionMeta_Handler(&$Sender) {
	$EliteStr="精华";
	$RecommendStr="推荐";
	
	if(C('Plugins.DiscussionMark.EliteLable')!=''){
	   $EliteStr=C('Plugins.DiscussionMark.EliteLable');
	}
 	if(C('Plugins.DiscussionMark.RecommendLable')!=''){
	   $RecommendStr=C('Plugins.DiscussionMark.RecommendLable');
	}
	
	if(C('Plugins.DiscussionMark.EnableEliteTag')){
		
		if(C('Plugins.DiscussionMark.EnableEliteLevel')==TRUE){
			if($Sender->EventArguments['Discussion']->CountComments > C('Plugins.DiscussionMark.Elite3CommentNum')){
				$EliteStr = $EliteStr.'3';
			}else if($Sender->EventArguments['Discussion']->CountComments > C('Plugins.DiscussionMark.Elite2CommentNum')){
				$EliteStr = $EliteStr.'2';
			}else if($Sender->EventArguments['Discussion']->CountComments > C('Plugins.DiscussionMark.Elite1CommentNum')){
				$EliteStr = $EliteStr.'1';
			}
		}
		
		if($Sender->EventArguments['Discussion']->Elite == 1){
			 $Src .= '<span class="EliteTag">'.$EliteStr.'</span> ';
			 echo $Src;
			 return;
		}
	}
	
	if(C('Plugins.DiscussionMark.EnableRecommendTag')){
		if($Sender->EventArguments['Discussion']->Recommend == 1){
			 $Src .= '<span class="RecommendTag">'.$RecommendStr.'</span> ';
			 echo $Src;
		}
	}
	
   }
    
   /**
    * Creates a virtual Index method for the DiscussionMark controller
    *
    * Shows the settings for the plugin:
    * - Mark to show before discussion title
    * - What the checkbox label should be
    */
   public function Controller_Index(&$Sender) {  
      $Sender->AddCssFile('admin.css');
      $Sender->AddSideMenu('plugin/discussionmark');
      $Sender->Title(T('Discussion Mark Settings'));
	  
	  $Sender->Form = new Gdn_Form();
      $Validation = new Gdn_Validation();
      $ConfigurationModel = new Gdn_ConfigurationModel($Validation);
	  
      $ConfigurationModel->SetField(array(
	  'Plugins.DiscussionMark.Elite1CommentNum', 
	  'Plugins.DiscussionMark.Elite2CommentNum', 
	  'Plugins.DiscussionMark.Elite3CommentNum',
	  'Plugins.DiscussionMark.EliteLable',
	  'Plugins.DiscussionMark.RecommendLable')
	  );
	  
      $Sender->Form->SetModel($ConfigurationModel);
            
      if ($Sender->Form->AuthenticatedPostBack() === FALSE) {
         $Sender->Form->SetData($ConfigurationModel->Data);
      } else {
         $Data = $Sender->Form->FormValues();
         $ConfigurationModel->Validation->ApplyRule('Plugins.DiscussionMark.Elite3CommentNum', array('', 'Integer'));
		 $ConfigurationModel->Validation->ApplyRule('Plugins.DiscussionMark.Elite2CommentNum', array('', 'Integer'));
		 $ConfigurationModel->Validation->ApplyRule('Plugins.DiscussionMark.Elite1CommentNum', array('', 'Integer'));
         if ($Sender->Form->Save() !== FALSE)
            $Sender->StatusMessage = Gdn::Translate("Your settings have been saved.");
	  }
	  
      $Sender->Render($this->GetView('settings.php'));
   }
   
	public function SettingsController_Elitetag_Create($Sender) {
		$Sender->Permission('Garden.Settings.Manage');
		if (Gdn::Session()->ValidateTransientKey(GetValue(0, $Sender->RequestArgs)))
       SaveToConfig('Plugins.DiscussionMark.EnableEliteTag', C('Plugins.DiscussionMark.EnableEliteTag') ? FALSE : TRUE);
       
    Redirect('plugin/discussionmark');
	}
	
	public function SettingsController_Recommendtag_Create($Sender) {
		$Sender->Permission('Garden.Settings.Manage');
		if (Gdn::Session()->ValidateTransientKey(GetValue(0, $Sender->RequestArgs)))
       SaveToConfig('Plugins.DiscussionMark.EnableRecommendTag', C('Plugins.DiscussionMark.EnableRecommendTag') ? FALSE : TRUE);
       
    Redirect('plugin/discussionmark');
	}
	
	public function SettingsController_Elitelevel_Create($Sender) {
		$Sender->Permission('Garden.Settings.Manage');
		if (Gdn::Session()->ValidateTransientKey(GetValue(0, $Sender->RequestArgs)))
       SaveToConfig('Plugins.DiscussionMark.EnableEliteLevel', C('Plugins.DiscussionMark.EnableEliteLevel') ? FALSE : TRUE);
       
    Redirect('plugin/discussionmark');
	}
	
	public function SettingsController_EliteTab_Create($Sender) {
		$Sender->Permission('Garden.Settings.Manage');
		if (Gdn::Session()->ValidateTransientKey(GetValue(0, $Sender->RequestArgs)))
       SaveToConfig('Plugins.DiscussionMark.EnableEliteTab', C('Plugins.DiscussionMark.EnableEliteTab') ? FALSE : TRUE);
       
    Redirect('plugin/discussionmark');
	}
	

   /**
    * ------------after this line the function is used to init the Database and Save to config value to the config.php
    * 1-Time on Enable
    */
   public function Setup() {
      $this->Structure();
      SaveToConfig('Plugins.DiscussionMark.Enabled', TRUE);
   }
   
   /**
    * Database structure changes
    *
    * 'Marked' column will be bool (1 or 0) to determine 
    * whether discussion gets the Mark
    */
   public function Structure() {
      $Structure = Gdn::Structure();
      $Structure->Table('Discussion')
		 ->Column('Recommend', 'tinyint(1)', 0)
		 ->Column('Elite', 'tinyint(1)', 0)
         ->Set();
   }
   
   /**
    * 1-Time on Disable
    */
   public function OnDisable() {
      SaveToConfig('Plugins.DiscussionMark.Enabled', FALSE);
   }
}