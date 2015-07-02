/**
*  ensure specified input fields will accept those predefined values
*  two configurable options
*  1. allow: only those specified within this option will be acceptable
*  2. disallow: anything (or only those specified within allow option if allow option isn't empty)
*               will be acceptable except those specified within this option
*/
jQuery.fn.inputValue = function(options)
{
	var settings = jQuery.extend({allow:'', disallow:''}, options);
	return jQuery(this).keypress
		(
			function (e)
				{
					if (!e.charCode)
						var code = String.fromCharCode(e.which);
					else
						var code = String.fromCharCode(e.charCode);
					if(code && (typeof(e.keyCode) == 'undefined' || (e.keyCode != 8 && e.keyCode != 46 && e.keyCode != 9)))
					{
						if(settings.allow.length != 0 && settings.disallow.length != 0)
						{
							if(settings.allow.indexOf(code) == -1)
							{
								e.preventDefault();
							}else if(settings.disallow.indexOf(code) != -1)
							{
								e.preventDefault();
							}
						}else if(settings.allow.length != 0)
						{
							if(settings.allow.indexOf(code) == -1)
							{
								e.preventDefault();
							}
						}else if(settings.disallow.length != 0)
						{
							if(settings.disallow.indexOf(code) != -1)
							{
								e.preventDefault();
							}
						}
					}
					if (e.ctrlKey && code=='v')
						e.preventDefault();
					$(this).bind('contextmenu',function () {return false});
				}
		);

};
/**
*	input fields will accept valid email address
*/
jQuery.fn.inputEmail = function()
{
		return this.each (function()
			{
				jQuery(this).inputValue({allow:'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@.0123456789'});
			}
		);
};
/**
*	input fields will accept digits only
*/
jQuery.fn.inputInteger = function()
{
		return this.each (function()
			{
				jQuery(this).inputValue({allow:'9876543210'});
			}
		);
};
/**
*	input fields will accept digits and dots.
*/
jQuery.fn.inputFloat = function()
{
		return this.each (function()
			{
				jQuery(this).inputValue({allow:'0123456789.'});
			}
		);
};
/**
*	input fields will accept all letters (case insensitive)
*/
jQuery.fn.inputLetter = function()
{
		return this.each (function()
			{
				jQuery(this).inputValue({allow:'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'});
			}
		);
};