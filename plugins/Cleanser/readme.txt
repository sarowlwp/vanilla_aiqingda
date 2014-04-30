
Thanks for using the Plugin.

Please go to the settings page in the dashboard for this plugin.
It is always a good idea to disable the plugin and then update to new version, and then re-enable, and check settings.

Please Consider sending a donation to Peregrine if you found this plugin useful.  You can find out how to donate in my other plugins. 

Perhaps a contribution equivalent to a cup of coffee or a lunch, if this plugin helped you.


Peregrine

----------------------------------------------------


A FEW IMPORTANT THINGS YOU NEED TO KNOW before running the plugin.

1) Please BACKUP YOUR DATABASE BEFORE PURGING RECORDS.
2)  You can use the offset to move up thelist. If you need to purge more entries you may need to run the create list and purge multiple times.
3) Please view the list carefully to determine if the entries on the list are indeed the entries you want to delete.
4) if you want menu options for Cleanser in the Moderation side panel of your dashboard for the administrator, go into privileges for administrator and check the manage Cleanser box.
5) You must ensure that plugins/Cleanser/list/cleanserlisttxt is writeable.  You may need to change the permissions on plugins/Cleanser/list folder and/or cleanserlisttxt file itself.



6) Line entries in the plugins/Cleanser/list/cleanserlisttxt can be deleted.  If you desire to remove an entry from the list created you can download the file to your pc, remove entries line by line, and then upload the file. You may be able to edit via cPanel.  View the list again to ensure you have modified the list correctly.  Be careful, if entries have multiple roles, the user will be deleted for all roles.
   
e.g.  if  results are as follows 
   
3|mary|Member|mary@none.com|127.0.0.1|December 8|14|7||
4|peregrine|Member|peregine@none.com|127.0.0.1|December 12|15|19||
5|ta|Member|ta@none.com|127.0.0.1|July 5|0|0||
6|jan|Member|jan@none.com|127.0.0.1|December 21|4|0|see my spamsite www.spammer.us|
27|aaone|Guest, Applicant, Member, testadmin|use@none.com|127.0.0.1|August 8|0|0||

and I don't want to delete peregrine or aaone  I can remove the lines in a test editor and then re-upload the list as follows.

3|mary|Member|mary@none.com|127.0.0.1|December 8|14|7||
5|ta|Member|ta@none.com|127.0.0.1|July 5|0|0||
6|jan|Member|jan@none.com|127.0.0.1|December 21|4|0|see my spamsite www.spammer.us|


Do NOT MODIFY INDIVIDUAL LINES in cleanserlist, you can only DELETE lines.


7) the list created is currently restricted to "users" that have NOT made any comments or discussions.

Hope this plugin is helpful to you.


