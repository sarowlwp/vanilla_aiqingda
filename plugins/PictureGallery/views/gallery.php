<?php if (!defined('APPLICATION')) exit();
$this->Head->Title('Browsing Pictures');

$this->AddJsFile('lightbox.js', 'plugins/PictureGallery');
$this->AddCssFile('lightbox.css', 'plugins/PictureGallery');
$this->AddCssFile('gallery.css', 'plugins/PictureGallery');

$this->AddModule('SignedInModule');
$this->AddModule('GuestModule');


echo '<div class="Tabs"><h1>'.T('Picture Gallery').'</h1></div>';

$dir = 'uploads/picgal/';

$path = $_SERVER['REQUEST_URI'];

$ex = explode('/', $path);
$show = 'home';
if(isset($ex[2])){
	// first check if it is a directory
	if(is_dir($dir.$ex[2])){
		$show = 'gallery';
		$doi = str_replace('_', ' ', $ex[2]);
		$folder = $ex[2];
	} else {
		echo '<b>The folder you are looking for could not be found. - '.$ex[2].'</b>';
	}
}

switch($show){
	case 'home':

if ($dh = opendir($dir)) {
	while (($file = readdir($dh)) !== false) {
		if($file != '.' && $file != '..' && filetype($dir.$file) == 'dir'){
			$folders[] = $file;
		}
	}
	closedir($dh);
}

foreach($folders as $vv){

	if(is_file($dir.$vv.'/notes.dat.php')){
		$title = str_replace('_', ' ', $vv);
		echo '<div class="picGals"><h2>'.$title.'</h2>';
		// now lets go through the folder grabbing 4 from it to display as preview..
		$fi = file($dir.$vv.'/notes.dat.php');
		$cc = count($fi);
		unset($fi[0]);
		shuffle($fi);
		for($i=0;$i<9;$i++){
			if(isset($fi[$i])){
				$pg = explode('|', $fi[$i]);
				echo '<div class="pics"><img src="/'.$dir.$vv.'/th/'.$pg[0].'" alt="Free Food Kitchen" /></div>';
			}
		} echo '<div class="clr"></div><div class="linkBar"><a href="/gallery/'.$vv.'">查看更多 '.$title.'</a></div>
		</div>';
	}
}
	break;
	case 'gallery':
	echo '<div class="picGals"><h2>'.$doi.'</h2>';
		$fi = file($dir.$folder.'/notes.dat.php');
		$cc = count($fi);
		// browse the pictures..
		$bb = 0;
		for($i=1; $i<$cc;$i++){
			$pg2 = explode('|', $fi[$i]);
			
			if(is_int($bb/3)){ echo '<div class="clr"></div>'; }
			$bb++;
			echo '
			<div class="pics">
			<a class="fancybox" rel="group" href="/'.$dir.$folder.'/'.$pg2[0].'" title="'.stripslashes(htmlentities(urldecode($pg2[1]))).'"><img src="/'.$dir.$folder.'/th/'.$pg2[0].'" alt="group" /></a><br />
			</div>';
		}
		echo '<div class="clr"></div>';
		?>
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox({
				wrapCSS    : 'fancybox-custom',
				closeClick : true,

				helpers : {
					title : {
						type : 'inside'
					},
					overlay : {
						css : {
							'background-color' : '#eee'
						}
					}
				}
			});
		});
</script>
		<?php
	echo '</div>';
	
	break;
}
?>