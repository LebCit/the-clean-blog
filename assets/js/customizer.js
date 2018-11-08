/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function ($) {
    
    // Site title and description.
    wp.customize('blogname', function (value) {
        value.bind(function (to) {
            $('.site-title a').text(to);
        });
    });
    wp.customize('blogdescription', function (value) {
        value.bind(function (to) {
            $('.site-description').text(to);
        });
    });

    // Site layouts.
	wp.customize( 'site_layouts', function( value ) {
		value.bind( function( to ) {
			if ( 'sidebar-right' === to ) {
                if ($('#primary').hasClass('col-md-push-4')) {$('#primary').removeClass('col-md-push-4')} // Case sidebar-left to sidebar-right
                $( '#primary' ).addClass( 'col-md-8' ).removeClass( 'col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1' );
                if ($('#secondary').hasClass('col-md-pull-8')) {$('#secondary').removeClass('col-md-pull-8');} // Case sidebar-left to sidebar-right
                $( '#secondary' ).show(); // show() the .sidebar in the customize preview iframe @see the-clean-blog.js - Site layout
            } else if ( 'sidebar-left' === to ) {
                if($('#primary').is(':not(.col-md-8)')) {$('#primary').addClass('col-md-8')} // Case fullwidth to sidebar-left
                $( '#primary' ).addClass( 'col-md-push-4' ).removeClass( 'col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1' ); // Case sidebar-right to sidebar-left or fullwidth to sidebar-left
                $('#secondary').addClass('col-md-pull-8'); // Case sidebar-right to sidebar-left or fullwidth to sidebar-left
                $( '#secondary' ).show(); // show() the .sidebar in the customize preview iframe @see the-clean-blog.js - Site layout
            } else { // ( 'fullwidth' === to )
                if($('#primary').hasClass('col-md-push-4')) {$('#primary').removeClass('col-md-push-4')} // Case sidebar-left to fullwidth
                $( '#primary' ).removeClass( 'col-md-8' ).addClass( 'col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1' ); // Case sidebar-left to fullwidth or sidebar-right to fullwidth
                $( '#secondary' ).hide(); // hide() the .sidebar from the customize preview iframe @see the-clean-blog.js - Site layout
			} 
		} );
    } );
    
    // Posts layouts.
	wp.customize( 'posts_layouts', function( value ) {
		value.bind( function( to ) {
			if ( 'sidebar-right-posts' === to ) {
                if ($('#primary').hasClass('col-md-push-4')) {$('#primary').removeClass('col-md-push-4')} // Case sidebar-left to sidebar-right
                $( '#primary' ).addClass( 'col-md-8' ).removeClass( 'col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1' );
                if ($('#secondary').hasClass('col-md-pull-8')) {$('#secondary').removeClass('col-md-pull-8');} // Case sidebar-left to sidebar-right
                $( '#secondary' ).show(); // show() the .sidebar in the customize preview iframe @see the-clean-blog.js - Site layout
            } else if ( 'sidebar-left-posts' === to ) {
                if($('#primary').is(':not(.col-md-8)')) {$('#primary').addClass('col-md-8')} // Case fullwidth to sidebar-left
                $( '#primary' ).addClass( 'col-md-push-4' ).removeClass( 'col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1' ); // Case sidebar-right to sidebar-left or fullwidth to sidebar-left
                $('#secondary').addClass('col-md-pull-8'); // Case sidebar-right to sidebar-left or fullwidth to sidebar-left
                $( '#secondary' ).show(); // show() the .sidebar in the customize preview iframe @see the-clean-blog.js - Site layout
            } else { // ( 'fullwidth-posts' === to )
                if($('#primary').hasClass('col-md-push-4')) {$('#primary').removeClass('col-md-push-4')} // Case sidebar-left to fullwidth
                $( '#primary' ).removeClass( 'col-md-8' ).addClass( 'col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1' ); // Case sidebar-left to fullwidth or sidebar-right to fullwidth
                $( '#secondary' ).hide(); // hide() the .sidebar from the customize preview iframe @see the-clean-blog.js - Site layout
			} 
		} );
    } );
    
    // Pages layouts.
	wp.customize( 'pages_layouts', function( value ) {
		value.bind( function( to ) {
			if ( 'sidebar-right-pages' === to ) {
                if ($('#primary').hasClass('col-md-push-4')) {$('#primary').removeClass('col-md-push-4')} // Case sidebar-left to sidebar-right
                $( '#primary' ).addClass( 'col-md-8' ).removeClass( 'col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1' );
                if ($('#secondary').hasClass('col-md-pull-8')) {$('#secondary').removeClass('col-md-pull-8');} // Case sidebar-left to sidebar-right
                $( '#secondary' ).show(); // show() the .sidebar in the customize preview iframe @see the-clean-blog.js - Site layout
            } else if ( 'sidebar-left-pages' === to ) {
                if($('#primary').is(':not(.col-md-8)')) {$('#primary').addClass('col-md-8')} // Case fullwidth to sidebar-left
                $( '#primary' ).addClass( 'col-md-push-4' ).removeClass( 'col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1' ); // Case sidebar-right to sidebar-left or fullwidth to sidebar-left
                $('#secondary').addClass('col-md-pull-8'); // Case sidebar-right to sidebar-left or fullwidth to sidebar-left
                $( '#secondary' ).show(); // show() the .sidebar in the customize preview iframe @see the-clean-blog.js - Site layout
            } else { // ( 'fullwidth-pages' === to )
                if($('#primary').hasClass('col-md-push-4')) {$('#primary').removeClass('col-md-push-4')} // Case sidebar-left to fullwidth
                $( '#primary' ).removeClass( 'col-md-8' ).addClass( 'col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1' ); // Case sidebar-left to fullwidth or sidebar-right to fullwidth
                $( '#secondary' ).hide(); // hide() the .sidebar from the customize preview iframe @see the-clean-blog.js - Site layout
			} 
		} );
    } );
})(jQuery);