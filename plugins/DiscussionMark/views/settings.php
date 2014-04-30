<?php if (!defined('APPLICATION')) exit();
echo $this->Form->Open();
echo $this->Form->Errors();
?>
<h1><?php echo T($this->Data['Title']); ?></h1>
<div class="Info">
This is a basic plugin to mark the disscussion as elite or recommend . 
</div>
<h3>Setting for recommend Tag</h3>
<form>
	<ul>
		<li>If this option Enable, there will add a RecommendTag in discussion Meta area, default is '推荐' , you can custom by set the RecommendTag Lable.</li>
		<li>
      <?php
      echo Anchor(
         C('Plugins.DiscussionMark.EnableRecommendTag') ? 'Disable' : 'Enable',
         'settings/recommendtag/'.Gdn::Session()->TransientKey(),
         'SmallButton'
      );
   ?>
</li>
</ul>
</form>
<h3>Setting for elite Tag</h3>
<form>
	<ul>
		<li>If this option Enable, there will add an EliteTag in discussion Meta area, default is '精华' , you can custom by set the EliteTag Lable.</li>
		<li>
      <?php
      echo Anchor(
         C('Plugins.DiscussionMark.EnableEliteTag') ? 'Disable' : 'Enable',
         'settings/elitetag/'.Gdn::Session()->TransientKey(),
         'SmallButton'
      );
   ?>
</li>
</ul>
</form>
<form>
	<ul>
		<li>Setting Elite TabLink. If this option Enable , there will place a Tab Link named elite-discussion.</li>
		<li>
      <?php
      echo Anchor(
         C('Plugins.DiscussionMark.EnableEliteTab') ? 'Disable' : 'Enable',
         'settings/elitetab/'.Gdn::Session()->TransientKey(),
         'SmallButton'
      );
   ?>
</li>
</ul>
</form>

<h3>Setting Elite level condition. If Elitelevel enable .</h3>
<form>
	<ul>
		<li>Setting Elite level. If Elitelevel enable , there will be three level for elite.</li>
		<li>
      <?php
      echo Anchor(
         C('Plugins.DiscussionMark.EnableEliteLevel') ? 'Disable' : 'Enable',
         'settings/elitelevel/'.Gdn::Session()->TransientKey(),
         'SmallButton'
      );
   ?>
</li>
</ul>
</form>
<hr>
<ul>
   <li>
        You can custom your recommendTag or EliteTag Lable here.
   </li>
   <li>
      <?php
         echo $this->Form->Label('Custom RecommendTag Lable here.', 'Plugins.DiscussionMark.RecommendLable');
         echo $this->Form->TextBox('Plugins.DiscussionMark.RecommendLable');
      ?>
   </li>
   <li>
      <?php
         echo $this->Form->Label('Custom EliteTag Lable here', 'Plugins.DiscussionMark.EliteLable');
         echo $this->Form->TextBox('Plugins.DiscussionMark.EliteLable');
      ?>
   </li>
   <hr>
   <li>
      <?php
         echo $this->Form->Label('Comment Number to Get Elite1', 'Plugins.DiscussionMark.Elite1CommentNum');
         echo $this->Form->TextBox('Plugins.DiscussionMark.Elite1CommentNum');
      ?>
   </li>
   <li>
      <?php
         echo $this->Form->Label('Comment Number to Get Elite2', 'Plugins.DiscussionMark.Elite2CommentNum');
         echo $this->Form->TextBox('Plugins.DiscussionMark.Elite2CommentNum');
      ?>
   </li>
   <li>
      <?php
         echo $this->Form->Label('Comment Number to Get Elite3', 'Plugins.DiscussionMark.Elite3CommentNum');
         echo $this->Form->TextBox('Plugins.DiscussionMark.Elite3CommentNum');
      ?>
   </li>
</ul>
<?php echo $this->Form->Close('Save');



