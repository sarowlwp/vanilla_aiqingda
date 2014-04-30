<?php if (!defined('APPLICATION')) exit();
/*
Copyright 2008, 2009 Vanilla Forums Inc.
This file is part of Garden.
Garden is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
Garden is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with Garden.  If not, see <http://www.gnu.org/licenses/>.
Contact Vanilla Forums Inc. at support [at] vanillaforums [dot] com
*/

// Define the plugin:
$PluginInfo['TecentConnect'] = array(
	'Name' => 'TecentConnect',
   'Description' => 'This plugin integrates TecentQQLogin with Vanilla. <b>使用前请先到腾讯开放平台申请APPKEY.</b>',
   'Version' => '0.1a',
   'RequiredApplications' => array('Vanilla' => '2.0.18'),
   'RegisterPermissions' => array('Vanilla.TecentConnect.Use'),
   'RequiredTheme' => FALSE,
   'RequiredPlugins' => FALSE,
	'MobileFriendly' => TRUE,
   'SettingsUrl' => '/dashboard/settings/tecentconnect',
   'SettingsPermission' => NULL,
   'HasLocale' => TRUE,
   'Author' => "sarowlwp, Todd Burry",
   'AuthorEmail' => 'todd@vanillaforums.com',
   'AuthorUrl' => 'http://www.vanillaforums.org/profile/todd'
);
require_once("get_access_token.php");
require_once("get_user_info.php");
require_once("get_request_token.php");
require_once PATH_LIBRARY.'/vendors/oauth/OAuth.php';

class TecentConnectPlugin extends Gdn_Plugin {
   public static $ProviderKey = 'Tecent';
   public static $BaseApiUrl = 'http://openapi.qzone.qq.com/';

   protected $_AccessToken = NULL;

   /**
    * Gets/sets the current oauth access token.
    *
    */
   public function AccessToken($Token = NULL, $Secret = NULL) {
      if ($Token !== NULL && $Secret !== NULL) {
         $this->_AccessToken = new OAuthToken($Token, $Secret);
         setcookie('tecent_access_token', $Token, 0, C('Garden.Cookie.Path', '/'), C('Garden.Cookie.Domain', ''));
      } elseif ($this->_AccessToken == NULL) {
         $Token = GetValue('tecent_access_token', $_COOKIE, NULL);
         if ($Token)
            $this->_AccessToken = $this->GetOAuthToken($Token);
      }
      return $this->_AccessToken;
   }

   public function AuthenticationController_Render_Before($Sender, $Args) {
      if (isset($Sender->ChooserList)) {
         $Sender->ChooserList['TecentConnect'] = 'TecentConnect';
      }
      if (is_array($Sender->Data('AuthenticationConfigureList'))) {
         $List = $Sender->Data('AuthenticationConfigureList');
         $List['TecentConnect'] = '/dashboard/settings/TecentConnect';
         $Sender->SetData('AuthenticationConfigureList', $List);
      }
   }

   protected function _AuthorizeHref($Popup = FALSE) {
      $Url = Url('/entry/tecentauthorize', TRUE);
      $UrlParts = explode('?', $Url);

      parse_str(GetValue(1, $UrlParts, ''), $Query);
      $Path = Gdn::Request()->Path();
      $Query['Target'] = GetValue('Target', $_GET, $Path ? $Path : '/');

//      if (isset($_GET['Target']))
//         $Query['Target'] = $_GET['Target'];
      if ($Popup)
         $Query['display'] = 'popup';
      $Result = $UrlParts[0].'?'.http_build_query($Query);

      return $Result;
   }

   /**
    *
    * @param Gdn_Controller $Sender
    */
   public function EntryController_SignIn_Handler($Sender, $Args) {
      if (isset($Sender->Data['Methods'])) {
         if (!$this->IsConfigured())
            return;

         $AccessToken = $this->AccessToken();

         $ImgSrc = Asset('/plugins/TecentConnect/design/Connect_big.png');
         $ImgAlt = T('Sign In with TecentQQ');

         if (FALSE && $AccessToken) {
            $SigninHref = $this->RedirectUri();

            // We already have an access token so we can just link to the connect page.
            $TwMethod = array(
                'Name' => 'TecentConnect',
                'SignInHtml' => "<a href=\"$SigninHref\" target=\"_blank\"><img src=\"$ImgSrc\" alt=\"$ImgAlt\" /></a>");
         } else {
            $SigninHref = $this->_AuthorizeHref();
            $PopupSigninHref = $this->_AuthorizeHref(TRUE);

            // Add the twitter method to the controller.
            $TwMethod = array(
               'Name' => 'TecentConnect',
               'SignInHtml' => "<a href=\"$SigninHref\"  target=\"_blank\"><img src=\"$ImgSrc\" alt=\"$ImgAlt\" /></a>");
        
		 }

         $Sender->Data['Methods'][] = $TwMethod;
      }
   }

   public function Base_BeforeSignInButton_Handler($Sender, $Args) {
      if (!$this->IsConfigured())
			return;
			
		echo "\n".$this->_GetButton();
	}
	
	public function Base_BeforeSignInLink_Handler($Sender) {
      if (!$this->IsConfigured())
			return;
		
		// if (!IsMobile())
		// 	return;

		if (!Gdn::Session()->IsValid())
			echo "\n".Wrap($this->_GetButton(), 'li', array('class' => 'Connect TecentConnect'));
	}
	
	private function _GetButton() {      
      $ImgSrc = Asset('/plugins/TecentConnect/design/Connect_small.png');
      $ImgAlt = T('Sign In with TecentQQ');
      $SigninHref = $this->_AuthorizeHref();
      $PopupSigninHref = $this->_AuthorizeHref(TRUE);
	  return "<span><a href=\"$SigninHref\" target=\"_blank\"><img src=\"$ImgSrc\" alt=\"$ImgAlt\" />QQ登录</a></span>";
   
   }

	public function Authorize($Query = FALSE) {
      // Aquire the request token.
      $Consumer = new OAuthConsumer(C('Plugins.TecentConnect.ConsumerKey'), C('Plugins.TecentConnect.Secret'));

	  $appkey=C('Plugins.TecentConnect.Secret');
	  $appid=C('Plugins.TecentConnect.ConsumerKey');
		
      $result = get_request_token($appid,$appkey);

         $Data = OAuthUtil::parse_parameters($result);

         if (!isset($Data['oauth_token']) || !isset($Data['oauth_token_secret'])) {
            $Response = T('The response was not in the correct format.');
         } else {
            // Save the token for later reference.
            $this->SetOAuthToken($Data['oauth_token'], $Data['oauth_token_secret'], 'access');
			
            // Redirect to twitter's authorization page.
            $Url = "http://openapi.qzone.qq.com/oauth/qzoneoauth_authorize?oauth_token={$Data['oauth_token']}&oauth_consumer_key=".$appid."&oauth_callback=http://".C('Plugins.TecentConnect.SiteUrl')."/entry/connect/tecentconnect";
            Redirect($Url);
			
         }
      //}

      // There was an error. Echo the error.
      echo $Response;
   }

   public function EntryController_Tecentauthorize_Create($Sender, $Args) {
      $Query = ArrayTranslate($Sender->Request->Get(), array('display', 'Target'));
      $Query = http_build_query($Query);
      $this->Authorize($Query);
   }

   /**
    *
    * @param Gdn_Controller $Sender
    * @param array $Args
    */
   public function Base_ConnectData_Handler($Sender, $Args) {
      if (GetValue(0, $Args) != 'tecentconnect')
         return;

	  $appkey=C('Plugins.TecentConnect.Secret');
	  $appid=C('Plugins.TecentConnect.ConsumerKey');
		 
      $RequestToken = GetValue('oauth_token', $_GET);
      $oauth_vericode = GetValue('oauth_vericode', $_GET);
	  $ConnectName = GetValue('Form/ConnectName', $_POST);
	  $ConnectOpenID = GetValue('openid', $_GET);
	  //echo $RequestToken;
	  //echo $ConnectName;
	  //echo $oauth_vericode;
	  
      // Get the access token.
      if ($RequestToken || !($AccessToken = $this->AccessToken())) {
         // Get the request secret.
         $RequestToken = $this->GetOAuthToken($RequestToken);
		 //echo $appid.'$1';
		 //echo $appkey.'$2';
		 //echo $$RequestToken->secret.'$3';
		 //echo $oauth_token_secret.'$4';
		 //echo $oauth_vericode.'$5';
		 //echo $RequestToken;
		 //echo $RequestToken->secret;
		
        $result = get_access_token($appid, $appkey, $RequestToken->key, $RequestToken->secret, $oauth_vericode);
		$Data = OAuthUtil::parse_parameters($result);
		$AccessToken = $this->AccessToken(GetValue('oauth_token', $Data), GetValue('oauth_token_secret', $Data));
		//echo GetValue('oauth_token', $Data);
		//echo GetValue('oauth_token_secret', $Data);
		// Save the access token to the database.
		$this->SetOAuthToken($AccessToken);
		// Delete the request token.
		$this->DeleteOAuthToken($RequestToken);
         //echo GetValue('openid', $Data);
         $NewToken = TRUE;
      }else{
		echo 'xxx';
	  }
      // Get the profile.

	  try {
         $Profile = $this->GetQQInfo($appid,$appkey,GetValue('oauth_token', $Data),GetValue('oauth_token_secret', $Data),GetValue('openid', $Data));
		 //echo GetValue('oauth_token', $Data);
		 //echo GetValue('oauth_token_secret', $Data);
		 //echo $Profile['gender'];
		 //echo $Profile['nickname'];
      } catch (Exception $Ex) {
         if (!isset($NewToken)) {
            // There was an error getting the profile, which probably means the saved access token is no longer valid. Try and reauthorize.
            if ($Sender->DeliveryType() == DELIVERY_TYPE_ALL) {
               Redirect($this->_AuthorizeHref());
            } else {
               $Sender->SetHeader('Content-type', 'application/json');
               $Sender->DeliveryMethod(DELIVERY_METHOD_JSON);
               $Sender->RedirectUrl = $this->_AuthorizeHref();
            }
         } else {
            $Sender->Form->AddError($Ex);
         }
      }
        //print_r($Profile);
		
		$OpenID=GetValue('openid', $Data);
		if(ConnectName!=''){
			$OpenID = $ConnectOpenID;
		}
	    $UserID=md5($OpenID);
		$Form = $Sender->Form; //new Gdn_Form();
		$ID = $UserID;
		$Form->SetFormValue('UniqueID', $OpenID);
		$Form->SetFormValue('Provider', self::$ProviderKey);
		$Form->SetFormValue('ProviderName', 'Tecent');

		//$Form->SetFormValue('Gender', GetValue('gender', $Profile));
		if($ConnectName!=''){
			$Form->SetFormValue('Name', $ConnectName);
			$Form->SetFormValue('FullName', $ConnectName);
		}else{
		    if(!C('Plugins.Tecent.ChooseName')){
				$Form->SetFormValue('Name', GetValue('nickname', $Profile));
				$Form->SetFormValue('FullName', GetValue('nickname', $Profile));
			}
		}
		if(GetValue('gender', $Profile)=='男'){
			$Form->SetFormValue('Gender', 'm');
		}
		if(GetValue('gender', $Profile)=='女'){
			$Form->SetFormValue('Gender', 'f');
		}
		if($Sender->User->Email==''){
		    //不再默认邮箱和头像，QQ头像外链研究下，让用户自己来输入
			//$Form->SetFormValue('Email', $UserID.'@qq.member.com');
		}
		if($Sender->User->Photo==''){
			//$Form->SetFormValue('Photo', GetValue('profile_image_url', GetValue('figureurl_2', $Profile)));
		}
		$Sender->SetData('Verified', TRUE);
		//echo 'openid:'.$OpenID;
		//echo 'nick:'.GetValue('nickname', $Profile);
		//echo 'email:'.$UserID.'@qq.member.com';
		//echo 'photo:'.GetValue('figureurl_2', $Profile);
		//echo 'token:'.GetValue('oauth_token', $Data);
   }


   public function GetQQInfo($appid,$appkey,$token,$secret,$openid){
	   return $arr = get_user_info($appid,$appkey,$token,$secret,$openid);
   }
   public function GetProfile() {
      $Profile = $this->API('/account/verify_credentials.json');
      return $Profile;
   }

   public function GetOAuthToken($Token) {
      $Row = Gdn::SQL()->GetWhere('UserAuthenticationToken', array('Token' => $Token, 'ProviderKey' => self::$ProviderKey))->FirstRow(DATASET_TYPE_ARRAY);
      if ($Row) {
         return new OAuthToken($Row['Token'], $Row['TokenSecret']);
      } else {
         return NULL;
      }
   }

   public function IsConfigured() {
      $Result = C('Plugins.TecentConnect.ConsumerKey') && C('Plugins.TecentConnect.Secret')  && C('Plugins.TecentConnect.SiteUrl');;
      return $Result;
   }

   public function SetOAuthToken($Token, $Secret = NULL, $Type = 'request') {
      if (is_a($Token, 'OAuthToken')) {
         $Secret = $Token->secret;
         $Token = $Token->key;
      }

      // Insert the token.
      $Data = array(
                'Token' => $Token,
                'ProviderKey' => self::$ProviderKey,
                'TokenSecret' => $Secret,
                'TokenType' => $Type,
                'Authorized' => FALSE,
                'Lifetime' => 60 * 5);
      Gdn::SQL()->Options('Ignore', TRUE)->Insert('UserAuthenticationToken', $Data);
   }

   public function DeleteOAuthToken($Token) {
      if (is_a($Token, 'OAuthToken')) {
         $Token = $Token->key;
      }
      
      Gdn::SQL()->Delete('UserAuthenticationToken', array('Token' => $Token, 'ProviderKey' => self::$ProviderKey));
   }

   /**
    *
    * @param OAuthRequest $Request 
    */
   protected function _Curl($Request) {
      $C = curl_init();
      curl_setopt($C, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($C, CURLOPT_SSL_VERIFYPEER, FALSE);
      switch ($Request->get_normalized_http_method()) {
         case 'POST':
            curl_setopt($C, CURLOPT_URL, $Request->get_normalized_http_url());
            curl_setopt($C, CURLOPT_POST, TRUE);
            curl_setopt($C, CURLOPT_POSTFIELDS, $Request->to_postdata());
            break;
         default:
            curl_setopt($C, CURLOPT_URL, $Request->to_url());
      }
      return $C;
   }

   protected $_RedirectUri = NULL;

   public function RedirectUri($NewValue = NULL) {
      if ($NewValue !== NULL)
         $this->_RedirectUri = $NewValue;
      elseif ($this->_RedirectUri === NULL) {
         $RedirectUri = Url('/entry/connect/TecentConnect', TRUE);
         $this->_RedirectUri = $RedirectUri;
      }

      return $this->_RedirectUri;
   }

   public function SettingsController_TecentConnect_Create($Sender, $Args) {
      if ($Sender->Form->IsPostBack()) {
         $Settings = array(
             'Plugins.TecentConnect.ConsumerKey' => $Sender->Form->GetFormValue('ConsumerKey'),
			 'Plugins.TecentConnect.SiteUrl' => $Sender->Form->GetFormValue('SiteUrl'),
             'Plugins.TecentConnect.Secret' => $Sender->Form->GetFormValue('Secret'));
			 

         SaveToConfig($Settings);
         $Sender->StatusMessage = T("Your settings have been saved.");

      } else {
         $Sender->Form->SetFormValue('ConsumerKey', C('Plugins.TecentConnect.ConsumerKey'));
		 $Sender->Form->SetFormValue('SiteUrl', C('Plugins.TecentConnect.SiteUrl'));
         $Sender->Form->SetFormValue('Secret', C('Plugins.TecentConnect.Secret'));
      }

      $Sender->AddSideMenu();
      $Sender->SetData('Title', T('TecentConnect Settings'));
      $Sender->Render('Settings', '', 'plugins/TecentConnect');
   }
   
   	public function SettingsController_ChooseName_Create($Sender) {
		$Sender->Permission('Garden.Settings.Manage');
		if (Gdn::Session()->ValidateTransientKey(GetValue(0, $Sender->RequestArgs)))
       SaveToConfig('Plugins.Tecent.ChooseName', C('Plugins.Tecent.ChooseName') ? FALSE : TRUE);
       
       $Sender->Render('Settings', '', 'plugins/TecentConnect');
	}
	
   public function Base_GetAppSettingsMenuItems_Handler(&$Sender) {
      $Menu = &$Sender->EventArguments['SideMenu'];
      $Menu->AddLink('Forum', 'TecentConnect', 'settings/tecentconnect', 'Vanilla.DiscussionMark.Manage');
   }
   
   public function Setup() {
      // Make sure the user has curl.
      if (!function_exists('curl_exec')) {
         throw new Gdn_UserException('This plugin requires curl.');
      }

      // Save the twitter provider type.
      Gdn::SQL()->Replace('UserAuthenticationProvider',
         array('AuthenticationSchemeAlias' => 'tecent', 'URL' => '...', 'AssociationSecret' => '...', 'AssociationHashMethod' => '...'),
         array('AuthenticationKey' => self::$ProviderKey));
   }
   
}