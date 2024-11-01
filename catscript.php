<?php



function wp_catfish_basic_args() {

	global $wp_catfish_basic_settings; ?>



<?php if($wp_catfish_basic_settings['enableAd']) : ?>

var expandingAd = new Object();

var mousedover2 = false;



function deploycatfish() {

document.write(' <style type="text/css"> #catfish a {border:none;} #catfish a {color:#FFF;} </style> ');



document.write(' <div id="catfish" style="display:none; position:fixed; bottom:0; background:<?php echo ($wp_catfish_basic_settings['mainbcolor']); ?>; padding:0; height: <?php echo ($wp_catfish_basic_settings['adheight']); ?>; cursor: pointer; margin: 0; width:100%; z-index:1000;"> ');

document.write(' <a href="<?php echo ($wp_catfish_basic_settings['clientweb']); ?>" target="_blank"><div style="text-align:center; height:<?php echo ($wp_catfish_basic_settings['adheight']); ?>; width:1000px; margin:0 auto; padding-top:10px; padding-bottom:10px;"><?php echo ($wp_catfish_basic_settings['adcontent']); ?></div></a>  ');

document.write(' <a href="#" id="catfish-close" style="position:fixed;bottom:0px;right:15px;font-size:12px;color:<?php echo ($wp_catfish_basic_settings['cbtcolor']); ?>;padding:0 7px 0 7px;">X CLOSE</a> ');

document.write(' </div> ');



};


deploycatfish();



/*

	 * jQuery Catfish Plugin - Version 1.3

	 *

	 * Copyright (c) 2007 Matt Oakes (http://www.gizone.co.uk)

	 * Licensed under the MIT (LICENSE.txt)

	 * @link http://www.matto1990.com/jquery/catfish/

	 */



	jQuery.fn.catfish = function(options) {

		this.settings = {

			closeLink: 'none',

			animation: 'slide',

			//height: '79'

		}

		if(options)

			jQuery.extend(this.settings, options);

	

		if ( this.settings.animation != 'fade' && this.settings.animation != 'none' && this.settings.animation != 'slide' ) {

			alert('animation can only be set to \'slide\', \'none\' or \'fade\'');

		}

	

		var id = this.attr('id');

		settings = this.settings;

		jQuery(this).css('padding', '0').css('height', this.settings.height + 'px').css('margin', '0').css('width', '100%');

		jQuery('html').css('padding', '0 0 ' + ( this.settings.height * 1 + 50 ) + 'px 0');

		if ( typeof document.body.style.maxHeight != "undefined" ) {

			jQuery(this).css('position', 'fixed').css('bottom', '0').css('left', '0');

		}

	

		if ( this.settings.animation == 'slide' ) {

			jQuery(this).slideDown('slow');

		}

		else if ( this.settings.animation == 'fade' ) {

			jQuery(this).fadeIn('slow');

		}

		else {

			jQuery(this).show();

		}

		if ( this.settings.closeLink != 'none' ) {

			jQuery(this.settings.closeLink).click(function(){

				$j.closeCatfish(id);

				return false;

			});

		}

	

		// Return jQuery to complete the chain

		return this;

	};

	jQuery.closeCatfish = function(id) {

		this.catfish = jQuery('#' + id);

		jQuery(this.catfish).hide();

		jQuery('html').css('padding', '0');

		jQuery('body').css('overflow', 'visible'); // Change IE6 hack back

	};

	

	// begin loading the ad

	var $j = jQuery.noConflict();
	$j(window).load(function(){

		$j('#catfish').catfish({

			closeLink: '#catfish-close'

		});

		//// START - SET COOKIE FOR PREVIEW FUNCTION //////



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



   



	var cookie = getcookie("sbb");



//alert(cookie);



if(cookie)



 {



  document.getElementById('catfish').style.display = 'none'; 



 }



 else



 {



  //document.getElementById('catfish').style.display = 'block';



  var today = new Date();



  var expire = new Date();



  expire.setTime(today.getTime() + <?php echo ($wp_catfish_basic_settings['cookietime']); ?>);  // currently set for 10 minutes.



  document.cookie = "sbb=1;path=/;expires="+expire.toGMTString();



}



function getcookie(cookiename) {



var cookiestring=""+document.cookie;



var index1=cookiestring.indexOf(cookiename);



if (index1==-1 || cookiename=="") return ""; 



var index2=cookiestring.indexOf(';',index1);



if (index2==-1) index2=cookiestring.length; 



return unescape(cookiestring.substring(index1+cookiename.length+1,index2));



	}







//// END - SET COOKIE FOR PREVIEW FUNCTION //////



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	});

<?php endif; ?>



<?php }



 ?>