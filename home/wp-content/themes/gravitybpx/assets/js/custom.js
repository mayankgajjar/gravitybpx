/**
 * Scripts within the customizer controls window.
 *
 * Contextually shows the color hue control and informs the preview
 * when users open or close the front page sections section.
 */
 
jQuery(document).ready(function()
{
	
	//jQuery(".login_show_in_popup a").fancybox();
	//jQuery(".reg_show_in_popup a").fancybox();
	
	if(jQuery(".cplus").length)
	{
		jQuery(".cplus").on("click",function()
		{
			jQuery(".short-content").hide();
			jQuery(".full-content").show();
		});
	}
	
	if(jQuery(".cminus").length)
	{	
		jQuery(".cminus").on("click",function()
		{
			jQuery(".full-content").hide();
			jQuery(".short-content").show();
		});
	}	
	
	if(jQuery(".quick-contact-row .vc_col-sm-3").length && jQuery(".quick-contact-row .vc_col-sm-9").length)
	{
		jQuery(".quick-contact-row .vc_col-sm-3 , .quick-contact-row .vc_col-sm-9").wrapAll("<div class='main-row-cotainer'></div>");
	}	
	
	jQuery(".section-gapping > div").addClass("main-row-container");
	
	if(jQuery('#site-navigation').length)
	{
		jQuery('body').click(function(e) 
		{
			if(!jQuery(e.target).closest('#site-navigation').length){
				jQuery("#site-navigation").removeClass("toggled-on");
			}
		});
	}
	/* Validation for Quick Contact Form Start */
	jQuery(".wpcf7-submit").click( function()
	{
	  var validdata = 1;
	  
	  var RegExponlycs = /^[a-zA-Z\s]*$/;
	  if(jQuery(".your-name input").val() == "" || !RegExponlycs.test(jQuery(".your-name input").val()))
	  {
		  jQuery(".your-name input").addClass( "wpcf7-not-valid" );
		  validdata = 0;
	  }
	  else
	  {
		  jQuery(".your-name input").removeClass( "wpcf7-not-valid" );
	  }
	  var RegExpemail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	  if(jQuery(".your-email input").val() == "" || !RegExpemail.test(jQuery(".your-email input").val()))
	  {
		  jQuery(".your-email input").addClass( "wpcf7-not-valid" );
		  validdata = 0;
	  }
	  else
	  {
		  jQuery(".your-email input").removeClass( "wpcf7-not-valid" );
	  }
	  var RegExponlyn = /^[0-9]{10,12}$/;
	  if(jQuery(".your-phone input").val() != "" && !RegExponlyn.test(jQuery(".your-phone input").val()))
	  {
		  jQuery(".your-phone input").addClass( "wpcf7-not-valid" );
		  validdata = 0;
	  }
	  else
	  {
		  jQuery(".your-phone input").removeClass( "wpcf7-not-valid" );
	  }
	  if(validdata == 0)
	  {
		  jQuery(".wpcf7-response-output").show();
		  jQuery(".wpcf7-response-output").addClass( "wpcf7-validation-errors" );
		  jQuery(".wpcf7-validation-errors").text( "Validation errors occurred. Please confirm the fields and submit it again." );
		  return false;
	  }
	  else
	  {
		 return true; 
	  }
	});
	/* Validation for Quick Contact Form Finish*/
	
	
	jQuery(".scrolltop").click(function(){
		jQuery('html, body').animate({'scrollTop' : 0 });
	});
	jQuery(window).scroll(function() {    
		var scroll = jQuery(window).scrollTop();
		if (scroll >= 200) {
			jQuery(".scrolltop").show();
		}else{
			jQuery(".scrolltop").hide();
		}
	});	
}); 


jQuery(window).load(function()
{	
	if(jQuery(".testimonials-div").length)
	{
		jQuery(".testimonials-div").owlCarousel(
		{
			items : 1,
			lazyLoad : true,	
			loop:true,
			autoplay:false,
			autoplayTimeout:1000,
			nav:true,
			margin:28,
			responsiveClass:true,
			responsive:{
				0:{
					items:1,
					nav:true,
					margin:10
					
				},
				600:{
					items:1,
					nav:true
				},				
				1000:{
					items:1,
					nav:true
				},				
			}
		}); 
	}
	
	if(jQuery(".client-logo-div").length)
	{
		jQuery(".client-logo-div").owlCarousel(
		{
			items : 6,
			lazyLoad : true,	
			loop:true,
			autoplay:false,
			autoplayTimeout:1000,
			nav:true,
			margin:28,
			responsiveClass:true,
			responsive:{
				0:{
					items:1,
					nav:true,
					margin:10
					
				},
				600:{
					items:4,
					nav:true
				},				
				1000:{
					items:6,
					nav:true
				},				
			}
		}); 
	}	
	
	if(jQuery(".latest-blog-div").length)
	{
		jQuery(".latest-blog-div").owlCarousel(
		{
			items : 3,
			lazyLoad : true,	
			loop:true,
			autoplay:false,
			autoplayTimeout:1000,
			nav:true,
			margin:30,
			responsiveClass:true,
			responsive:{
				0:{
					items:1,
					nav:true,
					margin:10
					
				},
				600:{
					items:2,
					nav:true
				},				
				1000:{
					items:3,
					nav:true
				},				
			}
		}); 
	}
});

jQuery(window).on("load resize",function()
{
	if(jQuery("button.menu-toggle").is(":visible"))
	{
		if(jQuery(".close_me").length=="0")
		jQuery("<span class='close_me'>×</span>").insertBefore(".menu-top-menu-container ul#top-menu");
	}
	
	jQuery(".close_me").on("click",function()
	{
		jQuery("#site-navigation").removeClass("toggled-on"); 
	});
	
});