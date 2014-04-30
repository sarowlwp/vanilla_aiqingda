<?php if (!defined('APPLICATION')) exit();
?>
<style type="text/css">
.Configuration {
   margin: 0 20px 20px;
   background: #f5f5f5;
   float: left;
}
.ConfigurationForm {
   padding: 20px;
   float: left;
}
#Content form .ConfigurationForm ul {
   padding: 0;
}
#Content form .ConfigurationForm input.Button {
   margin: 0;
}
.ConfigurationHelp {
   border-left: 1px solid #aaa;
   margin-left: 340px;
   padding: 20px;
}
.ConfigurationHelp strong {
    display: block;
}
.ConfigurationHelp img {
   width: 99%;
}
.ConfigurationHelp a img {
    border: 1px solid #aaa;
}
.ConfigurationHelp a:hover img {
    border: 1px solid #777;
}
input.CopyInput {
   font-family: monospace;
   color: #000;
   width: 240px;
   font-size: 12px;
   padding: 4px 3px;
}
</style>
<h1><?php echo $this->Data('Title'); ?></h1>
<?php
echo $this->Form->Open();
echo $this->Form->Errors();
?>
<div class="Info">
	<a href="http://open.weibo.com/authentication/" target="_blank">QQ登录</a>：
	使用QQ帐号访问你的网站，分享内容，同步信息。
	带入腾讯QQ活跃用户，提升网站的用户数和访问量。
</div>

<h3>是否启用QQ连接自主选择昵称模式</h3>
<form>
	<ul>
		<li>启用后，用户连接时需要自己选择昵称，而不是使用QQ昵称.</li>
		<li>
      <?php
      echo Anchor(
         C('Plugins.Tecent.ChooseName') ? 'Disable' : 'Enable',
         'settings/choosename/'.Gdn::Session()->TransientKey(),
         'SmallButton'
      );
   ?>
</li>
</ul>
</form>
<h3>QQ连接必要参数，请提供APPID，以及APPKEY</h3>
<div class="Configuration">
   <div class="ConfigurationForm">
      <ul>
         <li>
            <?php
               echo $this->Form->Label('App Key', 'ConsumerKey');
               echo $this->Form->TextBox('ConsumerKey');
            ?>
         </li>
         <li>
            <?php
               echo $this->Form->Label('App Secret', 'Secret');
               echo $this->Form->TextBox('Secret');
            ?>
         </li>
		 <li>
            <?php
               echo $this->Form->Label('站点地址，不加http', 'SiteUrl');
               echo $this->Form->TextBox('SiteUrl');
            ?>
         </li>
      </ul>
      <?php echo $this->Form->Button('Save', array('class' => 'Button SliceSubmit')); ?>
   </div>
   <div class="ConfigurationHelp">
      <strong>如何让你的网站支持QQ登录</strong>
      <p>腾讯QQ登录详情: <a href="http://connect.qq.com/intro/login/">http://connect.qq.com/intro/login/</a></p>
   </div>
</div>   
<?php
   echo $this->Form->Close();