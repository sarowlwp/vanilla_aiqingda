<?php if (!defined('APPLICATION')) exit();

/**

 *
 */

$PluginInfo['LikeThis'] = array(
   'Name' => 'I Like This ( Plugin )',
   'Description' => 'Like Posts Like on Facebook -- now with More Karma (integration)',
   'Version' => '0.5',
   'RequiredApplications' => array('Vanilla' => '2.0.18'),
   'RequiredTheme' => FALSE, 
   'RequiredPlugins' => FALSE,
   'HasLocale' => TRUE,
   'RegisterPermissions' => FALSE,
   'Author' => "HBF",
   'AuthorEmail' => 'sales@imperialcraftbrewery.com',
   'AuthorUrl' => 'http://www.homebrewforums.net',
   'MobileFriendly' => FALSE,
);



/**
 * LikePlugin class.
 *
 * This class does it all.
 */
class LikeThis extends Gdn_Plugin {

  /**
   * @var LikeModel
   */
  public $LikeModel;

  /**
   * Sets up database structure when plugin is enabled.
   *
   * @return void
   */
  public function Setup() {
    $this->Structure();
  }

//connect with Karma
/*public static function OperationDiffEquals($MetaValue,$Target,$Condition,$User,$LastTrans){
    $Difference=$MetaValue-($LastTrans ? $LastTrans->LastTally : 0);
    if(abs($Difference)%$Target!==0)
        return FALSE;
    return abs($Difference)!= $Difference? -1:1;
}*/

public function KarmaBank_KarmaBankMetaMap_Handler($Sender){
	$Sender->AddMeta('ILiked','(Requires I Liked This plugin) Counts Everytime you liked someone elses post');
	$Sender->AddMeta('Liked','Counts Everytime someone likes one of your post');
//    $Sender->AddOpperation('Value Change','Increment or Decrement on change','LikeThis::OperationDiffEquals');
}
  /**
   * Loads and instantiates the model.
   *
   * @return void
   */
  public function __construct() {
    parent::__construct();
    require_once (dirname(__FILE__) . '/LikeModel.php');
    $this->LikeModel = new LikeModel();
  }

public function Base_BeforeDiscussionMeta_Handler($Sender, $Args){
        // This method gets called before the Render method gets called on the DiscussionsController object.
		$Discussion = $Args['Discussion'];
		$ID = $Discussion->DiscussionID;
		$Likes = $this->LikeModel->GetTotalDiscussionLikes($ID);
		$CountLikes =  count($Likes);
		if($CountLikes)
   			$Src .= '<span class="likes">' .$CountLikes. sprintf($CountLikes>1?T(' Likes'):T(' Like')).'</span> ';
		echo $Src;
    }
	
  public function CategoriesController_Render_Before(&$Sender) {
	$Sender->AddCssFile($this->GetResource('css/like.css', FALSE, FALSE));
	}	
  public function DiscussionsController_Render_Before(&$Sender) {
	$Sender->AddCssFile($this->GetResource('css/like.css', FALSE, FALSE));
	}

  /**
   * A hook which creates a fake action "like" on the discussion controller.
   * This action handles all the liking and unliking.
   *
   * @param Controller $Sender
   * @return void
   */
  public function DiscussionController_Like_Create(&$Sender) {

    $Session = Gdn::Session();
	$User = $Session->User;
	$UID = $User->UserID;
    $Options = Array('UserID' => $User->UserID);
	$DiscussionID = GetValue(0, $Sender->RequestArgs);

    $DiscussionModel = new DiscussionModel();
	$CommentModel = new CommentModel();
    $Discussion = $DiscussionModel->GetID($DiscussionID);
	      // Check for permission.
      if (!( $Session->IsValid() && $Session->CheckPermission('Vanilla.Comments.Add', TRUE, 'Category',  		$Discussion->PermissionCategoryID))) {
        return;
      }


	$Options["DiscussionID"] = $DiscussionID;
    //$Sender->Permission('Vanilla.Discussions.View', TRUE, 'Category', $Discussion->CategoryID);

    if (GetValue(1, $Sender->RequestArgs) == 'comment') {
      $CommentID = GetValue(2, $Sender->RequestArgs);
      $Remove = GetValue(3, $Sender->RequestArgs);
      $Options["CommentID"] = $CommentID;
	  $Comment = $CommentModel->GetID($CommentID);
	  $Recipient = Gdn::UserModel()->GetID($Comment->InsertUserID);
      $RedirectURL = Url("../discussion/{$DiscussionID}#Item_{$CommentID}");
    } else {
      $Remove = GetValue(1, $Sender->RequestArgs);
	  $Recipient = Gdn::UserModel()->GetID($Discussion->InsertUserID);
      $RedirectURL = Url("../discussion/{$DiscussionID}"); 

    }

    if (!$Remove) {
      $this->LikeModel->Insert($Options); //$options includes current user id and discussion or comment id
	  //Increment number of times someone liked one of the commentators posts
	  Gdn::SQL()->Update('User',array('Liked'=>$Recipient->Liked+1))->Where(array('UserID'=>$Recipient->UserID))->Put();
	  //Increment number of times this person has liked someone elses post
	  Gdn::SQL()->Update('User',array('ILiked'=>$User->ILiked+1))->Where(array('UserID'=>$User->UserID))->Put();
      $Sender->InformMessage(T('Liked.'));

    } else {
      $this->LikeModel->Delete($Options);
	  //Decrement number of times someone liked one of the commentators posts
	  Gdn::SQL()->Update('User',array('Liked'=>$Recipient->Liked-1))->Where(array('UserID'=>$Recipient->UserID))->Put();
	  //Decrement number of times this person has liked someone elses post
	  Gdn::SQL()->Update('User',array('ILiked'=>$User->ILiked-1))->Where(array('UserID'=>$User->UserID))->Put();
      $Sender->InformMessage( 'You don\'t like that anymore.', "Dismissable");

    }

    if ($Sender->DeliveryType() == DELIVERY_TYPE_BOOL) {
      if (isSet($CommentID)) {
        $Likes = $this->LikeModel->GetCommentLikes($CommentID);
        $Url = "$DiscussionID/comment/$CommentID";
        $Sender->JSON('LikeNewLink', $this->FormatLikes($Likes, $Url, $UID, FALSE));
      } else {
        $Likes = $this->LikeModel->GetDiscussionLikes($DiscussionID);
        $Url = "$DiscussionID";
        $Sender->JSON('LikeNewLink', $this->FormatLikes($Likes, $Url, $UID, FALSE));
      }

      $Sender->Render();
      return;

    }

    Redirect($RedirectURL);

  }

  /**
   * This only adds the Like plugin's javascript file to the controller.
   *
   * @param Controller $Sender
   * @return void
   */
  public function DiscussionController_BeforeDiscussionRender_Handler(&$Sender) {
	$Sender->AddCssFile($this->GetResource('css/like.css', FALSE, FALSE));
    $Sender->AddJSFile($this->GetResource('like.js', FALSE, FALSE));

  }

  /**
   * A hook which displays info on how much the posts are liked or not.
   *
   * @param Controller $Sender
   * @return void
   */
    public function PostController_CommentOptions_Handler($Sender) {
		
		}
	
  public function DiscussionController_CommentOptions_Handler(&$Sender) {
	$Session = Gdn::Session();
	$User = $Session->User;
    $UID = $User->UserID;
	$DiscusionID = $Sender->EventArguments['Object']->DiscussionID;
//echo 'dmodel';
    $DiscussionModel = new DiscussionModel();
	$CommentModel = new CommentModel();
    $Discussion = $DiscussionModel->GetID($DiscussionID);
	      // Check for permission.
	//	  echo 'pcheck';
      if (!Gdn::Session()->UserID) return;
	
	
	
    if ($Sender->EventArguments['Type'] == 'Discussion') {
      if ($Sender->Data['Comments'] instanceof Gdn_DataSet)
        $this->LikeModel->PreloadLikes($Sender->Data['Comments']);
	  $ID = $DiscusionID;
      $Model = new DiscussionModel();
	  $Data = $Model->GetID($ID);
      $Likes = $this->LikeModel->GetDiscussionLikes($ID);
      $Url = $DiscusionID;

    } else {
	  $ID = $Sender->EventArguments['Object']->CommentID;
	  $Model = new CommentModel();
	  $Data = $Model->GetID($ID);
      $Likes = $this->LikeModel->GetCommentLikes($ID);
      $Url = $DiscusionID . '/comment/' . $Sender->EventArguments['Object']->CommentID;

    }
	$InsertID = $Data->InsertUserID;
	if($InsertID == $UID)
	  $Self = TRUE;
	else
	  $Self = FALSE;
    $Sender->Options .= '<span class="Like">';
    $Sender->Options .= $this->FormatLikes($Likes, $Url, $UID, $Self);
    $Sender->Options .= '</span>';

  }

  /**
   * This formats the liking info.
   *
   * @param Array $Likes
   * @param string $Url
   * @param int CurrentUser User ID
   * @param bool Comment posted by CurrentUser
   * @return string
   */
  public function FormatLikes($Likes, $Url, $UID, $Self) {
    $CountLikes = count($Likes);
    $Src = '';

   	if($CountLikes)
   		$Src .= '<span class="likes">' .$CountLikes. sprintf($CountLikes>1?T(' Likes'):T(' Like')).'</span> ';
		  
	if(!$Self){
      if (in_array($UID, $Likes))
	  {
		$QuoteURL = Url("discussion/Like/{$Url}/remove",TRUE);
        $QuoteText = T('Unlike');
		$QuoteClass = 'Unlike';
      } 
	  else 
	  {
        $QuoteURL = Url("discussion/Like/{$Url}",TRUE);
        $QuoteText = T('Like');
		$QuoteClass = 'Like';
	  }
	  $Src .= '<span class="LikeThis '.$QuoteClass.'"><a href="'.$QuoteURL.'">'.$QuoteText.'</a></span>';
	}
    return $Src;

  }

  /**
   * This creates the database structure for the plugin.
   * 
   * @return void
   */
  public function Structure() {

    GDN::Structure()
   	->Table('AllLikes')
	->PrimaryKey('ID')
    ->Column('CommentID', 'int(11)', TRUE)
    ->Column('DiscussionID', 'int(11)', TRUE)
    ->Column('UserID', 'int(11)', FALSE)
    ->Set(TRUE);
	  
	 Gdn::Structure()
	 ->Table('User')
	 ->Column('Liked','int(11)',0)
	 ->Column('DisLiked','int(11)',0)
	 ->Column('ILiked','int(11)',0)
	 ->Set();
  }

}
 
