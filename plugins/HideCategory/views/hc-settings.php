<?php if (!defined('APPLICATION')) exit();
echo $this->Form->Open();
echo $this->Form->Errors();
?>


<h1><?php echo Gdn::Translate('Hide Category'); ?></h1>

<div class="Info"><?php echo Gdn::Translate('Add Names of Categories to Hide.'); ?></div>

<table class="AltRows">
    <thead>
        <tr>
            <th><?php echo Gdn::Translate('Option'); ?></th>
            <th class="Alt"><?php echo Gdn::Translate('Description'); ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <?php
                echo $this->Form->TextBox(T('Plugins.HideCategory.NoCat'));
                ?>
            </td>
            <td class="Alt">
<?php echo Gdn::Translate('Add the NAME of the first Category to Hide'); ?>
            </td>
        </tr>

        <tr>
            <td>
                <?php
                echo $this->Form->TextBox(T('Plugins.HideCategory.NoCat2'));
                ?>
            </td>
            <td class="Alt">
<?php echo Gdn::Translate('Add the NAME of the second Category to Hide '); ?>
            </td>
        </tr>
        
        <tr>
            <td>
                <?php
                echo $this->Form->TextBox(T('Plugins.HideCategory.NoCat3'));
                ?>
            </td>
            <td class="Alt">
<?php echo Gdn::Translate('Add the NAME of the third Category to Hide '); ?>    
            </td>
        </tr>

        <tr>
            <td>
                <?php
                echo $this->Form->TextBox(T('Plugins.HideCategory.NoCat4'));
                ?>
            </td>
            <td class="Alt">
<?php echo Gdn::Translate('Add the NAME of the fourth Category to Hide '); ?>         
            </td>
        </tr>  

        <tr>
            <td>
                <?php
                echo $this->Form->TextBox(T('Plugins.HideCategory.NoCat5'));
                ?>
            </td>
            <td class="Alt">
<?php echo Gdn::Translate('Add the NAME of the fifth Category to Hide '); ?>         

            </td>
        </tr>

        <tr>
            <td>
                <?php
                echo $this->Form->TextBox(T('Plugins.HideCategory.NoCat6'));
                ?>
            </td>
            <td class="Alt">
<?php echo Gdn::Translate('Add the NAME of the sixth Category to Hide '); ?>            
            </td>
        </tr>  

</table>

<?php
echo $this->Form->Close('Save');


