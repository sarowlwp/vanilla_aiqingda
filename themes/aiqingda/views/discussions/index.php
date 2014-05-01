<?php if (!defined('APPLICATION')) exit();
$Session = Gdn::Session();
include($this->FetchViewLocation('helper_functions', 'discussions', 'vanilla'));
WriteFilterTabs($this);
$PagerOptions = array('RecordCount' => $this->Data('CountDiscussions'), 'CurrentRecords' => $this->Data('Discussions')->NumRows());
if ($this->DiscussionData->NumRows() > 0 || (isset($this->AnnounceData) && is_object($this->AnnounceData) && $this->AnnounceData->NumRows() > 0)) {

   if ($this->Data('_PagerUrl')) {
      $PagerOptions['Url'] = $this->Data('_PagerUrl');
   }
   echo PagerModule::Write($PagerOptions);

?>
<ul class="DataList Discussions">
   <?php include($this->FetchViewLocation('discussions')); ?>
</ul>
<?php  
   if ($this->Data('_PagerUrl')) {
      $PagerOptions['Url'] = $this->Data('_PagerUrl');
   }
   echo PagerModule::Write($PagerOptions);
} else {
   ?>
   <div class="Empty"><?php echo T('No discussions were found.'); ?></div>
   <?php
}