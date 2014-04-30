<?php if (!defined('APPLICATION')) exit(); ?>

<div class="MassDelivery">

<h1><?php echo T('Mass Delivery');?></h1>

<?php echo $this->Form->Open();?>
<?php echo $this->Form->Errors();?>

<ul>
<li>
<?php 
echo $this->Form->Label('RecipientEmailList', 'RecipientEmailList');
echo $this->Form->TextBox('RecipientEmailList'); 
?>
</li>

<li>
<?php 
echo $this->Form->Label('Subject', 'Subject');
echo $this->Form->TextBox('Subject'); 
?>
</li>


<li>
<?php 
echo $this->Form->Label('Body', 'Body');
echo $this->Form->TextBox('Body', array('Multiline' => True, 'class' => 'TextBox Autogrow')); 
?>
</li>

<li>
<strong><?php echo T('Send only to:');?></strong>
<?php
echo $this->Form->CheckBoxList('Roles', $this->RoleData, False, array('TextField' => 'Name', 'ValueField' => 'RoleID'));
?>

</li>

<li>
<strong><?php echo T('Options:');?></strong>
<?php echo $this->Form->CheckBox('SendMeOnly', T('Send me only')); ?>
<?php if($this->CanGiveJobToCron) echo $this->Form->CheckBox('ToCronJob', T('Use command line (cron)')); ?>
</li>

<?php if($this->DrawConfirmSend):?>
	<li>
	<strong><?php printf(Plural($this->CountEmails, 'Your message will be sent to %d recipient', 'Your message will be sent to %d recipients'), $this->CountEmails);?></strong>
	<?php echo $this->Form->CheckBox('ConfirmSend', T('Confirm')); ?>
	</li>
<?php endif;?>

</ul>
<?php echo $this->Form->Button('Send');?>

<?php echo $this->Form->Close();?>

</div>