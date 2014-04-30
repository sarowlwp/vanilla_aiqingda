{*
 * This theme was ported from Vanilla Forums Inc's hosted theme "Bootstrap" it has been modified to merge with Bootstrap 3 ( from 2.3 ) and has been designed for use on the OS model.
 *
 * @copyright Vanilla Forums
 * @author Chris Ireland (Adapation)
*}
<!DOCTYPE html>
<html>
<head>
  <!--<link rel="stylesheet" href="http://www.google.com/cse/style/look/default.css" type="text/css" />-->
  <!--<script src="http://www.google.com/jsapi" type="text/javascript"></script>-->
 
  <!--[if lte IE 6]>
  <meta http-equiv="Refresh" content="0; url=http://www.aiqingda.com/iewar.html">
  <![endif]-->
  <!--[if lt IE 9]>
  <meta http-equiv="Refresh" content="0; url=http://www.aiqingda.com/iewar.html">
  <![endif]--> 
  <meta property="og:site_name" content="爱青大BBS - 青海大学人自己的BBS 青大有真情，联系你我她"/>
  <meta property="og:title" content="在青大，爱青大，咱青海大学自己的BBS社区，青大，青海大学论坛，青海大学BBS，青海大学人，青海大学学生"/>
  <meta property="og:description" content="青海大学，青大信息，青大学生，青大考研，青海大学，青海大学信息，青海大学论坛，青海大学学生论坛，青海高等学府，青海省，青海大学BBS，青海大学学生BBS"/>
  <meta name="description" content="爱青大BBS，青海大学人自己的BBS 青大有真情，联系你我她." />
  <meta name="keywords" content="爱青大,青大BBS,青海大学论坛,青海大学BBS,青海大学学生,青海大学,青海大学考研,青海大学专升本,青大考研" />
  <meta name="baidu-site-verification" content="MTpLBd3Bub9SXMmX" />
  <meta name="baidu-tc-verification" content="3d750fe1935a547532dbedc2407bb54c" />
  <meta name="google-site-verification" content="i7lPuP7Jg09HGS0nV9FC5pyiGU68C8HpglfrX3Gooxc" />
  <meta property="qc:admins" content="35756745276111167416375" />
  <meta property="wb:webmaster" content="0badfb38918dd908" />

  {asset name="Head"}
</head>
<body id="{$BodyID}" class="{$BodyClass}">
<div id="Frame">
    <div class="NavBar">
        <div class="Row">
            <strong class="SiteTitle"><a href="{link path="/"}">{logo}</a></strong>

            <div class="MeWrap">
               {module name="MeModule" CssClass="Inline FlyoutRight"}
            </div>
            <ul class="SiteMenu">
                {discussions_link}
                {activity_link}
                {custom_menu}
            </ul>
        </div>
        <a id="Menu" href="#sidr" data-reveal-id="sidr"><span class="icon"></span><span class="icon"></span><span
                    class="icon"></span>
            <noscript> Mobile Menu Disabled with Javascript disabled</noscript>
        </a>

        <div id="sidr" class="sidr">
            <strong class="SiteTitle"><a href="{link path="/"}">{logo}</a></strong>
            {dashboard_link wrap="li class='dashboard'"}
            {discussions_link wrap="li class='discussions'"}
            {activity_link wrap="li class='activity'"}
            {inbox_link wrap="li class='inbox'"}
            {custom_menu}
            {profile_link wrap="li class='profile'"}
            {signinout_link wrap="li class='signout'"}
            </ul>
        </div>
    </div>
    <div id="Body">
        <div class="BreadcrumbsWrapper Row">
            <div class="SiteSearch">{searchbox}</div>
            {breadcrumbs}
        </div>
        <div class="Row">
            <div class="Column PanelColumn" id="Panel">
               {asset name="Panel"}
            </div>
            <div class="Column ContentColumn" id="Content">
		{asset name="Content"}
	    </div>
        </div>
    </div>
    <div id="Foot">
        <div class="FootHeader" style="padding-bottom: 40px;
                        margin: 0px;
                        background: url('/themes/aiqingda/design/images/grassbottom.png') repeat-x;
                        width: 100%;">
                </div>
                <div class="FootBody" style="background: url('/themes/aiqingda/design/images/foot_bottom_bg.jpg') repeat-x;
                        width: 100%;
                        height: 130px;
                        margin: 0px;">
                        <div class="clearfix">
                                <dl class="list">
                                <dt>常见问答</dt>
                                <dd><a href="http://www.aiqingda.com/discussion/180#Item_1">推广爱青大</a></dd>
                                <dd><a href="http://www.aiqingda.com/discussion/35#Item_1">爱青大新手引导贴</a></dd>
                                <dd><a href="http://www.aiqingda.com/discussion/158#Item_1">爱青大发帖规则</a></dd>
                                <dd><a href="http://www.aiqingda.com/discussion/107#Item_1">爱青大积分规则</a></dd>
                                <dd><a href="http://www.aiqingda.com/discussion/158#Item_1">爱青大等级系统规则</a></dd>
                                <dd><a href="http://www.aiqingda.com/discussion/40#Item_1">如何发表视频</a></dd>
                                <dd><a href="http://www.aiqingda.com/faqs">其他问题</a></dd>
                                </dl>
                                <dl class="list">
                                <dt>友情链接</dt>
                                <dd><a href="http://www.qhnubbs.com/">郁金香校园BBS</a></dd>
                                <!--<dd><a href="http://www.manyima.com/">满意吗 - 生活质量评论</a></dd>-->
                                <dd><a href="http://vanilla.aiqingda.com">Vanilla中文站 - Let`s Vanilla</a></dd>
                                <dd><a href="http://www.vanillaforums.cn">vanilla中文社区</a></dd>
                                <dd><a href="http://www.myznl.com/">向阳花札记</a></dd>
                                <dd><a href="http://www.kaoyanjie.com/">考研论坛</a></dd><dd>
                                <a href=http://www.hsdczx.com/></a>
                                <a href=http://www.guilinok.com/></a>
                                <a href=http://www.qhwww.com target=_blank>青海网址导航</a>
                                </dd>
                                </dl>

                                <dl class="list">
                                <dt>官方帐户 - 我们在这里</dt>
                                <dd><a href="http://aiqingda.renren.com">爱青大BBS - 人人网</a></dd>
                                <dd><a href="http://www.weibo.com/aiqingda">爱青大BBS - 新浪微博</a></dd>
                                <dd><a href="http://t.qq.com/aiqingdabbs">爱青大BBS - 腾讯微博</a></dd>
                                <dd><a href="http://zhan.renren.com/aiqingda">爱青大BBS - 人人小站</a></dd>
                                <dd><a href="http://page.renren.com/601412717">爱青大BBS - 人人公共主页</a></dd>

                                </dl>
				<dl class="list list_right">
                                <dt></dt>
                                        <dd>
                                                请遵守中华人民共和国相关法律 - 本站会员观点不代表本站立场<br> <br>
                                        </dd>
                                        <dd>
                                                Powered by Vanilla - Design by 爱青大社区  © 2012-2013  <br> <br>
                                        </dd>
                                        <dd>
                                                <a href="/index.php?p=/plugin/page/about">关于爱青大BBS社区</a> - 联系我们：aiqingdabbs#sina.com (#换@)<br> <br>
                                        </dd>
                                        <dd>
                                                {asset name="Foot"}
                                                统计工具：<script type="text/javascript">
                                                var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
                                                document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F9ff9ad53101fc9dbdb96824a251db3a7' type='text/javascript'%3E%3C/script%3E"));
                                                </script>

                                        </dd>
                                </dl>
                        </div>
                </div>

	
	<div class="Row">
            <a href="{vanillaurl}" class="PoweredByVanilla" title="Community Software by Vanilla Forums">Powered by
                Vanilla</a>
            {asset name="Foot"}
        </div>
    </div>
</div>
{event name="AfterBody"}
{literal}
    <script>
        // Theme Defintions
        jQuery("#Menu").sidr();
        $('.SignInPopup').click(function () {
            jQuery.sidr('close');
        });

        if ($(window).width() < 612) {
            $(".Options").addClass("FlyoutLeft");
            $("body.Discussion .Options").removeClass("FlyoutLeft");
        }

        $(window).resize(function () {
            if ($(window).width() > 612) {
                jQuery.sidr('close');
                $(".Options").removeClass("FlyoutLeft");
            }
            else if ($(window).width() < 612) {
                $(".Options").addClass("FlyoutLeft");
                $("body.Discussion .Options").removeClass("FlyoutLeft");
            }
        });
    </script>
{/literal}
</body>
</html>
