jQuery(document).ready(function($){
    var catsexpire = $.parseJSON(gdn.definition('CatsExpire'));
	$('#Form_CategoryID').bind('change keypress',function(){
		
		if(catsexpire[$(this).val()])
			$('#Form_AutoExpire').removeAttr('disabled');
		else
			$('#Form_AutoExpire').attr('disabled','disabled');
	});
	
	$('#Form_CategoryID').trigger('change');
});
