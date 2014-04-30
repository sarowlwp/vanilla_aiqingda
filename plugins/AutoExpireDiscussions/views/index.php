<?php if (!defined('APPLICATION')) exit();
$Session = Gdn::Session();
$DiscussionName = Gdn_Format::Text($this->Discussion->Name);
if ($DiscussionName == '')
   $DiscussionName = T('Blank Discussion Topic');

$this->EventArguments['DiscussionName'] = &$DiscussionName;
$this->FireEvent('BeforeDiscussionTitle');

if (!function_exists('WriteComment'))
   include($this->FetchViewLocation('helper_functions', 'discussion','vanilla'));

$PageClass = '';
if($this->Pager->FirstPage()) 
	$PageClass = 'FirstPage'; 
	
?>
<div class="Tabs HeadingTabs DiscussionTabs <?php echo $PageClass; ?>">
   <?php
   if ($Session->IsValid()) {
      // Bookmark link
      echo Anchor(
         '<span>*</span>',
         '/vanilla/discussion/bookmark/'.$this->Discussion->DiscussionID.'/'.$Session->TransientKey().'?Target='.urlencode($this->SelfUrl),
         'Bookmark' . ($this->Discussion->Bookmarked == '1' ? ' Bookmarked' : ''),
         array('title' => T($this->Discussion->Bookmarked == '1' ? 'Unbookmark' : 'Bookmark'))
      );
   }
   ?>

   <ul>
      <li><?php
         if (C('Vanilla.Categories.Use') == TRUE) {
            echo Anchor($this->Discussion->Category, 'categories/'.$this->Discussion->CategoryUrlCode, 'TabLink');
         } else {
            echo Anchor(T('All Discussions'), 'discussions', 'TabLink');
         }
      ?></li>
   </ul>
   <div class="SubTab"><?php echo $DiscussionName; ?></div>
</div>
<?php $this->FireEvent('BeforeDiscussion'); ?>
<ul class="DataList MessageList Discussion <?php echo $PageClass; ?>">
   <?php echo $this->FetchView('comments','discussion','vanilla'); ?>
</ul>
<?php
$this->FireEvent('AfterDiscussion');
if($this->Pager->LastPage()) {
   $LastCommentID = $this->AddDefinition('LastCommentID');
   if(!$LastCommentID || $this->Data['Discussion']->LastCommentID > $LastCommentID)
      $this->AddDefinition('LastCommentID', (int)$this->Data['Discussion']->LastCommentID);
   $this->AddDefinition('Vanilla_Comments_AutoRefresh', Gdn::Config('Vanilla.Comments.AutoRefresh', 0));
}

echo $this->Pager->ToString('more');
?>
<div class="Foot Closed">
  <div class="Note Closed"><?php echo T('This discussion has expired.'); ?></div>
  <?php echo Anchor(T('All Discussions'), 'discussions', 'TabLink'); ?>
</div>
