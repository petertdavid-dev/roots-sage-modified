/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Responsive bkgd
  function responsiveBackground() {

    var bgcontain = jQuery( '.rwd-background' );

    // if( !$('body').hasClass('ie8') ) {
    console.log('hit');

    bgcontain.each( function( i ) {

      if ( $( this ).hasClass( 'rwd-background--blurred' ) ) {
        $( this ).removeClass( 'rwd-background--blurred' );
      }

      var imgSmall = $( this ).data( 'rwd-small' );
      var imgMedium = $( this ).data( 'rwd-medium' );
      var imgLarge = $( this ).data( 'rwd-large' );
      var imgMediumX2 = $( this ).data( 'rwd-mediumx2' );
      var imgXL = $( this ).data( 'rwd-xl' );
      var imgLargeX2 = $( this ).data( 'rwd-largex2' );
      var imgXlX2 = $( this ).data( 'rwd-xlx2' );

      // rwd-small
      if ( Modernizr.mq( '(max-width: 400px)' ) ) {

        if ( jQuery( this ).css( 'background-image' ) !== 'url(' + imgSmall + ')' ) {
          jQuery( this ).css( 'background-image', 'url(' + imgSmall + ')' );
        }

        // rwd-medium
      } else if ( Modernizr.mq( '(max-width: 800px)' ) ) {

        if ( jQuery( this ).css( 'background-image' ) !== 'url(' + imgMedium + ')' ) {
          jQuery( this ).css( 'background-image', 'url(' + imgMedium + ')' );
        }

        // rwd-large
      } else if ( Modernizr.mq( '(max-width: 1200px)' ) ) {

        if ( jQuery( this ).css( 'background-image' ) !== 'url(' + imgLarge + ')' ) {
          jQuery( this ).css( 'background-image', 'url(' + imgLarge + ')' );
        }

        // rwd-mediumx2
      } else if ( Modernizr.mq( '(max-width: 1600px)' ) ) {

        if ( jQuery( this ).css( 'background-image' ) !== 'url(' + imgMediumX2 + ')' ) {
          jQuery( this ).css( 'background-image', 'url(' + imgMediumX2 + ')' );
        }

        // rwd-xl
      } else if ( Modernizr.mq( '(max-width: 2000px)' ) ) {

        if ( jQuery( this ).css( 'background-image' ) !== 'url(' + imgXL + ')' ) {
          jQuery( this ).css( 'background-image', 'url(' + imgXL + ')' );
        }

        // rwd-largex2
      } else if ( Modernizr.mq( '(max-width: 2400px)' ) ) {

        if ( jQuery( this ).css( 'background-image' ) !== 'url(' + imgLargeX2 + ')' ) {
          jQuery( this ).css( 'background-image', 'url(' + imgLargeX2 + ')' );
        }

        // rwd-xlx2
      } else if ( Modernizr.mq( '(max-width: 4000px)' ) ) {

        if ( jQuery( this ).css( 'background-image' ) !== 'url(' + imgXlX2 + ')' ) {
          jQuery( this ).css( 'background-image', 'url(' + imgXlX2 + ')' );
        }

      } else {

        if ( jQuery( this ).css( 'background-image' ) !== 'url(' + imgXlX2 + ')' ) {
          jQuery( this ).css( 'background-image', 'url(' + imgXlX2 + ')' );
        }

      }

    } );

    // }

  }


  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages
        responsiveBackground();
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  $( window ).resize( function() {
    responsiveBackground();
  } );

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
