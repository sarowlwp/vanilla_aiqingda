<?php if (!defined('APPLICATION')) exit();

// Cache
$Configuration['Cache']['Enabled'] = TRUE;
$Configuration['Cache']['Method'] = 'dirtycache';
$Configuration['Cache']['Filecache']['Store'] = '/srv/www/v2.aiqingda.com/public_html/cache/Filecache';

// Conversations
$Configuration['Conversations']['Version'] = '2.1';

// Database
$Configuration['Database']['Name'] = 'aiqingda_vanilla';
$Configuration['Database']['Host'] = 'localhost';
$Configuration['Database']['User'] = 'aiqingdavanilla';
$Configuration['Database']['Password'] = 'qq1234';
$Configuration['Database']['Engine'] = 'MySQL';
$Configuration['Database']['ConnectionOptions']['12'] = FALSE;
$Configuration['Database']['ConnectionOptions']['1000'] = TRUE;
$Configuration['Database']['ConnectionOptions']['1002'] = 'set names \'utf8\'';
$Configuration['Database']['CharacterEncoding'] = 'utf8';
$Configuration['Database']['DatabasePrefix'] = 'GDN_';
$Configuration['Database']['ExtendedProperties']['Collate'] = 'utf8_unicode_ci';

// EnabledApplications
$Configuration['EnabledApplications']['Dashboard'] = 'dashboard';
$Configuration['EnabledApplications']['Conversations'] = 'conversations';
$Configuration['EnabledApplications']['Vanilla'] = 'vanilla';

// EnabledPlugins
$Configuration['EnabledPlugins']['HtmLawed'] = 'HtmLawed';
$Configuration['EnabledPlugins']['Facebook'] = TRUE;
$Configuration['EnabledPlugins']['TecentConnect'] = TRUE;
$Configuration['EnabledPlugins']['ChinesePreference'] = TRUE;
$Configuration['EnabledPlugins']['Pockets'] = TRUE;
$Configuration['EnabledPlugins']['cleditor'] = TRUE;
$Configuration['EnabledPlugins']['Quotes'] = TRUE;

// Garden
$Configuration['Garden']['ContentType'] = 'text/html';
$Configuration['Garden']['Charset'] = 'utf-8';
$Configuration['Garden']['FolderBlacklist'] = array('.', '..', '_svn', '.git');
$Configuration['Garden']['Locale'] = 'en-CA';
$Configuration['Garden']['LocaleCodeset'] = 'UTF8';
$Configuration['Garden']['Title'] = '爱青大BBS';
$Configuration['Garden']['Domain'] = '';
$Configuration['Garden']['WebRoot'] = FALSE;
$Configuration['Garden']['StripWebRoot'] = FALSE;
$Configuration['Garden']['Debug'] = TRUE;
$Configuration['Garden']['RewriteUrls'] = TRUE;
$Configuration['Garden']['Session']['Length'] = '15 minutes';
$Configuration['Garden']['Cookie']['Salt'] = '67CA6KPEVA';
$Configuration['Garden']['Cookie']['Name'] = 'Vanilla';
$Configuration['Garden']['Cookie']['Path'] = '/';
$Configuration['Garden']['Cookie']['Domain'] = '';
$Configuration['Garden']['Cookie']['HashMethod'] = 'md5';
$Configuration['Garden']['Authenticator']['DefaultScheme'] = 'password';
$Configuration['Garden']['Authenticator']['RegisterUrl'] = '/entry/register?Target=%2$s';
$Configuration['Garden']['Authenticator']['SignInUrl'] = '/entry/signin?Target=%2$s';
$Configuration['Garden']['Authenticator']['SignOutUrl'] = '/entry/signout/{Session_TransientKey}?Target=%2$s';
$Configuration['Garden']['Authenticator']['EnabledSchemes'] = array('password');
$Configuration['Garden']['Authenticator']['SyncScreen'] = 'smart';
$Configuration['Garden']['Authenticators']['password']['Name'] = 'Password';
$Configuration['Garden']['Errors']['LogEnabled'] = FALSE;
$Configuration['Garden']['Errors']['LogFile'] = '';
$Configuration['Garden']['SignIn']['Popup'] = TRUE;
$Configuration['Garden']['UserAccount']['AllowEdit'] = TRUE;
$Configuration['Garden']['Registration']['Method'] = 'Captcha';
$Configuration['Garden']['Registration']['DefaultRoles'] = array('8');
$Configuration['Garden']['Registration']['ApplicantRoleID'] = 4;
$Configuration['Garden']['Registration']['InviteExpiration'] = '-1 week';
$Configuration['Garden']['Registration']['InviteRoles']['3'] = '0';
$Configuration['Garden']['Registration']['InviteRoles']['8'] = '0';
$Configuration['Garden']['Registration']['InviteRoles']['16'] = '0';
$Configuration['Garden']['Registration']['InviteRoles']['32'] = '0';
$Configuration['Garden']['Registration']['InviteRoles']['33'] = '0';
$Configuration['Garden']['Registration']['ConfirmEmail'] = '1';
$Configuration['Garden']['Registration']['ConfirmEmailRole'] = '3';
$Configuration['Garden']['Registration']['MinPasswordLength'] = 6;
$Configuration['Garden']['Registration']['CaptchaPrivateKey'] = '6LeyNtASAAAAAOlyM7VSXrtMcV18MmdeIZSl61v3';
$Configuration['Garden']['Registration']['CaptchaPublicKey'] = '6LeyNtASAAAAAOR1dsvSN_t085s0ZD-SVJAM6JtR';
$Configuration['Garden']['TermsOfService'] = '/home/termsofservice';
$Configuration['Garden']['Email']['UseSmtp'] = FALSE;
$Configuration['Garden']['Email']['SmtpHost'] = '';
$Configuration['Garden']['Email']['SmtpUser'] = '';
$Configuration['Garden']['Email']['SmtpPassword'] = '';
$Configuration['Garden']['Email']['SmtpPort'] = '25';
$Configuration['Garden']['Email']['SmtpSecurity'] = '';
$Configuration['Garden']['Email']['MimeType'] = 'text/plain';
$Configuration['Garden']['Email']['SupportName'] = '爱青大BBS';
$Configuration['Garden']['Email']['SupportAddress'] = 'noreply@aiqingda.com';
$Configuration['Garden']['UpdateCheckUrl'] = 'http://vanillaforums.org/addons/update';
$Configuration['Garden']['AddonUrl'] = 'http://vanillaforums.org/addons';
$Configuration['Garden']['CanProcessImages'] = TRUE;
$Configuration['Garden']['Installed'] = TRUE;
$Configuration['Garden']['Forms']['HoneypotName'] = 'hpt';
$Configuration['Garden']['Upload']['MaxFileSize'] = '50M';
$Configuration['Garden']['Upload']['AllowedFileExtensions'] = array('txt', 'jpg', 'jpeg', 'gif', 'png', 'bmp', 'tiff', 'ico', 'zip', 'gz', 'tar.gz', 'tgz', 'psd', 'ai', 'fla', 'swf', 'pdf', 'doc', 'xls', 'ppt', 'docx', 'xlsx', 'log', 'rar', '7z');
$Configuration['Garden']['Picture']['MaxHeight'] = 1000;
$Configuration['Garden']['Picture']['MaxWidth'] = 600;
$Configuration['Garden']['Profile']['MaxHeight'] = 1000;
$Configuration['Garden']['Profile']['MaxWidth'] = 250;
$Configuration['Garden']['Profile']['Public'] = TRUE;
$Configuration['Garden']['Profile']['ShowAbout'] = TRUE;
$Configuration['Garden']['Profile']['EditPhotos'] = TRUE;
$Configuration['Garden']['Profile']['EditUsernames'] = FALSE;
$Configuration['Garden']['Thumbnail']['Size'] = 40;
$Configuration['Garden']['Menu']['Sort'] = array('Dashboard', 'Discussions', 'Questions', 'Activity', 'Applicants', 'Conversations', 'User');
$Configuration['Garden']['InputFormatter'] = 'Html';
$Configuration['Garden']['Html']['AllowedElements'] = 'a, abbr, acronym, address, area, audio, b, bdi, bdo, big, blockquote, br, caption, center, cite, code, col, colgroup, dd, del, details, dfn, div, dl, dt, em, figure, figcaption, font, h1, h2, h3, h4, h5, h6, hgroup, hr, i, img, ins, kbd, li, map, mark, menu, meter, ol, p, pre, q, s, samp, small, span, strike, strong, sub, sup, summary, table, tbody, td, tfoot, th, thead, time, tr, tt, u, ul, var, video, wbr';
$Configuration['Garden']['Html']['SafeStyles'] = FALSE;
$Configuration['Garden']['Search']['Mode'] = 'like';
$Configuration['Garden']['Theme'] = 'VBS3';
$Configuration['Garden']['MobileTheme'] = 'mobile';
$Configuration['Garden']['Roles']['Manage'] = TRUE;
$Configuration['Garden']['VanillaUrl'] = 'http://vanillaforums.org';
$Configuration['Garden']['AllowSSL'] = TRUE;
$Configuration['Garden']['PrivateCommunity'] = FALSE;
$Configuration['Garden']['EditContentTimeout'] = 3600;
$Configuration['Garden']['Modules']['ShowGuestModule'] = TRUE;
$Configuration['Garden']['Modules']['ShowSignedInModule'] = FALSE;
$Configuration['Garden']['Modules']['ShowRecentUserModule'] = FALSE;
$Configuration['Garden']['Embed']['CommentsPerPage'] = 50;
$Configuration['Garden']['Embed']['SortComments'] = 'desc';
$Configuration['Garden']['Embed']['PageToForum'] = TRUE;
$Configuration['Garden']['Format']['Mentions'] = TRUE;
$Configuration['Garden']['Format']['Hashtags'] = FALSE;
$Configuration['Garden']['Format']['YouTube'] = TRUE;
$Configuration['Garden']['Format']['Vimeo'] = TRUE;
$Configuration['Garden']['Format']['EmbedSize'] = 'normal';
$Configuration['Garden']['Version'] = '2.1';
$Configuration['Garden']['Cdns']['Disable'] = FALSE;
$Configuration['Garden']['InstallationID'] = '4670-4ADBF924-EB884D0B';
$Configuration['Garden']['InstallationSecret'] = '2db6cc987aff9d52d4e9a4ad84ef49829d16a068';
$Configuration['Garden']['HomepageTitle'] = '爱青大BBS';
$Configuration['Garden']['Description'] = '各位同学大家好，欢迎加入爱青大，使用中有任何问题，欢迎发帖吐槽！';
$Configuration['Garden']['SystemUserID'] = '6998';
$Configuration['Garden']['User']['ValidationRegex'] = '\\d\\w_\\x{0800}-\\x{9fa5}';
$Configuration['Garden']['User']['ValidationLength'] = '{2,20}';

// Modules
$Configuration['Modules']['Dashboard']['Panel'] = array('MeModule', 'UserBoxModule', 'ActivityFilterModule', 'UserPhotoModule', 'ProfileFilterModule', 'SideMenuModule', 'UserInfoModule', 'GuestModule', 'Ads');
$Configuration['Modules']['Dashboard']['Content'] = array('MessageModule', 'MeModule', 'UserBoxModule', 'ProfileOptionsModule', 'Notices', 'ActivityFilterModule', 'ProfileFilterModule', 'Content', 'Ads');
$Configuration['Modules']['Vanilla']['Panel'] = array('MeModule', 'UserBoxModule', 'GuestModule', 'NewDiscussionModule', 'DiscussionFilterModule', 'SignedInModule', 'Ads');
$Configuration['Modules']['Vanilla']['Content'] = array('MessageModule', 'MeModule', 'UserBoxModule', 'NewDiscussionModule', 'ProfileOptionsModule', 'Notices', 'NewConversationModule', 'NewDiscussionModule', 'DiscussionFilterModule', 'CategoryModeratorsModule', 'Content', 'Ads');
$Configuration['Modules']['Conversations']['Panel'] = array('MeModule', 'UserBoxModule', 'NewConversationModule', 'SignedInModule', 'GuestModule', 'Ads');
$Configuration['Modules']['Conversations']['Content'] = array('MessageModule', 'MeModule', 'UserBoxModule', 'NewConversationModule', 'Notices', 'Content', 'Ads');

// Plugins
$Configuration['Plugins']['GettingStarted']['Dashboard'] = '1';
$Configuration['Plugins']['GettingStarted']['Categories'] = '1';
$Configuration['Plugins']['GettingStarted']['Plugins'] = '1';
$Configuration['Plugins']['GettingStarted']['Profile'] = '1';
$Configuration['Plugins']['GettingStarted']['Registration'] = '1';
$Configuration['Plugins']['GettingStarted']['Discussion'] = '1';
$Configuration['Plugins']['Tecent']['ChooseName'] = TRUE;
$Configuration['Plugins']['TecentConnect']['ConsumerKey'] = '100266222';
$Configuration['Plugins']['TecentConnect']['SiteUrl'] = 'www.aiqingda.com';
$Configuration['Plugins']['TecentConnect']['Secret'] = '36b69ba130510b8165b0fd29b3dd3060';
$Configuration['Plugins']['AutoExpireDiscussions']['Version'] = '0.1b';
$Configuration['Plugins']['Akismet']['UserID'] = '1132';
$Configuration['Plugins']['ProfileExtender']['ProfileFields'] = 'Location,Facebook,Twitter,Website';
$Configuration['Plugins']['ProfileExtender']['RegistrationFields'] = 'Location';
$Configuration['Plugins']['ProfileExtender']['TextMaxLength'] = 140;
$Configuration['Plugins']['StopForumSpam']['UserID'] = '4';
$Configuration['Plugins']['Cleanser']['Action'] = 'create';
$Configuration['Plugins']['Cleanser']['MaxRecords'] = '';
$Configuration['Plugins']['Cleanser']['Offset'] = '';
$Configuration['Plugins']['Cleanser']['RoleSet'] = '8';
$Configuration['Plugins']['Cleanser']['IPAddress'] = '';
$Configuration['Plugins']['Cleanser']['PatternMatch'] = '';

// Preferences
$Configuration['Preferences']['Email']['ConversationMessage'] = '1';
$Configuration['Preferences']['Email']['BookmarkComment'] = '1';
$Configuration['Preferences']['Email']['WallComment'] = '0';
$Configuration['Preferences']['Email']['ActivityComment'] = '0';
$Configuration['Preferences']['Email']['DiscussionComment'] = '0';
$Configuration['Preferences']['Email']['Mention'] = '0';
$Configuration['Preferences']['Popup']['ConversationMessage'] = '1';
$Configuration['Preferences']['Popup']['BookmarkComment'] = '1';
$Configuration['Preferences']['Popup']['WallComment'] = '1';
$Configuration['Preferences']['Popup']['ActivityComment'] = '1';
$Configuration['Preferences']['Popup']['DiscussionComment'] = '1';
$Configuration['Preferences']['Popup']['Mention'] = '1';

// ProfileExtender
$Configuration['ProfileExtender']['Fields']['Location']['Label'] = 'Location';
$Configuration['ProfileExtender']['Fields']['Location']['Length'] = 140;
$Configuration['ProfileExtender']['Fields']['Location']['FormType'] = 'TextBox';
$Configuration['ProfileExtender']['Fields']['Location']['OnProfile'] = 1;
$Configuration['ProfileExtender']['Fields']['Location']['OnRegister'] = 1;
$Configuration['ProfileExtender']['Fields']['Location']['OnDiscussion'] = 0;
$Configuration['ProfileExtender']['Fields']['Location']['Required'] = 0;
$Configuration['ProfileExtender']['Fields']['Location']['Locked'] = 0;
$Configuration['ProfileExtender']['Fields']['Location']['Sort'] = 0;
$Configuration['ProfileExtender']['Fields']['Facebook']['Label'] = 'Facebook';
$Configuration['ProfileExtender']['Fields']['Facebook']['Length'] = 140;
$Configuration['ProfileExtender']['Fields']['Facebook']['FormType'] = 'TextBox';
$Configuration['ProfileExtender']['Fields']['Facebook']['OnProfile'] = 1;
$Configuration['ProfileExtender']['Fields']['Facebook']['OnRegister'] = 0;
$Configuration['ProfileExtender']['Fields']['Facebook']['OnDiscussion'] = 0;
$Configuration['ProfileExtender']['Fields']['Facebook']['Required'] = 0;
$Configuration['ProfileExtender']['Fields']['Facebook']['Locked'] = 0;
$Configuration['ProfileExtender']['Fields']['Facebook']['Sort'] = 0;
$Configuration['ProfileExtender']['Fields']['Twitter']['Label'] = 'Twitter';
$Configuration['ProfileExtender']['Fields']['Twitter']['Length'] = 140;
$Configuration['ProfileExtender']['Fields']['Twitter']['FormType'] = 'TextBox';
$Configuration['ProfileExtender']['Fields']['Twitter']['OnProfile'] = 1;
$Configuration['ProfileExtender']['Fields']['Twitter']['OnRegister'] = 0;
$Configuration['ProfileExtender']['Fields']['Twitter']['OnDiscussion'] = 0;
$Configuration['ProfileExtender']['Fields']['Twitter']['Required'] = 0;
$Configuration['ProfileExtender']['Fields']['Twitter']['Locked'] = 0;
$Configuration['ProfileExtender']['Fields']['Twitter']['Sort'] = 0;
$Configuration['ProfileExtender']['Fields']['Website']['Label'] = 'Website';
$Configuration['ProfileExtender']['Fields']['Website']['Length'] = 140;
$Configuration['ProfileExtender']['Fields']['Website']['FormType'] = 'TextBox';
$Configuration['ProfileExtender']['Fields']['Website']['OnProfile'] = 1;
$Configuration['ProfileExtender']['Fields']['Website']['OnRegister'] = 0;
$Configuration['ProfileExtender']['Fields']['Website']['OnDiscussion'] = 0;
$Configuration['ProfileExtender']['Fields']['Website']['Required'] = 0;
$Configuration['ProfileExtender']['Fields']['Website']['Locked'] = 0;
$Configuration['ProfileExtender']['Fields']['Website']['Sort'] = 0;

// Routes
$Configuration['Routes']['DefaultController'] = array('discussions', 'Internal');
$Configuration['Routes']['DefaultForumRoot'] = 'discussions';
$Configuration['Routes']['Default404'] = array('dashboard/home/filenotfound', 'NotFound');
$Configuration['Routes']['DefaultPermission'] = array('dashboard/home/permission', 'NotAuthorized');
$Configuration['Routes']['UpdateMode'] = 'dashboard/home/updatemode';

// Vanilla
$Configuration['Vanilla']['Version'] = '2.1';
$Configuration['Vanilla']['Discussions']['Layout'] = 'modern';
$Configuration['Vanilla']['Categories']['Layout'] = 'mixed';
$Configuration['Vanilla']['Discussion']['SpamCount'] = '1';
$Configuration['Vanilla']['Discussion']['SpamTime'] = '240';
$Configuration['Vanilla']['Discussion']['SpamLock'] = '600';
$Configuration['Vanilla']['Comment']['SpamCount'] = '3';
$Configuration['Vanilla']['Comment']['SpamTime'] = '60';
$Configuration['Vanilla']['Comment']['SpamLock'] = '600';
$Configuration['Vanilla']['Comment']['MaxLength'] = '8000';

// Last edited by sarowlwp (111.161.79.17)2014-04-30 14:01:54