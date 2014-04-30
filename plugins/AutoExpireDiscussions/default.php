<?php if (!defined('APPLICATION')) exit();
/**
* # AutoExpireDiscussions #
* 
* ### About ###
* The auto expiry of discussions/questions where there 
* hasn't been a comment in N period.
* 
* Plus a dashboard interface to set a period per category.
* Admin option to reopen and reset auto expiry option and
* Disabling/enabling of auto expiry per discussion.
* 
* ### Sponsor ###
* Special thanks to folkert_test (cargocollective.com) for making this happen.
*/
$PluginInfo['AutoExpireDiscussions'] = array(
   'Name' => 'Auto Expire Discussions',
   'Description' => 'The auto expiry of discussions/questions where there hasn\'t been a comment in N period.',
   'RequiredApplications' => array('Dashboard' => '>=2.0.18.1'),
   'Version' => '0.1b',
   'Author' => 'Paul Thomas',
   'AuthorEmail' => 'dt01pqt_pt@yahoo.com',
   'AuthorUrl' => 'http://www.vanillaforums.org/profile/x00'
);

class AutoExpireDiscussions extends Gdn_Plugin {
	
	protected $DiscussionListExpire = array();
	protected $CategoriesFull = null;
	
	public function Base_GetAppSettingsMenuItems_Handler($Sender) {
		$Menu = $Sender->EventArguments['SideMenu'];
		$Menu->AddLink('Forum', T('Auto Expire Discussions'), 'settings/autoexpire', 'Garden.Settings.Manage');
	}	
	
	public function SettingsController_AutoExpire_Create($Sender) {
		$Sender->Permission('Garden.Settings.Manage');
   		$Sender->Form = Gdn::Factory('Form');
		if($Sender->Form->IsPostBack() != False){
			$Minutes = $Sender->Form->GetValue('AutoExpirePeriod_Minutes');
			$Hours = $Sender->Form->GetValue('AutoExpirePeriod_Hours');
			$Days = $Sender->Form->GetValue('AutoExpirePeriod_Days');
			$Months = $Sender->Form->GetValue('AutoExpirePeriod_Months');
			$Years = $Sender->Form->GetValue('AutoExpirePeriod_Years');
			if(!(empty($Minutes) && empty($Hours) && empty($Days)  && empty($Months) && empty($Years))){
				$Sender->Form->SetFormValue('AutoExpirePeriod',"+{$Years} years {$Months} months {$Days} days {$Hours} hours {$Minutes} minutes");
			}else{
				$Sender->Form->SetFormValue('AutoExpirePeriod',null);
			}
			$FormValues = $Sender->Form->FormValues();
			Gdn::SQL()->Put(
				'Category',
				array('AutoExpirePeriod'=>$FormValues['AutoExpirePeriod']),
				array('CategoryID'=>$FormValues['CategoryID'])
			);
			if(strtolower($FormValues['AutoExpireRetro'])=='yes')
				Gdn::SQL()->Put(
					'Discussion',
					array('AutoExpire'=>1),
					array('CategoryID'=>$FormValues['CategoryID'])
				);
		}
		
		$CategoryModel = new CategoryModel();
		$CategoryFull = $CategoryModel->GetFull();
		$CatsExpire=array();
		foreach($CategoryFull As $Category){
			$CatsExpire[$Category->CategoryID]= $Category->AutoExpirePeriod;
		}
		$Sender->SetData('CatsExpire',json_encode($CatsExpire));
		$Sender->AddSideMenu();
		$Sender->SetData('Title', T('Auto Expire Discussions'));
		$Sender->SetData('Description',$this->PluginInfo['Description']);
		$Sender->Render('Settings', '', 'plugins/AutoExpireDiscussions');
   	}
   	
   	public function DiscussionController_AutoExpire_Create($Sender, $Args){
		$DiscussionID =intval($Args[0]);
		$DiscussionModel = new DiscussionModel();
		$Discussion = $DiscussionModel->GetID($DiscussionID);
		if(!Gdn::Session()->CheckPermission('Vanilla.Discussions.Close',TRUE, 'Category', $Discussion->PermissionCategoryID)){
			throw PermissionException('Vanilla.Discussions.Close');
		}
		if(strtolower($Args[1])=='reset'){
			Gdn::SQL()->Put(
				'Discussion',
				array('AutoExpire'=>1,'Closed'=>0,'DateReOpened'=>Gdn_Format::ToDateTime()),
				array('DiscussionID'=>$DiscussionID)
			);
		}else{
			$Expire = strtolower($Args[1])=='on'?1:0;
			Gdn::SQL()->Put(
				'Discussion',
				array('AutoExpire'=>$Expire),
				array('DiscussionID'=>$DiscussionID)
			);
		}
		
		Redirect('discussion/'.$DiscussionID.'/'.Gdn_Format::Url($Discussion->Name));
		
	}
   	
   	public function Base_CommentOptions_Handler($Sender, $Args) {
		$Comment = GetValue('Comment', $Args);
		$Discussion = GetValue('Discussion', $Args);
		if (!$Discussion || $Comment || !Gdn::Session()->CheckPermission('Vanilla.Discussions.Close',TRUE, 'Category', $Discussion->PermissionCategoryID))
			return;
		$DiscussionID = $Discussion->DiscussionID;
		if($Discussion->Closed && $Discussion->AutoExpire){
			echo '<span>'.Anchor(T('AutoExpire Reset'), '/discussion/autoexpire/'.intval($DiscussionID).'/reset', array('class' => 'AutoExpire Reset', 'title' => T('AutoExpire Reset'))).'</span>';
		
		}elseif($Discussion->AutoExpire)
			echo '<span>'.Anchor(T('AutoExpire (on)'), '/discussion/autoexpire/'.intval($DiscussionID).'/off', array('class' => 'AutoExpire On', 'title' => T('AutoExpire (on)'))).'</span>';
		else
			echo '<span>'.Anchor(T('AutoExpire (off)'), '/discussion/autoexpire/'.intval($DiscussionID).'/on', array('class' => 'AutoExpire Off', 'title' => T('AutoExpire (off)'))).'</span>';
	}
	
	public function DiscussionModel_BeforeSaveDiscussion_Handler($Sender,&$Args){
		$FormVars = &$Args['FormPostValues'];
		$CategoryID = $FormVars['CategoryID'];
		$CategoryModel = new CategoryModel();
		$Category = $CategoryModel->GetFull($CategoryID);
		if(!$Category->AutoExpirePeriod)
			return;
		if(!array_key_exists('AutoExpire',$FormVars) || !Gdn::Session()->CheckPermission('Vanilla.Discussions.Close',TRUE, 'Category', $Category->PermissionCategoryID))
			$FormVars['AutoExpire']=TRUE;
	}
	
	public function ExpireCheck($Discussion){
		if($Discussion->DiscussionID && !$Discussion->Closed && $Discussion->AutoExpire){
			if(empty($this->CategoriesFull)){
				$CategoryModel = new CategoryModel();
				$this->CategoriesFull = $CategoryModel->GetFull();
			}
			foreach($this->CategoriesFull As $Cat){
				if($Cat->CategoryID==$Discussion->CategoryID){
					$Category = $Cat;
					break;
				}
			}
			$DateReOpened = strtotime($Discussion->DateReOpened);
			$DateLastComment = strtotime($Discussion->DateLastComment);
			$DateLast = $DateLastComment>$DateReOpened?$DateLastComment:$DateReOpened;
			$AutoExpirePeriod = strtotime($Category->AutoExpirePeriod)-time();
			if($DateLast+$AutoExpirePeriod<time()){
				$Discussion->Closed=1;
				$this->DiscussionListExpire[] = $Discussion->DiscussionID;
				
			}
		}
	}
	
	public function Expire(){
		if(!empty($this->DiscussionListExpire))
			Gdn::SQL()->Put(
				'Discussion',
				array('AutoExpire'=>1,'Closed'=>1,'DateReOpened'=>null),
				array('DiscussionID'=>$this->DiscussionListExpire)
			);
	}
	
	public function DiscussionsController_Render_Before($Sender){
		foreach($Sender->Discussions As $Discussion){
			$this->ExpireCheck($Discussion);
		}
		$this->Expire();
	}
	
    public function DiscussionController_Render_Before($Sender){
		$this->ExpireCheck($Sender->Discussion);
		$this->Expire();
		
		if(Gdn::Session()->CheckPermission('Vanilla.Discussions.Close',TRUE, 'Category', $Sender->Discussion->PermissionCategoryID) && $Sender->Discussion->Closed && $Sender->Discussion->AutoExpire){
			$Sender->AddJsFile('autoexpire.js','plugins/AutoExpireDiscussions');
		}
		if($Sender->Discussion->Closed && $Sender->Discussion->AutoExpire){
			$Sender->ControllerName='';
			$Sender->ControllerFolder='';
			$ThemeViewLoc = CombinePaths(array(
				PATH_THEMES, $Sender->Theme,'views', 'autoexpirediscussions'
			));
			if(file_exists($ThemeViewLoc.DS.strtolower($Sender->RequestMethod).'.php')){
				$Sender->ApplicationFolder= '';
				$Sender->ControllerName='autoexpirediscussions';
			}else{
				$Sender->ApplicationFolder='plugins/AutoExpireDiscussions';
			}
		}
		
	}
	
/*
	public function Base_AfterDiscussion_Handler($Sender){
		if($Sender->Discussion->Closed && $Sender->Discussion->AutoExpire){
			include($Sender->FetchViewLocation('expired','','plugins/AutoExpireDiscussions'));
			$Sender->Discussion->PermissionCategoryID=null;
		}
	}
*/
	
	public function Base_BeforeDiscussionMeta_Handler($Sender,&$Args){
		$Discussion = $Args['Discussion'];
		if(($Discussion->Closed && $Discussion->AutoExpire) || in_array($Discussion->DiscussionID,$this->DiscussionListExpire)){
			echo  '<span class="Closed Expired">'.T('Expired').'</span>';
			$Discussion->Closed=0;
		}
	}
	
	public function PostController_Render_Before($Sender){
		if(Gdn::Session()->CheckPermission('Vanilla.Discussions.Close')){
			$CategoryModel = new CategoryModel();
			$CategoryFull = $CategoryModel->GetFull();
			$CatsExpire=array();
			foreach($CategoryFull As $Category){
				$CatsExpire[$Category->CategoryID]=Gdn::Session()->CheckPermission('Vanilla.Discussions.Close',TRUE, 'Category', $Category->PermissionCategoryID) && $Category->AutoExpirePeriod;
			}
			$Sender->AddDefinition('CatsExpire',json_encode($CatsExpire));
			$Sender->AddJsFile('autoexpirecheck.js','plugins/AutoExpireDiscussions');
		}
	}
	
	public function Base_DiscussionFormOptions_Handler($Sender,&$Args){
		$DefaultExpire = FALSE;
		if(!$Sender->Form->HiddenInputs['DiscussionID'])
			$DefaultExpire = C('Plugins.AutoExpireDiscussions.AdminDefaultExpire',TRUE);
		if(Gdn::Session()->CheckPermission('Vanilla.Discussions.Close')){
			$Args['Options'].='<li>'.$Sender->Form->CheckBox('AutoExpire', T('Auto Expire'), $DefaultExpire?array('value' => '1','checked'=>'checked'):array('value' => '1')).'</li>';
		}
	}
	
    public function Setup() {
        $this->Structure();
    }
    
    public function Base_BeforeDispatch_Handler($Sender){
        if(C('Plugins.AutoExpireDiscussions.Version')!=$this->PluginInfo['Version'])
            $this->Structure();
    }
    
    public function Structure() {
		
        Gdn::Structure()
            ->Table('Category')
            ->Column('AutoExpirePeriod','varchar(150)',NULL)
            ->Set();
        Gdn::Structure()
            ->Table('Discussion')
            ->Column('AutoExpire','int(4)',0)
            ->Column('DateReOpened','datetime',NULL)
            ->Set();
            
		//Save Version for hot update
		
		SaveToConfig('Plugins.AutoExpireDiscussions.Version', $this->PluginInfo['Version']);
	}

}
