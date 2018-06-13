/**
 * @name		jQuery Count-UP Plugin
 * @author		Martin Angelov
 * @version 	1.0
 * @url			http://tutorialzine.com/2012/09/count-up-jquery/
 * @license		MIT License
 */

(function($){
	
	// Number of seconds in every time division
	var days	= 24*60*60,
		hours	= 60*60,
		minutes	= 60;
	
	// Creating the plugin
	$.fn.countup = function(prop){
		
		var options = $.extend({
			callback	: function(){},
			start		: new Date()
		},prop);
		
		var passed = 0, d, h, m, s, 
			positions;

		// Initialize the plugin
		init(this, options);
		
		positions = this.find('.position');
		
		(function tick(){
			
			passed = Math.floor((new Date() - options.start) / 1000);
			
			// Number of days passed
			d = Math.floor(passed / days);
			updateDuo(0, 1, d);
			passed -= d*days;
			
			// Number of hours left
			h = Math.floor(passed / hours);
			updateDuo(2, 3, h);
			passed -= h*hours;
			
			// Number of minutes left
			m = Math.floor(passed / minutes);
			updateDuo(4, 5, m);
			passed -= m*minutes;
			
			// Number of seconds left
			s = passed;
			updateDuo(6, 7, s);
			
			// Calling an optional user supplied callback
			options.callback(d, h, m, s);
			
			// Scheduling another call of this function in 1s
			setTimeout(tick, 1000);
		})();
		
		// This function updates two digit positions at once
		function updateDuo(minor,major,value){
			switchDigit(positions.eq(minor),Math.floor(value/10)%10);
			switchDigit(positions.eq(major),value%10);
		}
		
		return this;
	};


	function init(elem, options){
		elem.addClass('countdownHolder');		
		// Creating the markup inside the container
		$.each(['Days','Hours','Minutes','Seconds'],function(i){
			$('<div class="countmain'+this+'"><div class="count'+this+'">').html(
				'<div class="position">\
					<div class="digit static">0</div>\
				</div>\
				<div class="position">\
					<div class="digit static">0 </div>\
				</div></div>'
			).appendTo(elem);
			
			if(this!="Seconds")
			{
				elem.append('<div class="countDiv countDiv'+i+'">'+' '+this.toLowerCase()+', '+'</div>');
			}
			else
			{
				elem.append('<div class="countDiv countDiv'+i+'">'+' '+this.toLowerCase()+' '+'</div>');
			}
			
		});

	}

	// Creates an animated transition between the two numbers
	function switchDigit(position,number){
		
		var digit = position.find('.digit')
		
		if(digit.is(':animated')){
			return false;
		}
		
		if(position.data('digit') == number){
			// We are already showing this number
			return false;
		}
		
		position.data('digit', number);
		
		var replacement = $('<div>',{
			'class':'digit',
			css:{
				top:0,
				opacity:0
			},
			html:number
		});
		
		// The .static class is added when the animation
		// completes. This makes it run smoother.
		
		digit
			.before(replacement)
			.removeClass('static')
			.animate({top:0,opacity:0},'scroll',function(){
				digit.remove();
			})

		replacement
			.delay(100)
			.animate({top:0,opacity:1},'scroll',function(){
				replacement.addClass('static');
			});
	}
})(jQuery);