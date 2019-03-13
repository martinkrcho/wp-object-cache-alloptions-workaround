<?php
/**
 * Plugin Name: Object Cache Workaround for alloptions
 * Description: Fixes a race condition in alloptions caching
 * Author:      Martin Krcho
 * Author URI:  http://devstudio.sk/
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

defined( 'ABSPATH' ) or die( 'nothing here' );

/**
 * Fix a race condition in alloptions caching
 *
 * See https://core.trac.wordpress.org/ticket/31245
 */
function _wpcom_vip_maybe_clear_alloptions_cache( $option ) {

	if ( ! wp_installing() ) {

		$alloptions = wp_load_alloptions(); //alloptions should be cached at this point
		if ( isset( $alloptions[ $option ] ) ) { //only if option is among alloptions
			wp_cache_delete( 'alloptions', 'options' );
		}

	}

}

add_action( 'added_option', '_wpcom_vip_maybe_clear_alloptions_cache' );
add_action( 'updated_option', '_wpcom_vip_maybe_clear_alloptions_cache' );
add_action( 'deleted_option', '_wpcom_vip_maybe_clear_alloptions_cache' );
