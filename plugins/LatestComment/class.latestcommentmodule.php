<?php if (!defined('APPLICATION')) exit();

class LatestCommentModule extends Gdn_Module {
	protected $_LatestComments;
	public function __construct(&$Sender = '') {
		parent::__construct($Sender);
	}

/*
	public function GetAllDiscussion(){
		$SQL = Gdn::SQL();
		return $SQL->Select('p.DiscussionID, p.CategoryID, p.Name, p.Body, p.DateLastComment, p.LastCommentUserID, p.CountComments')->From('Discussion p')->OrderBy('p.DateLastComment', 'desc')->Get()->ResultArray();         
	}
*/

	public function GetData() {
		$SQL = Gdn::SQL();		
		$Limit = Gdn::Config('LatestComment.Limit');
		$LatestOrMost = Gdn::Config('LatestComment.Show.LatestComment');
		$Limit = (!$Limit || $Limit ==0)?10:$Limit;
		$Session = Gdn::Session();
		if($LatestOrMost == "YES")
		{
		$this->_LatestComments = $SQL->Query('SELECT DiscussionID, CategoryID, Name, Body, DateLastComment, LastCommentUserID, CountComments From '.$SQL->Database->DatabasePrefix.'Discussion order by DateLastComment desc LIMIT '.$Limit);
		}
		else
		{
		$this->_LatestComments = $SQL->Query('SELECT DiscussionID, CategoryID, Name, Body, DateLastComment, LastCommentUserID, CountComments From '.$SQL->Database->DatabasePrefix.'Discussion order by CountComments desc LIMIT '.$Limit);
		}
	}
	
	public function getLatestComments(){
		return $this->_LatestComments;
	}

	public function AssetTarget() {
		return 'Panel';
	}

	public function g_substr($str, $len = 12, $dot = true) {
        $i = 0;
        $l = 0;
        $c = 0;
        $a = array();
        while ($l < $len) {
            $t = substr($str, $i, 1);
            if (ord($t) >= 224) {
                $c = 3;
                $t = substr($str, $i, $c);
                $l += 2;
            } elseif (ord($t) >= 192) {
                $c = 2;
                $t = substr($str, $i, $c);
                $l += 2;
            } else {
                $c = 1;
                $l++;
            }
            // $t = substr($str, $i, $c);
            $i += $c;
            if ($l > $len) break;
            $a[] = $t;
        }
        $re = implode('', $a);
        if (substr($str, $i, 1) !== false) {
            array_pop($a);
            ($c == 1) and array_pop($a);
            $re = implode('', $a);
            $dot and $re .= '...';
        }
        return $re;
    }
	
	public function ToString() {
		$String = '';
		$Session = Gdn::Session();
		ob_start();
		$LatestOrMost = Gdn::Config('LatestComment.Show.LatestComment');
		//Hide the top poster box id there's no post greater than 0
		if($this->_LatestComments->NumRows() > 0) {
		?>		
			<div id="LatestComment" class="Box BoxLatestComment">
				<h4><?php if($LatestOrMost == "YES") echo Gdn::Translate("Latest Commented"); else echo Gdn::Translate("Most Commented"); ?></h4>
				<ul class="PanelInfo PanelLatestComment">
				<?php
					$i =1;
					foreach($this->_LatestComments->Result() as $Discussion) {					
				?>
					<li>
					<span><?php //echo UserPhoto(UserBuilder($User),Array('ImageClass'=>'tpProfilePhotoSmall')); ?>
					<strong>
		    			<a href="/discussion/<?php echo $Discussion->DiscussionID; ?>">
						<?php echo $i.'. '.self::g_substr($Discussion->Name,30,true); ?></a>
					</span></strong></li><div style="clear:both;"></div>
				<?php
					$i++;
					}
				?>
			</ul>
		</div>
		<?php
		}
		$String = ob_get_contents();
		@ob_end_clean();
		return $String;
	}
	
	
}