<?php
/**
 * Tab related functionality.
 *
 * @package CustomApiDataWoocommerceUsers
 */

namespace CustomApiDataWoocommerceUsers\Tab;

/**
 * Default setup routine
 *
 * @return void
 */
function setup() {
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	add_action( 'init', $n( 'cadwu_add_tab_endpoint' ) );
	add_filter( 'query_vars', $n( 'cadwu_tab_query_vars' ), 0 );
	add_filter( 'woocommerce_account_menu_items', $n( 'cadwu_tab_link' ) );
	add_action( 'woocommerce_account_custom-data_endpoint', $n( 'cadwu_tab_content' ) );
}

/**
 * Add custom tab endpoint.
 *
 * @return void
 */
function cadwu_add_tab_endpoint() {
	add_rewrite_endpoint( 'custom-data', EP_ROOT | EP_PAGES );
}

/**
 * Add custom tab query var.
 *
 * @param string $vars Query variable name.
 * @return void
 */
function cadwu_tab_query_vars( $vars ) {
	$vars[] = 'custom-data';
	return $vars;
}

/**
 * Add custom tab title.
 *
 * @param array $items wc_get_account_menu_items items array.
 * @return array
 */
function cadwu_tab_link( $items ) {
	$items['custom-data'] = 'Custom Data';
	return $items;
}

/**
 * Add content to custom tab.
 */
function cadwu_tab_content() {
	?>
	<h3><?php esc_html_e( 'Custom Data', 'custom-api-data-woocommerce-users' ); ?></h3>
	<form class="woocommerce-EditCustomDataForm edit-custom-data" method="post">
		<p class="form-row form-row-wide">
			<label for="custom_data">
				<?php esc_html_e( 'Add your profile custom data, use any alphanumeric characters. Each line will be treated as an element in the array.', 'custom-api-data-woocommerce-users' ); ?>
			</label>
			<textarea class="custom-data-textarea" name="custom_data" id="custom_data"><?php echo esc_html( $user->custom_data ); ?></textarea>
		</p>
		<p class="form-row form-row-wide">
			<label for="custom_data">
				<?php esc_html_e( 'API return data', 'custom-api-data-woocommerce-users' ); ?>
			</label>
			<textarea class="custom-data-textarea" name="custom_return_data" id="custom_return_data" disabled><?php echo esc_html( $user->custom_return_data ); ?></textarea>
		</p>
		<p class="form-row form-row-first">
			<input type="button" class="button" value="<?php esc_html_e( 'Save', 'custom-api-data-woocommerce-users' ); ?>">
		</p>
		<div class="clear"></div>
	</form>
	<?php
}
