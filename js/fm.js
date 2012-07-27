/**
* Liquid Layout Modal Thing ...
* v.2.0
*
* feed me an array of slides.
	each slide can have :
	 	- content
	 	- caption
*	
*
* requires some css & the following html
	<div id="loading"></div>
	<div id="curtain">
	</div>
	<div id="modal_layer">
		<div id="modal_uber_wrap">
			<div id="modal_wrap">
			</div>
			<a id="modal_prev" class="modal_nav" href="#" rel="prev"></a>
			<a id="modal_next" class="modal_nav" href="#" rel="next"></a>
			<div id="modal_nav_wrap">
				<div id="modal_caption"></div>
				<div id="modal_subnav_wrap"></div>
				<div id="modal_pagemarker"></div>
			</div>
		</div>
	</div>
	<div id="modal_loader"></div>
	<a id="close_curtain" href="#">X</a>
*
* @beecher : todo :
* 	- local caching 
* 	- slideshow play/pause ?
*	- touch events ?
*	- animations ?
*	- zoom ? 
*/

var FlexiModal = function(media) {

	this.mainPieces = '';
	this.loaderBg = '';
	this.isBound = false;
	this.isOpen = false;
	this.media = media;
	this.showCaptions = false;
	this.captions = [];
	this.count = 0;
	this.currentIdx = 0;
	this.showCallback = undefined;
	this.hideCallback = undefined;

	// ======================== funcs …
	this.load = function(media) {		
				
		$("#modal_wrap").html(media.content);
			
		var caption = media.caption;
				
		switch (true) {
			
			case (caption === null):
			case (caption == ''):
			case (caption === undefined):
				$("#modal_caption").html('');
				$("#modal_caption").hide();
				break;
			
			default:
				$("#modal_caption").html(caption);
				$("#modal_caption").show();
				break;	
		
		}
	
	} //
	this.center = function() {
	
		var ME = this,
			imgTest = $("#modal_wrap").html().indexOf('<img') >= 0 ? true : false;
		
		if(imgTest) {
			
			$("#modal_wrap img").load(function(){
				
				ME.centerIt();
				
			});
			
		} else {
			
			this.centerIt();
			
		}
		
	} //
	this.centerIt = function() {
		
		var wH = $(window).height(),
			subNavHeight = $("#modal_subnav_wrap").height() === undefined ? 0 : $("#modal_subnav_wrap").height() * 1,
			mH = $("#modal_wrap").height() + subNavHeight,
			scrollTop = $(window).scrollTop(),
			mTop = mH < wH ? Math.floor( (wH - mH) / 2) + scrollTop : scrollTop;
						
		$("#modal_layer")
			.css({
				'top': mTop + 'px',
				'left': '0px'
				});
		
	}
	this.setMedia = function(newMedia) {
	
		var theMedia = newMedia === undefined ? this.media : newMedia;
		
		if(theMedia !== undefined) {
						
			this.media = typeof theMedia == "array" || typeof theMedia == "object" ? theMedia : [theMedia]; 
			
			this.count = this.media.length;
			
		} 
		
	} //
	this.bind = function() {
		
		if(!this.isBound) {
			
			this.requireHTML();
			this.setMedia(); 
			this.mainPieces = $("#curtain, #modal_layer, #close_curtain");
			this.loaderBg = $("#modal_wrap").css('background-image');
			
			var FM = this;
					
			this.mainPieces
				.bind('click', function(e){
					
					e.preventDefault();
									
					FM.close();
					
				});
				
			$("#modal_layer *")
				.bind('click', function(e){
					
					 e.stopPropagation();	
					 		
				});
				
			$(".modal_nav")
				.bind('click', function(e){
					
					e.preventDefault();
					
					if($(this).is("#modal_prev")) {
						
						FM.prev();
					
					} else if($(this).is("#modal_next"))  {
						
						FM.next();
					
					}
				
				});
								
			$(window)
				.bind('keypress', function(e){
					
					// 37, 39, 27 = left, right, esc
										
					if(FM.isOpen) {
						
						var code = (e.keyCode ? e.keyCode : e.which);
												
						if(code == 37) { FM.prev(); } // left
						if(code == 39) { FM.next(); } // right
						if(code == 27) { FM.close(); } // esc
					
					}
					
				});
				
			this.isBound = true;
			
		}
	
	} //
	this.next = function() {
		
		var nextIdx = (this.currentIdx + 1) < this.count ? this.currentIdx + 1 : 0; // loops to first …
		
		this.show(nextIdx);
	
	} //
	this.prev = function() {
	
		var prevIdx = (this.currentIdx - 1) >= 0 ? this.currentIdx - 1 : this.count - 1; // loops to last …	
		
		this.show(prevIdx);
	
	} //
	this.showHideNav = function() {
				
		if(this.count > 1) {
		
			var FM = this,
				subnav = '',
				currentIdx = this.currentIdx;
			
			// build subnav
			for(i=0;i<this.media.length;i++) {
				
				var current = currentIdx == i ? 'active' : '';
				
				subnav += '<a id="modal_subnav_' + i + '" class="modal_subnav_button ' + current + '" rel="' + i + '">' + (i + 1) + '</a>';
				
				if((i + 1) == FM.media.length) {
					
					$("#modal_subnav_wrap").html(subnav);
					
					$(".modal_subnav_button")
						.not(".modal_subnav_button.active")
						.unbind()
						.bind('click', function(e) {
							
							e.preventDefault();
							
							var idx = $(this).attr('rel') * 1;
														
							FM.show(idx);
														
						});
						
					$(".modal_nav, #modal_pagemarker, #modal_subnav_wrap").show();
					
				}
				
			}
					
		} else {
			
			$(".modal_nav, #modal_pagemarker, #modal_subnav_wrap").hide();
		
		}
		
	} //
	this.show = function(idxOrSrc) {
				
		var me = this;
		
		this.isOpen = true;
		
		// bind it up, if it's not already
		if(!this.isBound)
			this.bind();
		
		var media = this.media[0];
		this.currentIdx = 0;
				
		if(idxOrSrc !== undefined) {
			
			media = typeof idxOrSrc == "number" ? this.media[idxOrSrc] : idxOrSrc;
			
			this.currentIdx = typeof idxOrSrc == "number" ? idxOrSrc : this.media.indexOf(idxOrSrc);
						
		}
		
		this.load(media);
		
		this.showHideNav();
		
		this.center();
		
		this.mainPieces
			.fadeIn("fast", function() {
				
				if(me.showCallback !== undefined)
					me.showCallback(); 
				
			});
		
		var pageMarker = (this.currentIdx + 1) + ' / ' + this.count;	
			
		$("#modal_pagemarker").html(pageMarker);
			
											
	} //
	this.close = function() {
		
		var me = this;
		
		this.mainPieces
			.fadeOut("fast", function(){
				
				$("#modal_layer")
					.css({
						top : '-9999px',
						left : '-9999px',
						display : 'block'
					});
				
				if(me.hideCallback !== undefined)
					me.hideCallback();
				
			});	
			
		this.isOpen = false;
	
	} //
	this.requireHTML = function() {
		
		var HTML = '<div id="loading"></div>'
					+ '<div id="curtain">'
					+ '</div>'
					+ '<div id="modal_layer">'
						+ '<div id="modal_uber_wrap">'
							+ '<div id="modal_wrap">'
							+ '</div>'
							+ '<a id="modal_prev" class="modal_nav" href="#" rel="prev"></a>'
							+ '<a id="modal_next" class="modal_nav" href="#" rel="next"></a>'
							+ '<div id="modal_nav_wrap">'
								+ '<div id="modal_caption"></div>'
								+ '<div id="modal_subnav_wrap"></div>'
								+ '<div id="modal_pagemarker"></div>'
							+ '</div>'
						+ '</div>'
					+ '</div>'
					+ '<div id="modal_loader"></div>'
					+ '<a id="close_curtain" href="#">X</a>';
				
		if($("#modal_layer").length <= 0) {
					
			$("body").append(HTML);
			
		}
		
	} //


} // FlexiModal
