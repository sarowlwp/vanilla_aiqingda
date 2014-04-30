<?php if (!defined('APPLICATION'))  exit();


// Define the plugin:
$PluginInfo['HideCategory'] = array(
    'Name' => 'HideCategory',
    'Description' => 'Hides discussions for a specified Category in "All Discussions" but they will still be viewable when from the specific category. Settings menu allows up to 6 categories to be hidden.',
    'Version' => '1.1.1',
    'RequiredApplications' => FALSE,
    'RequiredTheme' => FALSE,
    'RequiredPlugins' => FALSE,
    'SettingsUrl' => '/dashboard/plugin/hidecategory',
    'Author' => "Peregrine"
);

class HideCategoryPlugin extends Gdn_Plugin {

  public function DiscussionsController_Render_Before($Sender) {
        $Formatter = C('Garden.InputFormatter', 'Html');
        $this->AttachHideCategoryResources($Sender, $Formatter);
        }

    public function DiscussionsController_BeforeDiscussionName_Handler($Sender) {
        $hideCategory1 = strtolower(C('Plugins.HideCategory.NoCat'));
        $hideCategory1 = preg_replace('/\s+/','-',$hideCategory1);
        
        $hideCategory2 = strtolower(C('Plugins.HideCategory.NoCat2'));
        $hideCategory2 = preg_replace('/\s+/','-',$hideCategory2);
        
        $hideCategory3 = strtolower(C('Plugins.HideCategory.NoCat3'));
        $hideCategory3 = preg_replace('/\s+/','-',$hideCategory3);
        
        $hideCategory4 = strtolower(C('Plugins.HideCategory.NoCat4'));
        $hideCategory4 = preg_replace('/\s+/','-',$hideCategory4);
       
        $hideCategory5 = strtolower(C('Plugins.HideCategory.NoCat5'));
        $hideCategory5 = preg_replace('/\s+/','-',$hideCategory5);
        
        $hideCategory6 = strtolower(C('Plugins.HideCategory.NoCat6'));
        $hideCategory6 = preg_replace('/\s+/','-',$hideCategory6);
       
         $Object = ($Sender->EventArguments['Discussion']);
         $newcss = $Sender->EventArguments['CssClass']; 
         $newcss = $newcss . " hideme"; 
   
     
        if ((!$Sender->Category) && (($Object->CategoryUrlCode == $hideCategory1)
        || ($Object->CategoryUrlCode == $hideCategory2)
        || ($Object->CategoryUrlCode == $hideCategory3)
        || ($Object->CategoryUrlCode == $hideCategory4)
        || ($Object->CategoryUrlCode == $hideCategory5)
        || ($Object->CategoryUrlCode == $hideCategory6)))
        
        {
        $Sender->EventArguments['CssClass'] =  $newcss;   
       //  echo $Sender->EventArguments['CssClass'];
       
       
       
       
        }
     }
  
   public function PluginController_HideCategory_Create(&$Sender, $Args = array()) {
        $Sender->Permission('Garden.Settings.Manage');
        $Sender->Form = new Gdn_Form();
        $Validation = new Gdn_Validation();
        $ConfigurationModel = new Gdn_ConfigurationModel($Validation);
        $ConfigurationModel->SetField(array(
            'Plugins.HideCategory.NoCat',
            'Plugins.HideCategory.NoCat2',
            'Plugins.HideCategory.NoCat3',
            'Plugins.HideCategory.NoCat4',
            'Plugins.HideCategory.NoCat5',
            'Plugins.HideCategory.NoCat6',
        ));
        $Sender->Form->SetModel($ConfigurationModel);


        if ($Sender->Form->AuthenticatedPostBack() === FALSE) {
            $Sender->Form->SetData($ConfigurationModel->Data);
        } else {
            $Data = $Sender->Form->FormValues();

            if ($Sender->Form->Save() !== FALSE)
                $Sender->StatusMessage = T("Your settings have been saved.");
        }

        $Sender->Render($this->GetView('hc-settings.php'));
    }
  
  
  
  
  
  
       protected function AttachHideCategoryResources($Sender, $Formatter) {
        $Sender->AddCssFile('hidecategory.css', 'plugins/HideCategory');
    } 

   
     public function Setup() {
        
    } 

}

