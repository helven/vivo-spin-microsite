(function($){
	$.fn.zbox	= function(o_Option, callback){
		return this.each(function(){
			o_Option = $.extend({}, $.fn.zbox.defaultOptions, o_Option);
			var o_This = $(this).get(0);
			var $o_This = $(this);
			var zboxTemplate	= '<div id="{zbox_id}"  class="zbox">';
					zboxTemplate	+= '<div class="main_slot">';
							zboxTemplate	+= '<div class="body">{zbox_content}</div>';
								if(o_Option.gallery)
								{
									zboxTemplate	+= '<a href="javascript: void(0);" class="zbox_prev">' + o_Option.prevBtn + '</a>';
									zboxTemplate	+= '<a href="javascript: void(0);" class="zbox_next">' + o_Option.nextBtn + '</a>';
								}
							zboxTemplate	+= '<a href="javascript: void(0);" class="zbox_close">' + o_Option.closeBtn + '</a>';
							zboxTemplate	+= '</a>';
					zboxTemplate	+= '</div>';
					zboxTemplate	+= '<div class="overlay"></div>';
				zboxTemplate	+= '</div>';
			
			_init();
			if(callback)
			{
				callback();
			}
			
			function _init()
			{
				$(document).on('click', '.zbox_open', function(){
					htmlContent	= $(this).parents('.zbox_item').find('.zbox_html').val();
					
					_open_zbox(htmlContent);
					
					if(o_Option.gallery)
					{
						$(this).parents('.zbox_item').addClass('zbox_active');
					}
				});
				
				$(document).on('click', '.zbox_close', function(){
					o_Zbox	= $(this).parents('.zbox');
					o_Zbox.css({opacity: 0});
					setTimeout(function(){
						o_Zbox.remove();
					}, o_Option.transitionDelay * 1100);
					
					$('.zbox_item').removeClass('zbox_active');
				});
				
				if(o_Option.gallery)
				{
					$(document).on('click', '.zbox_next', function(){
						activeTag	= $o_This.children('.zbox_active').prop("tagName");
					
						if($('.zbox_active').next(activeTag)[0])
						{
							$o_New	= $o_This.children('.zbox_active').next(activeTag);
						}
						else
						{
							$o_New	= $o_This.children('.zbox_active').siblings(activeTag + ':first-child');
						}
						
						htmlContent	= $o_New.find('.zbox_html').val();
						$o_This.children('.zbox_active').removeClass('zbox_active')
						$o_New.addClass('zbox_active');
						
						$('.zbox .body').html(htmlContent);
					});
					
					$(document).on('click', '.zbox_prev', function(){
						activeTag	= $o_This.children('.zbox_active').prop("tagName");
						
						if($('.zbox_active').prev(activeTag)[0])
						{
							$o_New	= $o_This.children('.zbox_active').prev(activeTag);
						}
						else
						{
							$o_New	= $o_This.children('.zbox_active').siblings(activeTag + ':last-child');
						}
						
						htmlContent	= $o_New.find('.zbox_html').val();
						$o_This.children('.zbox_active').removeClass('zbox_active')
						$o_New.addClass('zbox_active');
						
						$('.zbox .body').html(htmlContent);
					});
				}
			}
			
			function _open_zbox(content)
			{
				cacheBuster	= new Date().getTime();
				$('.zbox').remove();
				$('.zbox_item').removeClass('zbox_active');
				
				HTML	= zboxTemplate;
				HTML	= HTML.replace(/{zbox_id}/i, 'div_ZBOX-' + cacheBuster);
				HTML	= HTML.replace(/{zbox_content}/i, content);
				
				$('body').append(HTML);
				
				setTimeout(function(){
					$('#div_ZBOX-' + cacheBuster).css({display: 'block'});
					setTimeout(function(){
						$('#div_ZBOX-' + cacheBuster).css({opacity: 1});
						
						$.fn.zboxFBFix();
						
						if(o_Option.callback)
						{
							o_Option.callback();
						}
					}, 50);
				}, 50);
			}
		});
	};
	$.fn.zboxClose	= function(){
		return this.each(function(){
			o_Option = $.fn.zbox.defaultOptions;
			o_Zbox	= $('.zbox');
			o_Zbox.css({opacity: 0});
			setTimeout(function(){
				o_Zbox.remove();
			}, o_Option.transitionDelay * 1100);
			
			$('.zbox_item').removeClass('zbox_active');
		});
	};
	$.fn.zboxOpen	= function(o_Option, callback){
		return this.each(function(){
			o_Option = $.extend({}, $.fn.zbox.defaultOptions, o_Option);
			var o_This = $(this).get(0);
			var $o_This = $(this);
			var zboxTemplate	= '<div id="{zbox_id}"  class="zbox">';
					zboxTemplate	+= '<div class="main_slot">';
						zboxTemplate	+= '<div class="body" style="max-height:900px;">{zbox_content}</div>';
						zboxTemplate	+= '<a href="javascript: void(0);" class="zbox_close">' + o_Option.closeBtn + '</a>';
					zboxTemplate	+= '</div>';
					zboxTemplate	+= '<div class="overlay"></div>';
				zboxTemplate	+= '</div>';
			
			_init();
			if(callback)
			{
				callback();
			}
			
			function _init()
			{
				$(document).on('click', '.zbox_close', function(){
					o_Zbox	= $(this).parents('.zbox');
					o_Zbox.css({opacity: 0});
					setTimeout(function(){
						o_Zbox.remove();
					}, o_Option.transitionDelay * 1100);
				});
				htmlContent	= o_Option.text;
				_open_zbox(htmlContent);
			}
			
			function _open_zbox(content)
			{
				cacheBuster	= new Date().getTime();
				$('.zbox').remove();
				$('.zbox_item').removeClass('zbox_active');
				
				HTML	= zboxTemplate;
				HTML	= HTML.replace(/{zbox_id}/i, 'div_ZBOX-' + cacheBuster);
				HTML	= HTML.replace(/{zbox_content}/i, content);
				
				$('body').append(HTML);
				
				setTimeout(function(){
					$('#div_ZBOX-' + cacheBuster).css({display: 'block'});
					setTimeout(function(){
						$('#div_ZBOX-' + cacheBuster).css({opacity: 1});
						
						$.fn.zboxFBFix();
						
						if(o_Option.callback)
						{
							o_Option.callback();
						}
					}, 50);
				}, 50);
			}
		});
	};
	$.fn.zboxFBFix = function(){
		try
		{
			FB.Canvas.getPageInfo(
				function(o_FBPageInfo) {
					jQuery('.zbox .main_slot').css({top: (o_FBPageInfo.scrollTop + 30) + 'px'})
				}
			);
		}
		catch(e)
		{}
	}
	$.fn.zbox.defaultOptions = {
		type	: 'html',
		text	: '',
		gallery	: false,
		closeBtn: 'X',
		prevBtn	: '&lt;',
		nextBtn	: '&gt;',
		transitionDelay	: 0.2
	};
})(jQuery);