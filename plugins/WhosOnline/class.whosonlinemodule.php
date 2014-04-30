<?php if (!defined('APPLICATION')) exit();
/**
* Renders a list of users who are taking part in a particular discussion.
*/
class WhosOnlineModule extends Gdn_Module {

	protected $_OnlineUsers;

	public function __construct(&$Sender = '') {
		parent::__construct($Sender);
	}

	public function GetData($Invisible = FALSE) {
		$SQL = Gdn::SQL();
		// $this->_OnlineUsers = $SQL
		// insert or update entry into table
		$Session = Gdn::Session();

		$Invisible = ($Invisible ? 1 : 0);

		if ($Session->UserID)
			$SQL->Replace('Whosonline', array(
				'UserID' => $Session->UserID,
				'Timestamp' => Gdn_Format::ToDateTime(),
				'Invisible' => $Invisible),
				array('UserID' => $Session->UserID)
			);     

		$Frequency = C('WhosOnline.Frequency', 4);
		$History = time() - $Frequency;

		$SQL
			->Select('u.UserID, u.Name, u.Photo, w.Timestamp, w.Invisible')
			->From('Whosonline w')
			->Join('User u', 'w.UserID = u.UserID')
			->Where('w.Timestamp >=', date('Y-m-d H:i:s', $History))
			->OrderBy('u.Name');

		if (!$Session->CheckPermission('Plugins.WhosOnline.ViewHidden'))
			$SQL->Where('w.Invisible', 0);

		$this->_OnlineUsers = $SQL->Get();
	}

	public function AssetTarget() {
		//return 'Foot';
		return 'Panel';
	}

	public function ToString() {
		$String = '';
		$Session = Gdn::Session();
		ob_start();
		?>
			<div id="WhosOnline" class="Box">
				<h4><?php echo T("Who's Online"); ?><span class="Count"><?php echo $this->_OnlineUsers->NumRows(); ?></span></h4> 
				<div class="PhotoGridSmall">
				<?php
				if ($this->_OnlineUsers->NumRows() > 0) { 
					foreach($this->_OnlineUsers->Result() as $User) {
				?>
					<!-- <a class="ProfileLink">  -->
						<?php 
							echo $PhotoAnchor = UserPhoto($User, 'Photo');
						 ?>
					<!-- </a> -->
				<?php
					}
				}
				?>
			</div>
		</div>
		<?php
		$String = ob_get_contents();
		@ob_end_clean();
		return $String;
	}
}