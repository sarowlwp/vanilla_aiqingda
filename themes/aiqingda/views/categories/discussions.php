<?php if (!defined('APPLICATION')) exit();
$ViewLocation = $this->FetchViewLocation('discussions', 'discussions');
?>
<div class="Categories">

	<ul>
   <?php foreach ($this->CategoryData->Result() as $Category) :
      if ($Category->CategoryID <= 0)
         continue;

      $this->Category = $Category;
      $this->DiscussionData = $this->CategoryDiscussionData[$Category->CategoryID];
      
      if ($this->DiscussionData->NumRows() > 0) : ?>
       <li style="display:inline-block;border-right:1px dotted #cdcdcd;margin:5px;width:343px;height:380px;float:left; 
display:block;">
	   
		   <div class="CategoryBox Category-<?php echo $Category->UrlCode; ?>" style="">
			  <div class="Tabs CategoryTabs">
				 <ul>
				 
					<li class="Active" style="font-size:15px;color:blue;">
						<?php echo Anchor($Category->Name, '/categories/'.$Category->UrlCode); ?>
					</li>
					<li
					 <span class="splitdot">-</span>
					 <?php echo '<span class="DiscussionCount">'.sprintf(Plural(number_format($Category->CountAllDiscussions), '%s  帖子', '%s 帖子'), $Category->CountDiscussions).'</span>' ?>
					</li>
					<li>
					 <span class="splitdot">-</span>
                     <?php echo '<span class="CommentCount">'.sprintf(Plural(number_format($Category->CountAllComments), '%s comment', '%s comments'), $Category->CountComments).'</span>'; ?>
					</li>
				 </ul>
			  </div>
			  
			  <ul class="DataList Discussions">
				 
				 <?php 
					 foreach ($this->DiscussionData->Result() as $Discussion) {
					   WriteDiscussion($Discussion, $this, $Session, $Alt);
					}
					//include($this->FetchViewLocation('discussions', 'discussions')); 
				 ?>
			  </ul>
			  
			  <div class="Foot">
				 <?php if ($this->DiscussionData->NumRows() == $this->DiscussionsPerCategory) : ?>
					<?php echo Anchor(T('More Discussions'), '/categories/'.$Category->UrlCode, ''); ?>
				 <?php endif; ?>
			  </div>
			  
		   </div>
	   </li>
      <?php endif; ?>
      
   <?php endforeach; ?>
   </ul>
</div>


 <?php
function WriteDiscussion($Discussion, &$Sender, &$Session, $Alt2) {
   static $Alt = FALSE;
   $CssClass = 'Item';
   $CssClass .= $Discussion->Bookmarked == '1' ? ' Bookmarked' : '';
   $CssClass .= $Alt ? ' Alt ' : '';
   $Alt = !$Alt;
   $CssClass .= $Discussion->Announce == '1' ? ' Announcement' : '';
   $CssClass .= $Discussion->Dismissed == '1' ? ' Dismissed' : '';
   $CssClass .= $Discussion->InsertUserID == $Session->UserID ? ' Mine' : '';
   $DiscussionUrl = '/discussion/'.$Discussion->DiscussionID.'/'.($Discussion->CountCommentWatch > 0 && C('Vanilla.Comments.AutoOffset') && $Session->UserID > 0 ? '/#Item_'.$Discussion->CountCommentWatch : '');
   $Sender->EventArguments['DiscussionUrl'] = &$DiscussionUrl;
   $Sender->EventArguments['Discussion'] = &$Discussion;
   $Sender->EventArguments['CssClass'] = &$CssClass;
   $First = UserBuilder($Discussion, 'First');
   $Last = UserBuilder($Discussion, 'Last');
   
   $Sender->FireEvent('BeforeDiscussionName');
   
   $DiscussionName = $Discussion->Name;
   if ($DiscussionName == '')
      $DiscussionName = T('Blank Discussion Topic');
      
   $Sender->EventArguments['DiscussionName'] = &$DiscussionName;

   static $FirstDiscussion = TRUE;
   if (!$FirstDiscussion)
      $Sender->FireEvent('BetweenDiscussion');
   else
      $FirstDiscussion = FALSE;
?>
<li class="<?php echo $CssClass; ?>">
   <?php
   if (!property_exists($Sender, 'CanEditDiscussions'))
      $Sender->CanEditDiscussions = GetValue('PermsDiscussionsEdit', CategoryModel::Categories($Discussion->CategoryID)) && C('Vanilla.AdminCheckboxes.Use');;

   //$Sender->FireEvent('BeforeDiscussionContent');

   ?>
  	
   <div class="ItemContent Discussion" style="padding-left:5px; width:330px;">
      <?php echo Anchor($DiscussionName, $DiscussionUrl, ''); ?>
      <?php //$Sender->FireEvent('AfterDiscussionTitle'); ?>
      <div class="Meta">
         <?php $Sender->FireEvent('BeforeDiscussionMeta'); ?>

					
         <?php if ($Discussion->Announce == '1') { ?>
         <span class="Announcement"><?php echo T('Announcement'); ?></span>
         <?php } ?>
         <?php if ($Discussion->Closed == '1') { ?>
         <span class="Closed"><?php echo T('Closed'); ?></span>
         <?php } ?>

         <span class="splitdot">-</span>
		 <?php
               echo '<span class="LastCommentBy">'.sprintf('%1$s', UserAnchor($First)).'</span>';
         ?>
		 <span class="splitdot">-</span>
		 <?php echo T('Views'); ?></span><?php printf(Plural($Discussion->CountViews, '%s', '%s'), $Discussion->CountViews); ?>
		 <span class="splitdot">-</span>
		 <?php echo T('Comment'); ?></span><?php printf(Plural($Discussion->CountComments, '%s', '%s'), $Discussion->CountComments); ?>
		 <span class="splitdot">-</span>
		 <?php echo '<span class="LastCommentDate">'.Gdn_Format::Date($Discussion->LastDate).'</span>';?>
		 
         <!--<span class="CommentCount"><?php //printf(Plural($Discussion->CountComments, '%s comment', '%s comments'), $Discussion->CountComments); ?></span>-->
      </div>
   </div>
</li>
<?php
}