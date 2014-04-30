<?php if (!defined('APPLICATION')) exit(); ?>
<h1><?php echo T($this->Data['Title']); ?></h1>
<div class="Info">
启用中文增强补丁以后，你的vanilla站点就能够支持以下中文特性：<br/><br/>
1. 中文用户名注册<br/>
2. @中文用户名<br/>
3. #中文标签#<br/>
4. 简洁讨论链接(可选)<br/>
5. 中文搜索(可选，需要设置搜索模式为'like'，性能不佳，数据量大的网站不推荐使用)<br/>
</div>
<h3>简洁讨论链接设置</h3>
<form>
	<ul>
		<li>把讨论链接改为形如/discussion/47的格式，去掉后面的冗长标题编码</li>
		<li>
      <?php
      echo Anchor(
         C('Plugins.ChinesePreference.ShortLink') ? '禁用简洁链接' : '启用简洁链接',
         'settings/cnpshortlink/'.Gdn::Session()->TransientKey(),
         'SmallButton'
      );
   ?>
</li>
</ul>
<form>
<h3>中文搜索</h3>
<form>
	<ul>
		<li>设置搜索模式为'like'，性能不佳，数据量大的网站不推荐使用</li>
		<li>
      <?php
      echo Anchor(
         C('Garden.Search.Mode')=='like' ? '取消like模式' : '设置like模式',
         'settings/cnptogglelike/'.Gdn::Session()->TransientKey(),
         'SmallButton'
      );
   		?>
</li>
</ul>
<form>
