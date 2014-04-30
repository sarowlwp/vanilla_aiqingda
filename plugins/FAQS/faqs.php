<?php if (!defined('APPLICATION')) exit(); ?>
<!--change all instances of 'my-forum-theme-name' to your theme -->
<!--custom faqs-->
<script type="text/javascript" src="themes/my-forum-theme-name/faqs/js/faqs.js"></script>
<link rel="stylesheet" type="text/css" href="themes/my-forum-theme-name/faqs/css/faq-style.css" />
<!--//end custom faqs-->

							<!--search faqs-->						
								<div id="search-bar">
									<form action="" method="post" autocomplete="off">
										<h2>Search My Forum FAQ's <span style="font-size:12px;font-weight:normal">Search by keywords or type in a question</span></h2>
										
											<input type="text" id="search_term"/>
											<span class="searchreset" onclick="$(this).prev(':input').val('');"></span>
											<script>document.getElementById('search_term').focus()</script>
											<span class="loader">Loading...</span>
											<p></p>
											<strong>Q.  Can't find the answer ?<br />A.  Ask in the <a href="/my-forum-theme-name">forums</a></strong>
										
									</form>
								</div> 
							<!-- #search -->
								
									<strong>Frequently Asked Questions <span style="float:right;margin-top:0px;">click <strong>+</strong> to expand answer | <span id="expand-all">Expand All</span> | <span id="contract-all">Contract All</span></span></strong>
								
							<!--answers -->
									<div class="portlet">
									<ul class="faq clearfix">
										<? include ("themes/my-forum-theme-name/faqs/answers.php"); ?>
									</ul>
									<p>more Faqs to follow</p>
									</div>
							<!-- #answers -->