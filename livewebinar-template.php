<?php
/*
 * Template Name: Live Webinar
 * Description: A Page Template specifically for Live Webinar embeds
 */

// Add custom body class
add_filter( 'body_class', 'custom_body_class' );
function custom_body_class( $classes ) {
	$classes[] = 'live-webinar';
	return $classes;
}

// Display the webinar after the page content
add_action( 'genesis_after_content', 'add_livewebinar' );
function add_livewebinar() {
    
    echo '<div id="embedWidget"></div>';
}

add_action( 'wp_footer', 'add_livewebinar_js' );
function add_livewebinar_js() {
    $current_usernames = wp_get_current_user();
    $fullname = $current_usernames->user_firstname . " " . $current_usernames->user_lastname;
    $license_key = get_metadata( get_the_ID(), 'livewebinar_license_key', true );

    echo "<script type='text/javascript'>
      var _options = {
        '_license_key':'" . $license_key . "',
        '_role_token':'',
        '_registration_token':'',
        '_nickname':'" . $fullname . ">',
        '_widget_containerID':'embedWidget',
        '_widget_width':'100%',
        '_widget_height':'100vh',
      };
      (function() {
        !function(i){
          i.Widget=function(c){
            'function'==typeof c&&i.Widget.__cbs.push(c),
            i.Widget.initialized&&(i.Widget.__cbs.forEach(function(i){i()}),
            i.Widget.__cbs=[])
          },
          i.Widget.__cbs=[]
        }(window);
        var ab = document.createElement('script'); 
        ab.type = 'text/javascript'; 
        ab.async = true;
        ab.src = 'https://embed.livewebinar.com/em?t='+_options['_license_key']+'&'+Object.keys(_options).reduce(function(a,k){
            a.push(k+'='+encodeURIComponent(_options[k]));
            return a
          },[]).join('&');
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ab, s);
      })();
    </script>";

}
genesis();
