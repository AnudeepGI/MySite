/*
 * Verbosa Theme Frontend JS
 * http://www.cryoutcreations.eu/
 *
 * Copyright 2016, Cryout Creations
 * Free to use and abuse under the GPL v3 license.
 */

/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

function fix_sidebar() {
 	var $body, $window, $sidebar, $footer, adminbarOffset, top = false,
 	    bottom = false, windowWidth, windowHeight, lastWindowPos = 0,
 	    topOffset = 0, bodyHeight, sidebarHeight, resizeTimer,
 	    secondary, button;


 	function scroll() {
        windowWidth    = $window.width();
        // if there's no sidebar return
        if ( ! $sidebar.length ) return;

        // disable on responsive
        if ( 1024 >= windowWidth ) {
            top = bottom = false;
            $sidebar.removeAttr( 'style' );
            return;
        }

        sidebarHeight   = $sidebar.height();
        windowHeight    = $window.height();
        bodyHeight      = $body.height();
        mainHeight      = $main.height();
        windowPos       = $window.scrollTop();

        if ( mainHeight <= sidebarHeight ) {
            $sidebar.attr( 'style', 'position: static;' );
            return false;
        }

 		if ( sidebarHeight + adminbarOffset >= windowHeight ) {
 			if ( windowPos > lastWindowPos ) {
 				if ( top ) {
 					top = false;
 					topOffset = ( $sidebar.offset().top > 0 ) ? $sidebar.offset().top - adminbarOffset : 0;
 					$sidebar.attr( 'style', 'top: ' + topOffset + 'px;' );
 				} else if ( ! bottom && windowPos + windowHeight > sidebarHeight + $sidebar.offset().top && sidebarHeight + adminbarOffset < bodyHeight ) {
 					bottom = true;
 					$sidebar.attr( 'style', 'position: fixed; bottom: 0;' );
 				}
 			} else if ( windowPos < lastWindowPos ) {
 				if ( bottom ) {
 					bottom = false;
 					topOffset = ( $sidebar.offset().top > 0 ) ? $sidebar.offset().top - adminbarOffset : 0;
 					$sidebar.attr( 'style', 'top: ' + topOffset + 'px;' );
 				} else if ( ! top && windowPos + adminbarOffset < $sidebar.offset().top ) {
 					top = true;
 					$sidebar.attr( 'style', 'position: fixed;' );
 				}
 			} else {
 				top = bottom = false;
 				topOffset = ( $sidebar.offset().top > 0 ) ? $sidebar.offset().top - adminbarOffset : 0;
 				$sidebar.attr( 'style', 'top: ' + topOffset + 'px;' );
 			}
 		} else {
     			$sidebar.attr( 'style', 'position: fixed;' );
        }

        if ( $footer.children().length ) {
            if ( $sidebar.offset().top + sidebarHeight + adminbarOffset > $footer.offset().top ) $sidebar.attr( 'style', 'position: absolute; bottom: 0;' );
        }
 		lastWindowPos = windowPos;
 	}

    function debuggy() {
        clearTimeout( resizeTimer );
        for ( var i = 1; i < 11; i++ ) {
            setTimeout( scroll, 50 * i );
        }
    }


 	jQuery( document ).ready( function() {
 		$body          = jQuery( document.body );
 		$main          = jQuery( '#main' );
 		$window        = jQuery( window );
 		$sidebar       = jQuery( '#container:not(.one-column) #sidebar' );
		$mainmenu	   = jQuery( '#sidebar #access' );
        $footer        = jQuery( '#colophon' );
 		adminbarOffset = $body.is( '.admin-bar' ) ? jQuery( '#wpadminbar' ).height() : 0;

 		$window
 			.on( 'scroll', scroll )
 			.on( 'resize', function() {
 				clearTimeout( resizeTimer );
 				resizeTimer = setTimeout( scroll, 500 );
 			} );
 		$mainmenu.on( 'click keydown', 'button', scroll );
 		$mainmenu.on( 'click keydown', 'button', debuggy );

 		scroll();

 		for ( var i = 1; i < 6; i++ ) {
 			setTimeout( scroll, 100 * i );
 		}
 	} );

};

fix_sidebar();

jQuery(window).load(function() {

	if ( ( verbosa_settings.masonry == 1 ) && ( verbosa_settings.magazine != 1 ) && ( typeof jQuery.fn.masonry !== 'undefined' ) ) {
		jQuery('#content-masonry').masonry({
			itemSelector: 'article',
			columnWidth: 'article',
			percentPosition: true,
			isRTL: verbosa_settings.rtl,
		});
	}
});

jQuery(document).ready(function() {

	verbosa_mobilemenu_init();
	verbosa_initnav('#access');
	verbosa_initnav('#mobile-menu');

	if ( ( (verbosa_settings.fitvids == 2) && (verbosa_settings.is_mobile == 1) ) || ( verbosa_settings.fitvids == 1 ) )
			jQuery( ".entry-content" ).fitVids();

	/* Searchform - hide overlay on focus */
	jQuery('.searchform .s').focus( function() {
		jQuery(this).parent().addClass('focused');
	});

	jQuery('.searchform .s').blur( function() {
		jQuery(this).parent().removeClass('focused');
	});

	/* Back to top button animation */
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() > 500) {
			jQuery('#toTop').addClass('show2top');
		}
		else {
			jQuery('#toTop').removeClass('show2top');
		}

	});

	jQuery(window).trigger('scroll');

    jQuery('#toTop').click(function(event) {
        event.preventDefault();
        jQuery('html, body').animate({scrollTop: 0}, 500);
        return false;
    });

	/* Social Icons titles */
	jQuery(".socials a").each(function() {
		jQuery(this).attr('title', jQuery(this).children().html());
		jQuery(this).html('');
	});
	

 	/* Close mobile menu on click/tap */
 	jQuery('body').on('click','#mobile-nav a > span', function() {
		jQuery('#nav-cancel').trigger('click');
 	});

	/* Detect and apply custom class for Safari */
	if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
		jQuery('body').addClass('safari');
	}

	/* Add body class if masonry is used on page */
	if ( jQuery('#content-masonry').length > 0 ) {
		jQuery('body').addClass('with-masonry');
	}

	/* Add <span> container to all images */
	jQuery('figure img').load(function() {
    jQuery(this).wrap(function(){
      return '<span class="image-wrap" />';
    });
  });



});
/* end document.ready */

/* Mobile Menu */
function verbosa_mobilemenu_init() {

	jQuery("#nav-toggle").click(function(){
		jQuery("#mobile-menu").show().animate({left: "0"}, 500);
		jQuery('body').addClass("noscroll");
	});

	jQuery("#nav-cancel").click(function(){
		jQuery("#mobile-menu").animate({left: "100%"},500,function(){jQuery(this).css("left","-100%").hide();});
		jQuery('body').removeClass("noscroll");
	});

}

/* Add submenus to the primary navigation */
function verbosa_initnav(selector) {

	container = jQuery(selector);

	// Add dropdown toggle that display child menu items.
	container.find( '.menu-item-has-children > a > span' ).append( '<button class="dropdown-toggle" aria-expanded="false"></button>' );
	container.find( '.page_item_has_children > a > span' ).append( '<button class="dropdown-toggle" aria-expanded="false"></button>' );

	//Toggle buttons and submenu items with active children menu items.
	container.find( '.current-menu-ancestor > a > span > button, .current-page-ancestor > a > span > button' ).addClass( 'toggle-on' );
	container.find( '.current-menu-ancestor > .sub-menu, .current-page-ancestor > .sub-menu, .current-menu-ancestor .children, .current-page-ancestor .children' ).show(0).addClass( 'toggled-on' );

	container.find( '.dropdown-toggle' ).click( function( e ) {
		e.preventDefault();
		var _this = jQuery( this ).parent().parent();
		_this.toggleClass( 'toggle-on' );
		if ( _this.hasClass( 'toggle-on') ) {
			_this.next( '.children, .sub-menu' ).show(0).addClass( 'toggled-on' );
		}
		else {
			_this.next( '.children, .sub-menu' ).removeClass( 'toggled-on' );
		}

		//_this.parent().find( 'a' ).toggleClass( 'toggled-on' );
		_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
		return false;
	} );

}

/*jshint browser:true */
/*!
* FitVids 1.1
*
* Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
*/

/* FitVids 1.1*/
;(function( $ ){

  'use strict';

  $.fn.fitVids = function( options ) {
    var settings = {
      customSelector: null,
      ignore: null
    };

    if(!document.getElementById('fit-vids-style')) {
      // appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
      var head = document.head || document.getElementsByTagName('head')[0];
      var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
      var div = document.createElement("div");
      div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
      head.appendChild(div.childNodes[1]);
    }

    if ( options ) {
      $.extend( settings, options );
    }

    return this.each(function(){
      var selectors = [
        'iframe[src*="player.vimeo.com"]',
        'iframe[src*="youtube.com"]',
        'iframe[src*="youtube-nocookie.com"]',
        'iframe[src*="kickstarter.com"][src*="video.html"]',
        'object',
        'embed'
      ];

      if (settings.customSelector) {
        selectors.push(settings.customSelector);
      }

      var ignoreList = '.fitvidsignore';

      if(settings.ignore) {
        ignoreList = ignoreList + ', ' + settings.ignore;
      }

      var $allVideos = $(this).find(selectors.join(','));
      $allVideos = $allVideos.not('object object'); // SwfObj conflict patch
      $allVideos = $allVideos.not(ignoreList); // Disable FitVids on this video.

      $allVideos.each(function(){
        var $this = $(this);
        if($this.parents(ignoreList).length > 0) {
          return; // Disable FitVids on this video.
        }
        if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
        if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width'))))
        {
          $this.attr('height', 9);
          $this.attr('width', 16);
        }
        var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
            width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
            aspectRatio = height / width;
        if(!$this.attr('name')){
          var videoName = 'fitvid' + $.fn.fitVids._count;
          $this.attr('name', videoName);
          $.fn.fitVids._count++;
        }
        $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+'%');
        $this.removeAttr('height').removeAttr('width');
      });
    });
  };

  // Internal counter for unique video names.
  $.fn.fitVids._count = 0;

// Works with either jQuery or Zepto
})( window.jQuery || window.Zepto );


/* Returns the version of Internet Explorer or a -1
  (indicating the use of another browser). */
function getInternetExplorerVersion()
{
  var rv = -1; /* assume not IE. */
  if (navigator.appName == 'Microsoft Internet Explorer')
  {
    var ua = navigator.userAgent;
    var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
    if (re.exec(ua) != null)
      rv = parseFloat( RegExp.$1 );
  }
  return rv;
}

/* FIN */
