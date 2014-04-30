<?php if (!defined('APPLICATION')) exit();

$PluginInfo['MassDelivery'] = array(
	'Name' => 'Mass Delivery',
	'Description' => 'Mass Delivery.',
	'Version' => '1.0',
	'Author' => 'Ronnie',
	'RequiredApplications' => False,
	'RequiredTheme' => False, 
	'RequiredPlugins' => False,
	'RegisterPermissions' => False,
	'SettingsPermission' => False
);

class MassDeliveryPlugin extends Gdn_Plugin {
	
	public function PluginController_MassDelivery_Create($Sender) {
		$Action = ArrayValue(0, $Sender->RequestArgs);
		$Sender->Form = Gdn::Factory('Form');
		$Sender->AddSideMenu();
		$Sender->AddCssFile( $this->GetWebResource('style.css') );
		$Sender->AddJsFile('jquery.autogrow.js');
		switch ($Action) {
			case 'create': 
			default: $this->Create($Sender);
		}
	}
	
	// 1. Create
	protected function Create($Sender) {
		$Sender->Permission('Garden.Email.Manage');
		$Sender->CanGiveJobToCron = (C('EnabledPlugins.PluginUtils') !== False);
	
		$Validation = new Gdn_Validation();
		$Validation->ApplyRule('RecipientEmailList', array('Required', 'ValidateEmail'));
		$Validation->ApplyRule('Subject', 'Required');
		$Validation->ApplyRule('Body', 'Required');
		$Sender->DrawConfirmSend = False;
		
		if ($Sender->Form->AuthenticatedPostBack() != False) {
			$FormValues = $Sender->Form->FormValues();
			$ValidationResult = $Validation->Validate($FormValues);
			$Sender->Form->SetValidationResults($Validation->Results());
			if ($ValidationResult) {
				$Emails = $this->GetUserEmails($FormValues);
				$Sender->CountEmails = count($Emails);
				if ($Sender->CountEmails == 0) $Sender->Form->AddError('No one to send');
			}
			
			if ($Sender->Form->ErrorCount() == 0) {
				$Sender->DrawConfirmSend = True;
				if (ArrayValue('ConfirmSend', $FormValues)) {
					$Sent = $this->Send($Emails, $FormValues);
					if ($Sent != False) {
						$Sender->StatusMessage = T('Your message was successfully sent.');
					}
				}
			}
		} else {
			$SupportAddress = C('Garden.Email.SupportAddress');
			if (!$SupportAddress) $SupportAddress = 'noreply@'. Gdn::Request()->Host();
			$Sender->Form->SetValue('RecipientEmailList', $SupportAddress);
		}
		
		$Sender->View = $this->GetView('create.php');
		$RoleModel = Gdn::Factory('RoleModel');
		$Sender->RoleData = $RoleModel->Get();
		$Sender->Render();
	}
	
	// 2. Collect user emails
	protected function GetUserEmails($FormValues) {
		$SQL = Gdn::SQL();
		$UserModel = Gdn::UserModel();
		if (ArrayValue('SendMeOnly', $FormValues)) {
			$Session = Gdn::Session();
			$UserID = GetValueR('User.UserID', $Session);
			$User = $UserModel->Get($UserID);
			$Result[$User->Email] = $User->Name;
			return $Result;
		}
		$Roles = ArrayValue('Roles', $FormValues);
		if (is_array($Roles) && count($Roles) > 0) {
			$DataSet = $SQL
				->Select('u.Name, u.Email')
				->From('UserRole r')
				->Join('User u', 'u.UserID = r.UserID')
				->WhereIn('r.RoleID', $Roles)
				->Get();
		} else {
			$DataSet = $SQL
				->Select('u.Name, u.Email')
				->From('User u')
				->Get();
		}
		$Result = ConsolidateArrayValuesByKey($DataSet->ResultArray(), 'Email', 'Name');
		return $Result;
	}
	
	// 3.1
	protected function Send($EmailDataSet, $To, $Subject = False, $Message = False) {
		if (is_array($To)) {
			$RecipientEmailList = GetValue('RecipientEmailList', $To);
			$Subject = GetValue('Subject', $To);
			$Message = GetValue('Body', $To);
		}
		$Email = new Gdn_Email();
		foreach ($EmailDataSet as $RecipientEmail => $RecipientName) 
			$Email->Bcc($RecipientEmail, $RecipientName);
		$Email
			->To($RecipientEmailList)
			->Subject($Subject)
			->Message($Message)
			->Send();
		return True;
	}
	
	// 3.2 Cron
	public static function Tick_Every_10_Minutes_Handler() {
		// not yet
	}
	
	public function Base_GetAppSettingsMenuItems_Handler(&$Sender) {
		$Menu =& $Sender->EventArguments['SideMenu'];
		$Menu->AddLink('Dashboard', T('Mass Delivery'), 'plugin/massdelivery', 'Garden.Email.Manage');
	}
	
	public function Setup() {
	}
}




