<?php
/**
 * Plugin Name: Caldera Fix
 * Plugin URI: https://github.com/zacnoo/caldera-fix
 * Description: Fix for Caldera forms mime type.
 * Version: 0.3.1
 * Author: Zack Palmer (zacnoo)
 */

/**
 * Support for 'text/plain' as the secondary(?) mime type of .json files
 */
add_filter( 'wp_check_filetype_and_ext', 'wpse323750_secondary_mime', 99, 4 );    
function wpse323750_secondary_mime( $check, $file, $filename, $mimes ) {
    if ( empty( $check['ext'] ) && empty( $check['type'] ) ) {
        $secondary_mime = [ 'json' => 'application/json' ];
        // Run another check, but only for our secondary mime and not on core mime types.
        remove_filter( 'wp_check_filetype_and_ext', 'wpse323750_secondary_mime', 99, 4 );
        $check = wp_check_filetype_and_ext( $file, $filename, $secondary_mime );
        add_filter( 'wp_check_filetype_and_ext', 'wpse323750_secondary_mime', 99, 4 );
    }
    return $check;
}
 
 
function my_theme_custom_upload_mimes( $existing_mimes ) {
	// Add json to the list of mime types.
	$existing_mimes['json'] = 'application/json';

	// Return the array back to the function with our added mime type.
	return $existing_mimes;
}
add_filter( 'mime_types', 'my_theme_custom_upload_mimes' );