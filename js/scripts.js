$(document).ready(function() {
	$('article.format-video').css('cursor', 'pointer');
	
	$('article.format-video').on( 'click', function() {
		var href = $(this).find('a').attr('href');
		window.location.href = href;
	})
});