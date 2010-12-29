<?php
/*
Plugin Name: Flip
Plugin URI: http://www.velvetcache.org/
Description: Flip your website.
Version: 1.0
Author: John Hobbs
Author URI: http://www.velvetcache.org/
License: MIT
*/

@session_start();

function flip_init () {
	if( unset( $_SESSION['flip'] ) ) { $_SESSION['flip'] = false; }

	if( isset( $_GET['flip'] ) ) {
		$_SESSION['flip'] = ( $_GET['flip'] == '1' );
		
		$path = flip_clean_uri();
	
		unset( $_GET['flip'] );
		if( 0 != count( $_GET ) ) {
			$path .= '?';
			foreach( $_GET as $key => $value )
				$path .= $key . '=' . $value . '&';
		}

		wp_redirect( $path );
		exit();
	}
}


function flip_render () {
	if( $_SESSION['flip'] ) {
?>
<!--// Start Flip - http://www.velvetcache.org/ //-->
<style type="text/css">
	body {
		-webkit-transform: rotate( 180deg );
		-moz-transform: rotate( 180deg );
		-o-transform:rotate( 180deg );
		filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);
		-ms-filter:progid:DXImageTransform.Microsoft.BasicImage(rotation=2);	
	}
</style>
<!--// End Flip - http://www.velvetcache.org/ //-->
<?php
	}
}

function flip_clean_uri () {
	return $path = substr( $_SERVER['REQUEST_URI'], 0, -1 * ( strlen( $_SERVER['QUERY_STRING'] ) + 1 ) );
}

function flip_is_flipped () { return $_SESSION['flip']; }

function flip_url () {
	$_GET['flip'] = ( $_SESSION['flip'] ) ? 0 : 1;
	$qs = '?';
	foreach( $_GET as $key => $value )
		$qs .= $key . '=' . $value . '&';
	unset( $_GET['flip'] );
	return $_SERVER['REQUEST_URI'] . $qs;
}

add_action( 'init', 'flip_init' );
add_action( 'wp_head', 'flip_render' );
