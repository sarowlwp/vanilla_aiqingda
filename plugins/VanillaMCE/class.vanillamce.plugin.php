<?php if(!defined('APPLICATION')) die();

// Define the plugin:
$PluginInfo['VanillaMCE'] = array(
   'Name' => 'VanillaMCE',
   'Description' => 'Gives you the latest version of TinyMCE for your Vanilla Forum',
   'Version' => '1.0',
   'Author' => "Shaqaruden",
   'AuthorEmail' => 'plugins@shaqaruden.com',
   'AuthorUrl' => 'http://www.shaqaruden.com',
   
);

class VanillaMCEPlugin extends Gdn_Plugin {
	
	private $path;
	
	public function __construct()
	{
		$this->path = Gdn::Request()->Url('plugins/VanillaMCE');
	}
	
	public function Base_Render_Before($Sender)
	{
		$mode = "full"; // simple/full/medium
		
		$Sender->AddJSFile('plugins/VanillaMCE/tinymce.min.js');
		//$Sender->AddJSFile('plugins/VanillaMCE/jquery.tinymce.js');
		$Sender->Head->AddString($this->_mode($mode));
	}
	
	private function _mode($mode = "full")
	{
		return $this->_full();
		
	}
	
	private function _full()
	{
		$html = <<<EOF
			<script type="text/javascript">
				tinymce.init({
					script_url : '$this->path/tiny_mce.js',
				    selector: "textarea",
				    plugins: [
				        "autolink lists link image charmap print preview anchor",
				        "searchreplace visualblocks code",
				        "insertdatetime media table contextmenu paste"
				    ],
				    theme_advanced_toolbar_location : "top",
					theme_advanced_toolbar_align : "left",
					theme_advanced_statusbar_location : "bottom",
				    toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
				});
			</script>
EOF;
		// No WhiteSpace in front of EOF!!

		return $html;		
	}
	
	public function Setup(){}
}