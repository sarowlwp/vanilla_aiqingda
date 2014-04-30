<?php if (!defined('APPLICATION')) exit(); ?>
<div class="Profile">
   <div class="KamaBank Tabs ProfileTabs">
    
	<ul>
	    <li style="float:left"><strong><?php echo sprintf(T('%s\'s Karma Balance'),$this->ThisUser->Name); ?></strong></li>
		<li class="Back"><?php echo Anchor(T('&laquo; Back to Profile'),'profile/'.$this->ThisUser->UserID.'/'.rawurlencode($this->ThisUser->Name),array('class'=>'TabLink'));?></li>
	</ul>
   </div>
<?php
if ($this->Data['Balance']) {
?>
<ul class="DataList KarmaBank">
<li class="Item KarmaTitles">
<div class="ItemContent">
<div class="Item"><?php echo T('Transaction') ?></div>
<div class="Description"><?php echo T('Date') ?></div>
<div class="Amount"> <span class="Karma"><?php echo T('Karma') ?></span></div>
<div class="Clear"></div>
</div>
</li>
<?php foreach ($this->Data['Transactions'] As $Transaction) {
	$TransParts = split(' ',$Transaction->Type);
	$Trans=array();
	foreach($TransParts As $TransPart)
		$Trans[]=T(urldecode($TransPart));
	$TransOrder=T($Trans[0].'.Order',trim(join(' ',array_fill(0,count($Trans),'%s'))));
	$Trans = vsprintf($TransOrder,$Trans);
?>
<li class="Item KarmaTrans">
<div class="ItemContent">
<div class="Item"><?php echo $Trans ?></div>
<div class="Description"><?php echo Gdn_Format::Date(strtotime($Transaction->Date),T('Date.DefaultFormat').' '.T('Date.DefaultTimeFormat')); ?></div>
<div class="Amount"><?php echo sprintf("%01.0f",$Transaction->Amount) ?><span class="Karma"></span></div>
<div class="Clear"></div>
</div>
</li>
<?php } ?>
<li class="Item KarmaBal">
<div class="ItemContent">
<div class="Item"><?php echo T('Balance') ?></div>
<div class="Description"></div>
<div class="Amount"><?php echo sprintf("%01.0f",$this->Data['Balance']) ?><span class="Karma"><?php echo T('Karma') ?></span></div>
<div class="Clear"></div>
</div>
</li>
</ul>
<?php
echo $this->Pager->Render();
} else {
   echo '<div class="Empty">'.T('You do not have any Karma yet.').'</div>';
}
if(Gdn::Session()->CheckPermission('Plugins.KarmaBank.RewardTax') || Gdn::Session()->User->Admin){
      echo $this->Form->Open();
      echo $this->Form->Errors();
?>
<div class="Configuration">
   <div class="ConfigurationForm">
      <ul>
	 <li>
		<?php
		echo $this->Form->Label('Reason ','RewardTaxReason');
		echo $this->Form->TextBox('RewardTaxReason',array('class'=>'SmallInput','maxlength'=>C('Plugins.KarmaBank.ReasonMaxLength',25)));
		echo $this->Form->Label('Amount','RewardTax');
		echo $this->Form->TextBox('RewardTax',array('class'=>'SmallInput'));
		echo $this->Form->Button(T('Reward / Tax'));
		?>
	 </li>
      </ul>
   </div>
</div>
 <?php
      echo $this->Form->Close();
}
?>
</div>
