<?php if (!defined('APPLICATION')) exit();
echo $this->Form->Open();
echo $this->Form->Errors();
?>
<h1><?php echo T("Show first few words from Discussions"); ?></h1>
      <div class="Info"><?php echo T('Choose how many words to show, default is 15'); ?></div>
      <table class="AltRows">
         <tbody>
            <tr>
               <th><?php echo T('Number of words'); ?></th>
               <td class="Alt"><?php echo $this->Form->TextBox('DiscussionExcerpt2.Number_of_words'); ?></td>
            </tr>
            <tr>
               <th><?php echo T('Show excerpt for announcements?'); ?></th>
               <td class="Alt"><?php echo $this->Form->CheckBox('DiscussionExcerpt2.Show_announcements'); ?></td>
            </tr>
            <tr>
               <th><?php echo T('Show images in excerpt?'); ?></th>
               <td class="Alt"><?php echo $this->Form->CheckBox('DiscussionExcerpt2.Show_images'); ?></td>
            </tr>
         </tbody>
      </table>

<?php echo $this->Form->Close('Save');
