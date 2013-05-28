/*
 * password 1.0 - Random password generator for jQuery
 *
 * Copyright (c) 2009 jQuery Howto
 *
 * Licensed under the GPL license:
 *   http://www.gnu.org/licenses/gpl.html
 *
 * URL:
 *   http://jquery-howto.blogspot.com
 *
 * Author URL:
 *   http://me.boo.uz
 *
 */
(function($){
	$.extend({
	  password: function (length, special) {
		var iteration = 0;
		var password = "";
		var randomNumber;
		if(length == undefined){
			var length = 8;
		}
		if(special == undefined){
			var special = false;
		}
		while(iteration < length){
			randomNumber = (Math.floor((Math.random() * 100)) % 94) + 33;
			if(!special){
				if ((randomNumber >=33) && (randomNumber <=47)) { continue; }
				if ((randomNumber >=58) && (randomNumber <=64)) { continue; }
				if ((randomNumber >=91) && (randomNumber <=96)) { continue; }
				if ((randomNumber >=123) && (randomNumber <=126)) { continue; }
			}
			iteration++;
			password += String.fromCharCode(randomNumber);
		}
		return password;
	  }
	});
})(jQuery);