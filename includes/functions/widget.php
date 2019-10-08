<?php
/**
 * Widget functionality init.
 *
 * @package CustomApiDataWoocommerceUsers
 */

namespace CustomApiDataWoocommerceUsers\Widget;

/**
 * Default setup routine
 *
 * @return void
 */
function setup() {
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	add_action(
		'widgets_init',
		function() {
			register_widget( 'CustomApiDataWoocommerceUsers_Widget' );
		}
	);
}
