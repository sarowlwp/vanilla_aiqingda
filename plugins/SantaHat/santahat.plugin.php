<?php if (!defined('APPLICATION')) exit();

$PluginInfo['SantaHat'] = array(
	'Name' => 'Santa Hat',
	'Description' => 'Puts a small santa hat over avatar. Tested on default theme.',
	'RequiredApplications' => array('Vanilla' => '>= 2.0.13'),
	'Version' => '1.0.1',
	'Date' => '20 Dec 2010',
	'Author' => 'Grandfather Frost',
	'AuthorUrl' => 'http://www.velikiy-ustyug-city.com'
);


class SantaHatPlugin extends Gdn_Plugin {
	
	static public $Hats = array(
		'hat1.png' => array('class' => 'SantaHat'),
		'hat2.png' => array('class' => 'SantaHat2'),
		'hat3.png' => array('class' => 'SantaHat'),
		'hat4b.png' => array('class' => 'SantaHat4')
	);
	
	public function DiscussionController_Render_Before($Sender) {
		$Sender->AddCssFile( $this->GetWebResource('design/santahat.css') );
	}
	
	public function DiscussionController_BeforeCommentMeta_Handler($Sender) {
		$Author =& $Sender->EventArguments['Author'];
		if ($Author->Photo) {
			$RandomHat = array_rand(self::$Hats);
			echo Img($this->GetWebResource('design/'.$RandomHat), ArrayValue($RandomHat, self::$Hats));
		}
	}
	
	public function Setup() {
	}
}