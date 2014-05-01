<?php if (!defined('APPLICATION')) exit(); ?>
<h1><?php echo T("Apply for Membership") ?></h1>
   <table>
   <tr>
   <td>
   <?php
   $TermsOfServiceUrl = Gdn::Config('Garden.TermsOfService', '#');
   $TermsOfServiceText = sprintf(T('I agree to the <a id="TermsOfService" class="Popup" target="terms" href="%s">terms of service</a>'), Url($TermsOfServiceUrl));
   // Make sure to force this form to post to the correct place in case the view is
   // rendered within another view (ie. /dashboard/entry/index/):
   echo $this->Form->Open(array('Action' => Url('/entry/register'), 'id' => 'Form_User_Register'));
   echo $this->Form->Errors();
   ?>
   <ul>
      <li>
         手工注册怕麻烦，马上使用<a href="http://www.aiqingda.com/entry/tecentauthorize">【QQ登录】</a>~
      </li>
      <li>
         <?php
            echo $this->Form->Label('Email', 'Email');
            echo $this->Form->TextBox('Email');
            echo '<span id="EmailUnavailable" class="Incorrect" style="display: none;">'.T('Email Unavailable').'</span>';
         ?>
      </li>
      <li>
         <?php
            echo $this->Form->Label('Username', 'Name');
            echo $this->Form->TextBox('Name');
            echo '<span id="NameUnavailable" class="Incorrect" style="display: none;">'.T('Name Unavailable').'</span>';
         ?>
      </li>
      <li>
         <?php
            echo $this->Form->Label('Password', 'Password');
            echo $this->Form->Input('Password', 'password');
         ?>
      </li>
      <li>
         <?php
            echo $this->Form->Label('Confirm Password', 'PasswordMatch');
            echo $this->Form->Input('PasswordMatch', 'password');
            echo '<span id="PasswordsDontMatch" class="Incorrect" style="display: none;">'.T("Passwords don't match").'</span>';
         ?>
      </li>
      <li class="Gender">
         <?php
            echo $this->Form->Label('Gender', 'Gender');
            echo $this->Form->RadioList('Gender', $this->GenderOptions, array('default' => 'm'))
         ?>
      </li>
      <li>
         <?php
            echo $this->Form->CheckBox('TermsOfService', $TermsOfServiceText, array('value' => '1'));
            echo $this->Form->CheckBox('RememberMe', T('Remember me on this computer'), array('value' => '1'));
         ?>
      </li>
      <li class="Buttons">
         <?php echo $this->Form->Button('Sign Up'); ?>
      </li>
   </ul>
   </td>
   <td width="330px" style=" padding-left: 30px; ">
   <h3>爱青大是什么？</h3>
   爱青大BBS致力于建立一个属于青海大学人自己的网上家园，为青海大学 在校或毕业的学生提供一个网上交流的平台，共同促进青海大学的校园文化交流。
   <br>
   <br>
   <h3>爱青大有什么？</h3>
   最精辟的校园攻略，最及时的问题解答 ~ <br>
   活跃的社区气氛，及时有用的内容更新 ~ <br>
   最最重要的是，我们有： <br>
   勤劳的版主，忠诚的用户，可爱的学妹，渊博的师兄；<br>
   青大人，一起打造青海大学人的网上家园 ~<br>
   爱青大欢迎你，爱青大需要你。
   <br>
   <br>
   <h3>了解更多？</h3>
   请访问：http://www.aiqingda.com/faqs
   </td>
   </tr>
   </table>
   <?php echo $this->Form->Close(); ?>
