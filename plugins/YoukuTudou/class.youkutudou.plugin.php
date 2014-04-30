<?php if(!defined('APPLICATION')) exit();
/**
 * YoukuTudou - A plugin for Garden & Vanilla Forums.
 * Copyright (C) 2013  Livid Tech
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * An associative array of information about this plugin.
 */
$PluginInfo['YoukuTudou'] = array(
   'Name' => 'Youku & Tudou Embed',
   'Description' => '允许在主题、回复和动态中嵌入优酷网和土豆网的视频。 Embed Youku and Tudou videos in posts.',
   'Version' => '1.2',
   'Author' => "Livid Tech",
   'AuthorUrl' => 'http://lividtech.com/',
   'License' => 'GPLv3',
   'SettingsUrl' => 'dashboard/settings/youkutudou',
   'MobileFriendly' => TRUE
);

class YoukuTudouPlugin extends Gdn_Plugin {
   /*
    * YoukuTudouIncludes()
    * Include the CSS and JS files.
    * 
    * @param object $Sender; Passed on from events.
    * @return TRUE;
    */
   private function YoukuTudouIncludes($Sender) {
      $Sender->AddCssFile('youkutudou.css', 'plugins/YoukuTudou');
      $Sender->AddJsFile('youkutudou.js', 'plugins/YoukuTudou');
      
      return TRUE;
   }
   
   /*
    * DiscussionController_Render_Before()
    * Include assets in DiscussionController.
    * 
    * @param object $Sender; Passed on from event.
    */
   public function DiscussionController_Render_Before($Sender) {
      $this->YoukuTudouIncludes($Sender);
   }
   
   /*
    * PostController_Render_Before()
    * Include assets in ProfileController.
    * 
    * @param object $Sender; Passed on from event.
    */
   public function PostController_Render_Before($Sender) {
      $this->YoukuTudouIncludes($Sender);
   }
   
   /*
    * ActivityController_Render_Before()
    * Include assets in ActivityController.
    * 
    * @param object $Sender; Passed on from event.
    */
   public function ActivityController_Render_Before($Sender) {
      $this->YoukuTudouIncludes($Sender);
   }
   
   /*
    * ProfileController_Render_Before()
    * Include assets in ProfileController.
    * 
    * @param object $Sender; Passed on from event.
    */
   public function ProfileController_Render_Before($Sender) {
      $this->YoukuTudouIncludes($Sender);
   }
   
   /*
    * PageController_Render_Before()
    * Include assets in PageController.
    * Support for Basic Pages application.
    * 
    * @param object $Sender; Passed on from event.
    */
   public function PageController_Render_Before($Sender) {
      $this->YoukuTudouIncludes($Sender);
   }
   
   /*
    * SettingsController_YoukuTudou_Create()
    * Create the settings page for this plugin.
    * 
    * @param object $Sender; Passed on from event.
    */
   public function SettingsController_YoukuTudou_Create($Sender) {
      $Sender->Permission('Garden.Settings.Manage');
      
      $Sender->AddSideMenu('dashboard/settings/youkutudou');
      
      $Sender->Title('Youku & Tudou Embed Settings');
      
      $View = $this->GetView('youkutudou-settings.php');
      $Sender->Render($View);
   }
}
