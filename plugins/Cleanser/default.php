<?php if (!defined('APPLICATION')) exit();

 
$PluginInfo['Cleanser'] = array(
   'Name' => 'Cleanser',
   'Description' => 'The perfect administrator tool.  List users based on role and ip w/ ability to mass delete unwanted users, spambots, etc. See the readme.txt ',
   'Version' => '2.3',
   'SettingsUrl' => '/dashboard/settings/cleanser',
   'RegisterPermissions' => array('Plugins.Cleanser.Manage'),
   'SettingsPermission' => 'Plugins.Cleanser.Manage',
   'Author' => "Peregrine",
);


class CleanserPlugin extends Gdn_Plugin {

  public function SettingsController_Cleanser_Create($Sender) {
       
        // set the roleid that you are selecting for.
        $Session = Gdn::Session();
        
        $Sender->RoleData = CleanserModel::GetRoleList();
       
        $Sender->Title('Cleanser');
        $Sender->AddSideMenu('plugin/cleanser');
        $Sender->Form = new Gdn_Form();
        $Validation = new Gdn_Validation();
        $ConfigurationModel = new Gdn_ConfigurationModel($Validation);
        $ConfigurationModel->SetField(array(
            'Plugins.Cleanser.Action',
            'Plugins.Cleanser.MaxRecords',
            'Plugins.Cleanser.Offset',
            'Plugins.Cleanser.RoleSet',
            'Plugins.Cleanser.IPAddress',
            'Plugins.Cleanser.PatternMatch'
        ));
        $Sender->Form->SetModel($ConfigurationModel);


        if ($Sender->Form->AuthenticatedPostBack() === FALSE) {
            $Sender->Form->SetData($ConfigurationModel->Data);
        } else {
            $Data = $Sender->Form->FormValues();
       
            if ($Sender->Form->Save() !== FALSE)
               $cleanseraction = Gdn::Config("Plugins.Cleanser.Action");        
           
         
               if ($cleanseraction == "create") {
               $CleanserOffset=  Gdn::Config("Plugins.Cleanser.Offset");
               $CleanserMaxRecords = Gdn::Config("Plugins.Cleanser.MaxRecords");
               $RoleSet = Gdn::Config("Plugins.Cleanser.RoleSet");
               $IPAddSet = Gdn::Config("Plugins.Cleanser.IPAddress");
               $PatternSet = Gdn::Config("Plugins.Cleanser.PatternMatch");
               
               
               CleanserModel::CreateCleanserList($RoleSet,$IPAddSet,$CleanserOffset,$CleanserMaxRecords,$PatternSet); 
               $Sender->StatusMessage = T("cleanserlist created");
               } 
             
       
              if ($cleanseraction == "delete") {
               $this->CleanserPurge(); 
               $Sender->StatusMessage = T("delete users from cleanserlist from database");
               SaveToConfig('Plugins.Cleanser.Action',"create");
               }
        
        
        }

        $Sender->Render($this->GetView('cleanser-settings.php'));
 }



 public function PluginController_Cleanser_Create($Sender) {

        if ($Sender->Menu) {
            $Sender->ClearCssFiles();
            $Sender->AddCssFile('style.css');
            $Sender->MasterView = 'default';
            $Sender->Render('PreviewCleanserList', '', 'plugins/Cleanser');
        }

}


 public function CleanserPurge(){
    
         ini_set("auto_detect_line_endings", true);
         $filename = "plugins/Cleanser/list/cleanserlisttxt";

        if(file_exists($filename)) {
        $fp = fopen($filename,'r');
        while(!feof($fp)) { 
          $infoline = fgets($fp);
          $parts = explode('|', $infoline);
          if ($parts[0] > "2") {
          CleanserModel::DeleteAction($parts[0]);
          }
        }
        fclose($file);
       
    }       

}


public function Base_GetAppSettingsMenuItems_Handler($Sender) {
      $Menu = $Sender->EventArguments['SideMenu'];
      $Menu->AddLink('Moderation', 'Cleanser Settings', 'settings/cleanser', 'Plugins.Cleanser.Manage');
      $Menu->AddLink('Moderation', 'View Cleanser List', 'plugin/cleanser', 'Plugins.Cleanser.Manage');
   }



 
  public function Setup() {
        
    }
    
    }
