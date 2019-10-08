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
	add_action( 'template_redirect', $n( 'cadwu_save_custom_data' ) );
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
	$user = wp_get_current_user();
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
			<textarea class="custom-data-textarea" name="custom_return_data" id="custom_return_data"><?php echo esc_html( $user->custom_return_data ); ?></textarea>
		</p>
		<p class="form-row form-row-first">
			<input type="button" class="button" id="save_data_button" value="<?php esc_html_e( 'Get data', 'custom-api-data-woocommerce-users' ); ?>">
		</p>
		<p class="form-row form-row-last">
			<input type="submit" class="button" id="save_form_button" name="save_custom_data" value="<?php esc_html_e( 'Save', 'custom-api-data-woocommerce-users' ); ?>">
		</p>
		<div class="clear"></div>
		<?php wp_nonce_field( 'save_custom_data', 'save-custom_data-nonce' ); ?>
		<input type="hidden" name="action" value="save_custom_data" />
	</form>
	<?php
}

/**
 * Save Form data on custom tab.
 */
function cadwu_save_custom_data() {
	$nonce_value = wc_get_var( $_REQUEST['save-custom_data-nonce'], wc_get_var( $_REQUEST['_wpnonce'], '' ) );

	if ( ! wp_verify_nonce( $nonce_value, 'save_custom_data' ) ) {
		return;
	}

	if ( empty( $_POST['action'] ) || 'save_custom_data' !== $_POST['action'] ) {
		return;
	}

	wc_nocache_headers();

	$user_id = get_current_user_id();

	if ( $user_id <= 0 ) {
		return;
	}

	update_user_meta( $user_id, 'custom_data', ! empty( $_POST['custom_data'] ) ? sanitize_textarea_field( $_POST['custom_data'] ) : '' );
	update_user_meta( $user_id, 'custom_return_data', ! empty( $_POST['custom_return_data'] ) ? sanitize_textarea_field( $_POST['custom_return_data'] ) : '' );
}
