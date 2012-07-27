$(document).ready(function() {
	var fm = new FlexiModal();
	
	var media = [
		{ content : '<iframe src="http://player.vimeo.com/video/43623906" width="500" height="213" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>' }
	];
	
	fm.showCallback = function() {
		$('.content').fadeTo( 'fast', 1);
	}
	
	fm.hideCallback = function() {
		$('.content').fadeTo( 'fast', 0);
	}
	
	fm.setMedia( media );
	
	
	$('article.format-video').css('cursor', 'pointer');
	
	$('article.format-video').on( 'click', function() {
		var href = $(this).find('a').attr('href');
		window.location.href = href;
	})
	
	$('article.mini_video header').on( 'click', function(evt){
		evt.preventDefault();
		fm.show();
	})
});