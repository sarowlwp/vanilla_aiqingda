<?php if (!defined('APPLICATION')) exit(); ?>
<!--change all instances of 'my-forum-theme-name' to your theme -->
<!--custom faqs-->
<script type="text/javascript" src="themes/aiqingda/faqs/js/faqs.js"></script>
<link rel="stylesheet" type="text/css" href="themes/aiqingda/faqs/css/faq-style.css" />
<!--//end custom faqs-->

							
							<!--search faqs-->						
								<div id="search-bar">
									<form action="" method="post" autocomplete="off">
										<h2>搜索问题库<span style="font-size:12px;font-weight:normal">请在这里填入搜索关键词</span></h2>
										
											<input type="text" id="search_term"/>
											<span class="searchreset" onclick="$(this).prev(':input').val('');"></span>
											<script>document.getElementById('search_term').focus()</script>
											<span class="loader">Loading...</span>
											<p></p>
											<strong>Q.  找不到你想要的答案吗 ?<br />A.  去<a href="/">爱青大</a>提问吧 </strong>
										
									</form>
								</div> 
							<!-- #search -->
								
									<strong>经常被问到的问题 <span style="float:right;margin-top:0px;">点击 <strong>+</strong> 展开答案 | <span id="expand-all">全部展开</span> | <span id="contract-all">全部收起</span></span></strong>
								
							<!--answers -->
									<div class="portlet">
									<ul class="faq clearfix">
										<? include ("themes/aiqingda/faqs/answers.php"); ?>
									</ul>
									<p>更多问题请直接在论坛发帖提问</p>
									</div>
							<!-- #answers -->
							