<?php


/**
 * LajkujModel class.
 * Only defines a few shorthands.
 */
class LikeModel extends Gdn_Model {

  private $Cache;

  public function __construct() {
    parent::__construct('AllLikes');
  }

  public function PreloadLikes(Gdn_DataSet $Comments) {
    $cache = Array();
    while ($CommentID = $Comments->Value('CommentID', FALSE)) {
      $cache[] = $CommentID;
    }
    if (!empty($cache)) {
      $Likes = $this->SQL->Select()->From($this->Name)->WhereIn('CommentID', $cache)->OrderBy('CommentID')->Get()->Result(DATASET_TYPE_OBJECT);
      foreach ($Likes as $Like) {
        if (!$this->Cache[$Like->CommentID])
          $this->Cache[$Like->CommentID] = Array();
        $this->Cache[$Like->CommentID][] = $Like;
      }
    }
  }

  public function GetDiscussionLikes($DiscussionID) {
    $Likes = $this->GetWhere(Array('DiscussionID' => $DiscussionID, 'CommentID'=>null))->Result(DATASET_TYPE_OBJECT);
    foreach ($Likes as &$Like) {
      $Like = $Like->UserID;
    }
    return $Likes;
  }
  
    public function GetTotalDiscussionLikes($DiscussionID) {
    $Likes = $this->GetWhere(Array('DiscussionID' => $DiscussionID))->Result(DATASET_TYPE_OBJECT);
    foreach ($Likes as &$Like) {
      $Like = $Like->UserID;
    }
    return $Likes;
  }


  public function GetCommentLikes($CommentID) {
    if (!isSet($this->Cache[$CommentID])) {
      $this->Cache[$CommentID] = $this->GetWhere(Array('CommentID' => $CommentID))->Result(DATASET_TYPE_OBJECT);

      foreach ($this->Cache[$CommentID] as &$Like) {
        $Like = $Like->UserID;
      }
    }
    return $this->Cache[$CommentID];
  }

}