var isie6 = window.XMLHttpRequest ? false: true;
var currentpos,timer;
var speed;

jQuery(document).ready(function($) {
	
	$(document).keydown(function (e) {
		if (e.ctrlKey && e.keyCode == 13) {
		  if ($('input#Form_PostComment').val())
			$('input#Form_PostComment').click();
		  else if ($('input#Form_PostDiscussion').val())
			$('input#Form_PostDiscussion').click();
		  else {
			$(this.parentNode.getElementsByClassName('Button')).click();
		  }
		}
	});
	
	function newtoponload() {
		var c = document.getElementById("returntotop");
		function b() {
			var a = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
			if (a > 0) {
				if (isie6) {
					c.style.display = "none";
					clearTimeout(window.show);
					window.show = setTimeout(function() {
						var d = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
						if (d > 0) {
							c.style.display = "block";
							c.style.top = (400 + d) + "px"
						}
					},
					300)
				} else {
					c.style.display = "block"
				}
			} else {
				c.style.display = "none"
			}
		}
		if (isie6) {
			c.style.position = "absolute"
		}
		window.onscroll = b;
		b()
	}
	if (window.attachEvent) {
		window.attachEvent("onload", newtoponload)
	} else {
		window.addEventListener("load", newtoponload, false)
	}
	document.getElementById("returntotop").onclick = function() {
		$("html,body").animate({scrollTop:0});
		//clearInterval(timer);
		//initialize();
		//window.scrollTo(0, 0)
	};
	
});
/*
	function initialize(){
		speed=300;
		timer=setInterval ("scrollwindow()",0);
	};
	
	function sc(){
		speed=0;
		clearInterval(timer);
	};
	
	function scrollwindow(){
		currentpos = document.documentElement.scrollTop || document.body.scrollTop; 
		window.scrollTo(0,currentpos-speed);
		if(currentpos-speed<=0){
			sc();
		}else{
			speed=speed+300;
		}
	};
*/